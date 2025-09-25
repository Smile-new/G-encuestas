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
        $data['userData'] = $userData;
        $data['id_encuestador'] = $userData['id_usuario'] ?? null;
        $data['nombreCompleto'] = "Invitado";
        $data['nombreUsuario'] = "invitado";
        $data['rutaFotoPerfil'] = base_url(RECURSOS_ENCUESTADOR_IMAGES . '/user.png');

        if ($data['isLoggedIn'] && is_array($userData)) {
            $data['nombreCompleto'] = trim(esc($userData['nombre'] ?? '') . ' ' .
                esc($userData['apellido_paterno'] ?? '') . ' ' .
                esc($userData['apellido_materno'] ?? ''));
            $data['nombreUsuario'] = esc($userData['usuario'] ?? '');
            if (!empty($userData['foto'])) {
                $data['rutaFotoPerfil'] = base_url('public/img_user/' . esc($userData['foto']));
            }
        }
        return $data;
    }
    
    public function dashboard()
    {
        
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

    /**
     * Actualizar foto de perfil del operador
     */
        public function updateProfile()
    {
        $session = session();
        $user = $session->get('usuario');

        $rules = [
            'foto' => 'permit_empty|is_image[foto]|max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $nombreFoto = time() . '_' . $fotoFile->getName();
            $fotoFile->move(FCPATH . 'img_user', $nombreFoto);
            $user['foto'] = $nombreFoto;

            // Actualizar solo la foto en la base de datos
            $this->usuarioModel->update($user['id_usuario'], ['foto' => $nombreFoto]);

            // Actualizar la sesión
            $session->set('usuario', $user);
        }

        $session->setFlashdata('success', 'Foto de perfil actualizada correctamente');
        return redirect()->back();
    }
}