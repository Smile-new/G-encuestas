<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\RolModel;
use App\Models\RespuestaModel;
use App\Models\EncuestaModel;
use App\Models\MonitoreoModel;

class Operador_User extends BaseController
{
    protected $usuarioModel;
    protected $rolModel;
    protected $respuestaModel;
    protected $encuestaModel;
    protected $monitoreoModel;
    protected $idRolEncuestador;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->rolModel     = new RolModel();
        $this->respuestaModel = new RespuestaModel();
        $this->encuestaModel = new EncuestaModel();
        $this->monitoreoModel = new MonitoreoModel();
        
        $rolEncuestador = $this->rolModel->where('nombre_rol', 'Encuestador')->first();
        if ($rolEncuestador) {
            $this->idRolEncuestador = $rolEncuestador['id_rol'];
        } else {
            $this->idRolEncuestador = null; 
        }
    }
    
    public function index()
    {
        $searchTerm = $this->request->getGet('search_term');
        
        if ($this->idRolEncuestador === null) {
            return view('operador/usuarios', [
                'usuarios' => [],
                'error' => 'El rol "Encuestador" no fue encontrado en la base de datos.'
            ]);
        }
        
        $idOperadorActual = session()->get('usuario')['id_usuario'];

        $query = $this->usuarioModel
                        ->where('id_rol', $this->idRolEncuestador)
                        ->where('creado_por_id', $idOperadorActual);

        if (!empty($searchTerm)) {
            $query->like('nombre', $searchTerm);
        }

        $usuariosEncuestadores = $query->findAll();
        
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
    
    public function create()
    {
        return view('operador/create_usuarios');
    }
    
    /**
     * Procesa la creación de un nuevo usuario con rol "encuestador".
     * VERSIÓN CORREGIDA: Usa los datos del formulario.
     */
    public function store()
    {
        $rules = [
            'nombre'           => 'required|alpha_space|min_length[3]|max_length[100]',
            'apellido_paterno' => 'required|alpha_space|min_length[3]|max_length[100]',
            'usuario'          => 'required|alpha_numeric|min_length[5]|max_length[100]|is_unique[usuarios.usuario]',
            'contrasena'       => 'required|min_length[8]',
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

        // --- INICIO DE LA MODIFICACIÓN ---
        // Se obtienen el usuario y contraseña directamente del formulario
        $usuario = $this->request->getPost('usuario');
        $contrasena = $this->request->getPost('contrasena');
        // --- FIN DE LA MODIFICACIÓN ---

        $data = [
            'nombre'           => $this->request->getPost('nombre'),
            'apellido_paterno' => $this->request->getPost('apellido_paterno'),
            'apellido_materno' => $this->request->getPost('apellido_materno'),
            'telefono'         => $this->request->getPost('telefono'),
            'foto'             => $fotoFileName,
            'id_rol'           => $this->idRolEncuestador,
            'creado_por_id'    => session()->get('usuario')['id_usuario'],
            'usuario'          => $usuario, // Se guarda el usuario del formulario
            'contrasena'       => password_hash($contrasena, PASSWORD_BCRYPT), // Se guarda la contraseña del formulario
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

    public function edit($id = null)
    {
        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            return redirect()->to(base_url('operador_user'))->with('error', 'Usuario no encontrado.');
        }

        $idOperadorActual = session()->get('usuario')['id_usuario'];
        if ($usuario['creado_por_id'] != $idOperadorActual) {
             return redirect()->to(base_url('operador_user'))->with('error', 'No tienes permiso para editar este usuario.');
        }

        $data = ['usuario' => $usuario];
        return view('operador/update_usuarios', $data);
    }
    
    public function update($id = null)
    {
        $usuarioExistente = $this->usuarioModel->find($id);
        if (!$usuarioExistente) {
            return redirect()->to(base_url('operador_user'))->with('error', 'Usuario no encontrado.');
        }
        
        $idOperadorActual = session()->get('usuario')['id_usuario'];
        if ($usuarioExistente['creado_por_id'] != $idOperadorActual) {
             return redirect()->to(base_url('operador_user'))->with('error', 'No tienes permiso para actualizar este usuario.');
        }

        $rules = [
            'nombre'           => 'required|alpha_space|min_length[3]|max_length[100]',
            'apellido_paterno' => 'required|alpha_space|min_length[3]|max_length[100]',
            'usuario'          => 'required|min_length[5]|max_length[100]|is_unique[usuarios.usuario,id_usuario,' . $id . ']',
        ];

        if ($this->request->getPost('contrasena')) {
            $rules['contrasena'] = 'min_length[8]'; // No es 'required' en la actualización
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
            'foto'             => $fotoFileName,
        ];

        if ($this->request->getPost('contrasena')) {
            $data['contrasena'] = password_hash($this->request->getPost('contrasena'), PASSWORD_BCRYPT);
        }

        if ($this->usuarioModel->update($id, $data)) {
            return redirect()->to(base_url('operador_user'))->with('message', 'Usuario actualizado correctamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo actualizar el usuario.');
        }
    }

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
        if (!session()->get('isLoggedIn')) {
            return $this->response->setStatusCode(403, 'Acceso Prohibido');
        }
        
        $ubicaciones = $this->monitoreoModel
            ->select('monitoreo_ubicacion.id_usuario, latitud, longitud, ultima_actualizacion, nombre, apellido_paterno, foto')
            ->join('usuarios', 'usuarios.id_usuario = monitoreo_ubicacion.id_usuario')
            ->findAll();
        
        return $this->response->setJSON($ubicaciones);
    }

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