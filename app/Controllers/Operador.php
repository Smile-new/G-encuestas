<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuarioModel;

class Operador extends Controller
{

    protected $usuarioModel; 

     public function __construct()
      {
          $this->usuarioModel = new UsuarioModel();
      }
  
private function _prepareUserData(): array
{
    $session = session();
    $userData = $session->get('usuario');
    $data = [];

    $data['isLoggedIn'] = $session->get('isLoggedIn');
    $data['nombreCompleto'] = "Invitado";
    $data['nombreUsuario'] = "invitado";
    $data['rutaFotoPerfil'] = base_url(RECURSOS_ENCUESTADOR_IMAGES . '/user.png');
    $data['rolTexto'] = "Rol desconocido";

    if ($data['isLoggedIn'] && is_array($userData)) {
        // Obtener usuario actualizado con JOIN al rol
        $usuarioConRol = $this->usuarioModel->getUsuarioConRol($userData['id_usuario']);

        if ($usuarioConRol) {
            $data['userData'] = $usuarioConRol;
            $data['nombreCompleto'] = trim(esc($usuarioConRol['nombre'] ?? '') . ' ' .
                esc($usuarioConRol['apellido_paterno'] ?? '') . ' ' .
                esc($usuarioConRol['apellido_materno'] ?? ''));
            $data['nombreUsuario'] = esc($usuarioConRol['usuario'] ?? '');
            $data['rolTexto'] = esc($usuarioConRol['nombre_rol']);

            if (!empty($usuarioConRol['foto'])) {
                $data['rutaFotoPerfil'] = base_url('public/img_user/' . esc($usuarioConRol['foto']));
            }
        }
    }

    return $data;
}
    
    public function dashboard()
    {
        $data = $this->_prepareUserData();
        return view('operador/dash');
    }

   
    public function estadisticas()
    {
        
        return view('operador/estat');
    }

    /**
     * Mostrar perfil del operador
     */
    public function perfil()
    {
    	$data = $this->_prepareUserData();
        return view('operador/perfil', $data);
    }

    /** * Actualizar datos del perfil del operador */ 
public function updateProfile() { 
    $session = session(); 
    $user = $session->get('usuario'); 
    // ✅ Reglas de validación 
    $rules = [ 
        'nombre' => 'required|min_length[3]|max_length[50]', 
        'apellido_paterno' => 'required|min_length[3]|max_length[50]', 
        'apellido_materno' => 'permit_empty|max_length[50]', 
        'telefono' => 'permit_empty|min_length[7]|max_length[15]',
        'foto' => 'permit_empty|is_image[foto]|max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png]', 
    ]; 
    
    if (!$this->validate($rules)) { 
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()); 
    } 
    
    // ✅ Preparar datos a actualizar 
    $dataUpdate = [ 
        'nombre' => $this->request->getPost('nombre'), 
        'apellido_paterno' => $this->request->getPost('apellido_paterno'), 
        'apellido_materno' => $this->request->getPost('apellido_materno'), 
        'telefono' => $this->request->getPost('telefono'),
    ]; 
    
    // ✅ Procesar la foto si fue subida 
    $fotoFile = $this->request->getFile('foto');
    if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) { 
        $nombreFoto = time() . '_' . $fotoFile->getName(); 
        $fotoFile->move(FCPATH . 'public/img_user', $nombreFoto); 
        $dataUpdate['foto'] = $nombreFoto; 
        
        // Actualizar la sesión con nueva foto 
        $user['foto'] = $nombreFoto; } 
        
        // ✅ Actualizar base de datos 
        $this->usuarioModel->update($user['id_usuario'], $dataUpdate); 
        
        // ✅ Refrescar sesión con los datos nuevos 
        $user = array_merge($user, $dataUpdate); 
        $session->set('usuario', $user); 
        $session->setFlashdata('success', 'Perfil actualizado correctamente'); 
        return redirect()->back(); 
    }
}