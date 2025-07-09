<?php

namespace App\Controllers; // EL NAMESPACE HA SIDO CAMBIADO A SOLO 'App\Controllers'

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\RolModel;

class Usuarios extends BaseController
{
    protected $usuarioModel;
    protected $rolModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->rolModel     = new RolModel();
    }

    public function index()
    {
        // Obtener parámetros de filtro y búsqueda de la URL
        $idRolFilter = $this->request->getGet('id_rol');
        $searchTerm = $this->request->getGet('search_term');

        // Iniciar la consulta
        $query = $this->usuarioModel;

        // Aplicar filtro por rol si se seleccionó uno
        if (!empty($idRolFilter)) {
            $query = $query->where('id_rol', $idRolFilter);
        }

        // Aplicar búsqueda por término si se proporcionó uno
        if (!empty($searchTerm)) {
            $query = $query->groupStart() // Inicia un grupo para la cláusula OR
                             ->like('nombre', $searchTerm)
                             ->orLike('apellido_paterno', $searchTerm)
                             ->orLike('apellido_materno', $searchTerm)
                             ->orLike('usuario', $searchTerm)
                             ->groupEnd(); // Cierra el grupo
        }

        // Obtener los usuarios filtrados/buscados
        $usuarios = $query->findAll();

        // Obtener todos los roles para el dropdown de filtro
        $roles = $this->rolModel->findAll();

        $data = [
            'usuarios' => $usuarios,
            'roles'    => $roles, // Pasar los roles también a la vista para el filtro
            // Los valores de filtro y búsqueda actuales se recuperan directamente en el HTML con $_GET
        ];

        return view('admin/users', $data);
    }

    public function create()
    {
        $data = [
            'roles' => $this->rolModel->findAll()
        ];
        return view('admin/create_user', $data);
    }

    public function store()
    {
        $rules = [
            'nombre'           => 'required|alpha_space|min_length[3]|max_length[100]',
            'apellido_paterno' => 'required|alpha_space|min_length[3]|max_length[100]',
            'apellido_materno' => 'permit_empty|alpha_space|max_length[100]',
            'telefono'         => 'permit_empty|numeric|max_length[10]',
            'usuario'          => 'required|min_length[5]|max_length[100]|is_unique[usuarios.usuario]',
            'contrasena'       => 'required|min_length[8]',
            'foto'             => 'if_exist|uploaded[foto]|max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]',
            'id_rol'           => 'required|integer|is_not_unique[roles.id_rol]'
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

        $data = [
            'nombre'           => $this->request->getPost('nombre'),
            'apellido_paterno' => $this->request->getPost('apellido_paterno'),
            'apellido_materno' => $this->request->getPost('apellido_materno'),
            'telefono'         => $this->request->getPost('telefono'),
            'usuario'          => $this->request->getPost('usuario'),
            'contrasena'       => password_hash($this->request->getPost('contrasena'), PASSWORD_BCRYPT),
            'foto'             => $fotoFileName,
            'id_rol'           => $this->request->getPost('id_rol'),
        ];

        if ($this->usuarioModel->insert($data)) {
            return redirect()->to(base_url('usuarios'))->with('message', 'Usuario creado correctamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo crear el usuario. Inténtalo de nuevo.');
        }
    }

    public function edit($id = null)
    {
        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            return redirect()->to(base_url('usuarios'))->with('error', 'Usuario no encontrado.');
        }

        $data = [
            'usuario' => $usuario,
            'roles'   => $this->rolModel->findAll()
        ];

        return view('admin/update_user', $data);
    }

    public function update($id = null)
    {
        $usuarioExistente = $this->usuarioModel->find($id);
        if (!$usuarioExistente) {
            return redirect()->to(base_url('usuarios'))->with('error', 'Usuario no encontrado para actualizar.');
        }

        $rules = [
            'nombre'           => 'required|alpha_space|min_length[3]|max_length[100]',
            'apellido_paterno' => 'required|alpha_space|min_length[3]|max_length[100]',
            'apellido_materno' => 'permit_empty|alpha_space|max_length[100]',
            'telefono'         => 'permit_empty|numeric|max_length[10]',
            'usuario'          => 'required|min_length[5]|max_length[100]|is_unique[usuarios.usuario,id_usuario,' . $id . ']',
            'id_rol'           => 'required|integer|is_not_unique[roles.id_rol]'
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
            'id_rol'           => $this->request->getPost('id_rol'),
            'foto'             => $fotoFileName,
        ];

        if ($this->request->getPost('contrasena')) {
            $data['contrasena'] = password_hash($this->request->getPost('contrasena'), PASSWORD_BCRYPT);
        }

        if ($this->usuarioModel->update($id, $data)) {
            return redirect()->to(base_url('usuarios'))->with('message', 'Usuario actualizado correctamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo actualizar el usuario. Inténtalo de nuevo.');
        }
    }

    public function delete($id = null)
    {
        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            return redirect()->to(base_url('usuarios'))->with('error', 'Usuario no encontrado para eliminar.');
        }

        if (!empty($usuario['foto']) && file_exists(FCPATH . 'public/img_user/' . $usuario['foto'])) {
            unlink(FCPATH . 'public/img_user/' . $usuario['foto']);
        }

        if ($this->usuarioModel->delete($id)) {
            return redirect()->to(base_url('usuarios'))->with('message', 'Usuario eliminado correctamente.');
        } else {
            return redirect()->to(base_url('usuarios'))->with('error', 'No se pudo eliminar el usuario.');
        }
    }
}