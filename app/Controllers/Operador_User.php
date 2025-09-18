<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\RolModel;
use App\Models\RespuestaModel;
use App\Models\EncuestaModel;
// --- NUEVO: Se importa el modelo para el monitoreo ---
use App\Models\MonitoreoModel;

class Operador_User extends BaseController
{
    protected $usuarioModel;
    protected $rolModel;
    protected $respuestaModel;
    protected $encuestaModel;
    // --- NUEVO: Propiedad para el nuevo modelo ---
    protected $monitoreoModel;
    protected $idRolEncuestador;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->rolModel     = new RolModel();
        $this->respuestaModel = new RespuestaModel();
        $this->encuestaModel = new EncuestaModel();
        // --- NUEVO: Se inicializa el modelo de monitoreo ---
        $this->monitoreoModel = new MonitoreoModel();
        
        $rolEncuestador = $this->rolModel->where('nombre_rol', 'Encuestador')->first();
        if ($rolEncuestador) {
            $this->idRolEncuestador = $rolEncuestador['id_rol'];
        } else {
            $this->idRolEncuestador = null; 
        }
    }
    
    /**
     * Muestra la tabla de usuarios encuestadores y aplica el filtro de búsqueda.
     */
    public function index()
    {
        $searchTerm = $this->request->getGet('search_term');
        
        if ($this->idRolEncuestador === null) {
            return view('operador/usuarios', [
                'usuarios' => [],
                'error' => 'El rol "Encuestador" no fue encontrado en la base de datos.'
            ]);
        }
        
        // --- MODIFICACIÓN 1: FILTRAR POR CREADOR ---
        // Se obtiene el ID del operador que ha iniciado sesión.
        $idOperadorActual = session()->get('usuario')['id_usuario'];

        // La consulta ahora filtra por el rol Y por el ID del creador.
        $query = $this->usuarioModel
                        ->where('id_rol', $this->idRolEncuestador)
                        ->where('creado_por_id', $idOperadorActual);

        if (!empty($searchTerm)) {
            $query->like('nombre', $searchTerm);
        }

        $usuariosEncuestadores = $query->findAll();
        
        // El resto de la lógica para el conteo de respuestas no cambia.
        if (!empty($usuariosEncuestadores)) {
            $conteoRespuestas = $this->respuestaModel
                                    ->select('respuestas.id_usuario, COUNT(respuestas.id_respuesta) as respuestas_contestadas')
                                    ->join('encuestas', 'encuestas.id_encuesta = respuestas.id_encuesta')
                                    ->where('encuestas.activa', 1)
                                    ->groupBy('respuestas.id_usuario')
                                    ->findAll();
            
            $conteoMap = array_column($conteoRespuestas, 'respuestas_contestadas', 'id_usuario');
            
            foreach ($usuariosEncuestadores as &$usuario) {
                $usuario['respuestas_contestadas'] = $conteoMap[$usuario['id_usuario']] ?? 0;
            }
            unset($usuario);
        }
        
        $data = [
            'usuarios' => $usuariosEncuestadores,
            'searchTerm' => $searchTerm
        ];
        
        return view('operador/usuarios', $data);
    }
    
    /**
     * Muestra el formulario para crear un nuevo usuario encuestador.
     */
    public function create()
    {
        if ($this->idRolEncuestador === null) {
            return redirect()->to(base_url('operador_user/index'))->with('error', 'El rol "Encuestador" no existe. No se puede crear el usuario.');
        }

        // Carga la vista para el formulario de creación.
        return view('operador/create_usuarios');
    }
    
    /**
     * Procesa la creación de un nuevo usuario con rol "encuestador".
     */
    public function store()
    {
        // ... (Tu código de validación, manejo de foto y generación de usuario/contraseña no cambia) ...
         $rules = [
            'nombre'           => 'required|alpha_space|min_length[3]|max_length[100]',
            'apellido_paterno' => 'required|alpha_space|min_length[3]|max_length[100]',
            'apellido_materno' => 'permit_empty|alpha_space|max_length[100]',
            'telefono'         => 'permit_empty|numeric|max_length[10]',
            'foto'             => 'if_exist|uploaded[foto]|max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fotoFileName = null;
        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $fotoFileName = $fotoFile->getRandomName();
            $fotoFile->move(FCPATH . 'public/img_user', $fotoFileName);
        }

        $nombreLimpio = preg_replace('/[^a-zA-Z0-9]/', '', $this->request->getPost('apellido_paterno'));
        $usuario = strtolower(substr($this->request->getPost('nombre'), 0, 1) . $nombreLimpio);
        $contrasena = $this->generateRandomPassword();

        $i = 1;
        $usuarioOriginal = $usuario;
        while ($this->usuarioModel->where('usuario', $usuario)->first()) {
            $usuario = $usuarioOriginal . $i;
            $i++;
        }
        
        // --- MODIFICACIÓN 2: GUARDAR EL CREADOR ---
        // Se obtiene el ID del operador que está creando al usuario.
        $idOperadorCreador = session()->get('usuario')['id_usuario'];

        $data = [
            'nombre'           => $this->request->getPost('nombre'),
            'apellido_paterno' => $this->request->getPost('apellido_paterno'),
            'apellido_materno' => $this->request->getPost('apellido_materno'),
            'telefono'         => $this->request->getPost('telefono'),
            'usuario'          => $usuario,
            'contrasena'       => password_hash($contrasena, PASSWORD_BCRYPT),
            'foto'             => $fotoFileName,
            'id_rol'           => $this->idRolEncuestador,
            'creado_por_id'    => $idOperadorCreador, // Se guarda el ID del creador.
        ];

        if ($this->usuarioModel->insert($data)) {
            return redirect()->to(base_url('operador_user'))
                             ->with('message', 'Encuestador creado correctamente.')
                             ->with('usuario_creado', $usuario)
                             ->with('contrasena_creada', $contrasena);
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo crear el encuestador.');
        }
    }

    /**
     * Muestra el formulario para editar un usuario encuestador existente.
     */
    public function edit($id = null)
    {
        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            return redirect()->to(base_url('operador_user/index'))->with('error', 'Usuario no encontrado.');
        }

        $data = [
            'usuario' => $usuario,
        ];

        // Carga la vista para el formulario de edición.
        return view('operador/update_usuarios', $data);
    }
    
    /**
     * Procesa la actualización de un usuario encuestador.
     */
    public function update($id = null)
    {
        $usuarioExistente = $this->usuarioModel->find($id);
        if (!$usuarioExistente) {
            return redirect()->to(base_url('operador_user/index'))->with('error', 'Usuario no encontrado para actualizar.');
        }

        $rules = [
            'nombre'           => 'required|alpha_space|min_length[3]|max_length[100]',
            'apellido_paterno' => 'required|alpha_space|min_length[3]|max_length[100]',
            'apellido_materno' => 'permit_empty|alpha_space|max_length[100]',
            'telefono'         => 'permit_empty|numeric|max_length[10]',
            'usuario'          => 'required|min_length[5]|max_length[100]|is_unique[usuarios.usuario,id_usuario,' . $id . ']',
        ];

        if ($this->request->getPost('contrasena')) {
            $rules['contrasena'] = 'required|min_length[8]';
        }

        if ($this->request->getFile('foto') && $this->request->getFile('foto')->isValid()) {
            $rules['foto'] = 'uploaded[foto]|max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fotoFileName = $usuarioExistente['foto'];
        $fotoFile = $this->request->getFile('foto');

        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            if (!empty($usuarioExistente['foto']) && file_exists(FCPATH . 'public/img_user/' . $usuarioExistente['foto'])) {
                unlink(FCPATH . 'public/img_user/' . $usuarioExistente['foto']);
            }
            $fotoFileName = $fotoFile->getRandomName();
            $fotoFile->move(FCPATH . 'public/img_user', $fotoFileName);
        }

        $data = [
            'nombre'           => $this->request->getPost('nombre'),
            'apellido_paterno' => $this->request->getPost('apellido_paterno'),
            'apellido_materno' => $this->request->getPost('apellido_materno'),
            'telefono'         => $this->request->getPost('telefono'),
            'usuario'          => $this->request->getPost('usuario'),
            'id_rol'           => $this->idRolEncuestador, // Mantiene el rol 'Encuestador'
            'foto'             => $fotoFileName,
        ];

        if ($this->request->getPost('contrasena')) {
            $data['contrasena'] = password_hash($this->request->getPost('contrasena'), PASSWORD_BCRYPT);
        }

        if ($this->usuarioModel->update($id, $data)) {
            return redirect()->to(base_url('operador_user/index'))->with('message', 'Usuario actualizado correctamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo actualizar el usuario. Inténtalo de nuevo.');
        }
    }

    /**
     * Elimina un usuario.
     */
    

    // ====================================================================
    //  NUEVO MÉTODO PARA MOSTRAR EL MAPA DEL ENCUESTADOR
    // ====================================================================
    /**
     * Muestra un mapa con las ubicaciones de las respuestas de un encuestador.
     * @param int $idEncuestador El ID del usuario encuestador.
     */
    public function verMapa($idEncuestador)
    {
        $encuestador = $this->usuarioModel->find($idEncuestador);
        if (!$encuestador) {
            return redirect()->to(base_url('operador_user'))->with('error', 'Encuestador no encontrado.');
        }

        $googleConfig = config(\Config\Google::class);
        $data['google_maps_api_key'] = $googleConfig->apiKey;
        $data['encuestador'] = $encuestador;
        
        return view('operador/ver_mapa_encuestador', $data);
    }

    public function obtener_ubicaciones()
    {
        // Medida de seguridad: solo usuarios con sesión pueden acceder
        if (!session()->get('isLoggedIn')) {
            return $this->response->setStatusCode(403, 'Acceso Prohibido');
        }

        // Se reescribe la consulta para ser más explícita y evitar errores
        $builder = $this->monitoreoModel
            ->select('
                monitoreo_ubicacion.id_usuario, 
                monitoreo_ubicacion.latitud, 
                monitoreo_ubicacion.longitud, 
                monitoreo_ubicacion.ultima_actualizacion, 
                usuarios.nombre, 
                usuarios.apellido_paterno, 
                usuarios.foto
            ')
            ->join('usuarios', 'usuarios.id_usuario = monitoreo_ubicacion.id_usuario');
            
          
            
        $ubicaciones = $builder->findAll(); // Usamos findAll() que es más directo en este caso
        
        return $this->response->setJSON($ubicaciones);
    }

    /**
     * Genera una contraseña aleatoria de 10 caracteres.
     */
    private function generateRandomPassword($length = 10)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
        $password = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, $max)];
        }
        return $password;
    }
}
