<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\RolModel;
use App\Models\RespuestaModel;
use App\Models\EncuestaModel; // Importamos el modelo de encuestas

class Operador_User extends BaseController
{
    protected $usuarioModel;
    protected $rolModel;
    protected $respuestaModel;
    protected $encuestaModel; // Propiedad para el modelo de encuestas
    protected $idRolEncuestador;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->rolModel     = new RolModel();
        $this->respuestaModel = new RespuestaModel();
        $this->encuestaModel = new EncuestaModel(); // Inicializamos el modelo de encuestas
        
        // Obtener el ID del rol 'Encuestador' al inicializar el controlador.
        $rolEncuestador = $this->rolModel->where('nombre_rol', 'Encuestador')->first();
        if ($rolEncuestador) {
            $this->idRolEncuestador = $rolEncuestador['id_rol'];
        } else {
            // Manejar el caso en que el rol no existe.
            $this->idRolEncuestador = null; 
        }
    }
    
    /**
     * Muestra la tabla de usuarios encuestadores y aplica el filtro de búsqueda.
     */
    public function index()
    {
        // Obtener el término de búsqueda de la URL
        $searchTerm = $this->request->getGet('search_term');
        
        // Si el rol 'Encuestador' no existe, no se pueden mostrar usuarios.
        if ($this->idRolEncuestador === null) {
            return view('operador/usuarios', [
                'usuarios' => [],
                'error' => 'El rol "Encuestador" no fue encontrado en la base de datos.'
            ]);
        }
        
        // Iniciar la consulta
        $query = $this->usuarioModel->where('id_rol', $this->idRolEncuestador);

        // Aplicar la búsqueda por nombre si se proporcionó un término
        if (!empty($searchTerm)) {
            $query = $query->like('nombre', $searchTerm);
        }

        // Obtener los usuarios filtrados
        $usuariosEncuestadores = $query->findAll();
        
        // --- INICIO DE LA LÓGICA MODIFICADA PARA EL CONTEO DE RESPUESTAS ACTIVAS ---
        
        // 1. Obtener el conteo de respuestas por usuario solo para encuestas activas.
        $conteoRespuestas = $this->respuestaModel
                                ->select('respuestas.id_usuario, COUNT(respuestas.id_respuesta) as respuestas_contestadas')
                                ->join('encuestas', 'encuestas.id_encuesta = respuestas.id_encuesta')
                                ->where('encuestas.activa', 1) // Condición para encuestas activas
                                ->groupBy('respuestas.id_usuario')
                                ->findAll();
        
        // 2. Convertir el resultado a un array asociativo para una búsqueda rápida.
        $conteoMap = [];
        foreach ($conteoRespuestas as $conteo) {
            $conteoMap[$conteo['id_usuario']] = $conteo['respuestas_contestadas'];
        }
        
        // 3. Añadir el conteo de respuestas a cada usuario en la lista.
        foreach ($usuariosEncuestadores as &$usuario) {
            // Asigna el conteo del mapa, si no existe el usuario, asigna 0.
            $usuario['respuestas_contestadas'] = $conteoMap[$usuario['id_usuario']] ?? 0;
        }
        // Desactivamos la referencia para evitar efectos secundarios.
        unset($usuario);
        
        // --- FIN DE LA LÓGICA MODIFICADA ---

        $data = [
            'usuarios' => $usuariosEncuestadores,
            'searchTerm' => $searchTerm // Pasar el término de búsqueda a la vista para mantenerlo en el campo
        ];
        
        // Carga la vista principal (read) con la lista de usuarios.
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
        if ($this->idRolEncuestador === null) {
            return redirect()->back()->withInput()->with('error', 'No se puede crear el usuario porque el rol "Encuestador" no existe.');
        }
        
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

        // Generar usuario y contraseña de forma aleatoria
        $usuario = strtolower(substr($this->request->getPost('nombre'), 0, 1) . $this->request->getPost('apellido_paterno'));
        $contrasena = $this->generateRandomPassword();

        // Verificar si el nombre de usuario ya existe
        $i = 1;
        $usuarioOriginal = $usuario;
        while ($this->usuarioModel->where('usuario', $usuario)->first()) {
            $usuario = $usuarioOriginal . $i;
            $i++;
        }
        
        $data = [
            'nombre'           => $this->request->getPost('nombre'),
            'apellido_paterno' => $this->request->getPost('apellido_paterno'),
            'apellido_materno' => $this->request->getPost('apellido_materno'),
            'telefono'         => $this->request->getPost('telefono'),
            'usuario'          => $usuario,
            'contrasena'       => password_hash($contrasena, PASSWORD_BCRYPT),
            'foto'             => $fotoFileName,
            'id_rol'           => $this->idRolEncuestador, // Asignación automática del rol 'Encuestador'
        ];

        if ($this->usuarioModel->insert($data)) {
            return redirect()->to(base_url('operador_user/index'))
                             ->with('message', 'Encuestador creado correctamente.')
                             ->with('usuario_creado', $usuario)
                             ->with('contrasena_creada', $contrasena);
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo crear el encuestador. Inténtalo de nuevo.');
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
    public function delete($id = null)
    {
        $usuarioExistente = $this->usuarioModel->find($id);

        if (!$usuarioExistente) {
            return redirect()->to(base_url('operador_user/index'))->with('error', 'Usuario no encontrado para eliminar.');
        }

        // Eliminar la foto si existe
        if (!empty($usuarioExistente['foto']) && file_exists(FCPATH . 'public/img_user/' . $usuarioExistente['foto'])) {
            unlink(FCPATH . 'public/img_user/' . $usuarioExistente['foto']);
        }

        if ($this->usuarioModel->delete($id)) {
            return redirect()->to(base_url('operador_user/index'))->with('message', 'Usuario eliminado correctamente.');
        } else {
            return redirect()->back()->with('error', 'No se pudo eliminar el usuario. Inténtalo de nuevo.');
        }
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
