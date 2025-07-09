<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse; // Importar RedirectResponse para una mejor tipificación

class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     * Este método se ejecuta cuando se accede a la ruta base del controlador (ej. /login).
     * @return string
     */
    public function index(): string
    {
        // Puedes pasar datos a la vista si es necesario, por ejemplo, mensajes flash de error.
        $data = [
            'error' => session()->getFlashdata('error') // Para mostrar mensajes de error si la autenticación falla
        ];
        return view('login', $data); // Asume que tu vista de login se llama 'login.php'
    }

    /**
     * Procesa el formulario de inicio de sesión.
     * @return RedirectResponse
     */
    public function procesar(): RedirectResponse
    {
        $session = session();
        $usuarioModel = new UsuarioModel();

        // Recibir datos del formulario
        // El campo de entrada en el formulario de login debería ser 'usuario' o 'email_or_username'
        $usuario_o_email = $this->request->getPost('usuario');
        $password = $this->request->getPost('password');

        // Validar que los campos no estén vacíos
        if (empty($usuario_o_email) || empty($password)) {
            $session->setFlashdata('error', 'Por favor, ingresa tu usuario/correo y contraseña.');
            return redirect()->to('/login');
        }

        // Buscar usuario en la base de datos por el campo 'usuario'
        $usuario = $usuarioModel->where('usuario', $usuario_o_email)->first();

        if ($usuario) {
            // VERIFICACIÓN DE CONTRASEÑA: Usar password_verify()
            // Esta función compara la contraseña en texto plano con el hash almacenado.
            // Es CRÍTICO que la contraseña en la base de datos haya sido hasheada con password_hash().
            if (password_verify($password, $usuario['contrasena'])) {
                // Autenticación exitosa

                // Preparar los datos del usuario para la sesión
                $foto_perfil = $usuario['foto'] ?? 'default.png';
                if (empty($foto_perfil)) {
                    $foto_perfil = 'default.png';
                }

                $session->set([
                    'id_usuario' => $usuario['id_usuario'],
                    'usuario' => [
                        'id_usuario'         => $usuario['id_usuario'],
                        'nombre'             => $usuario['nombre'],
                        'apellido_paterno'   => $usuario['apellido_paterno'],
                        'apellido_materno'   => $usuario['apellido_materno'],
                        'telefono'           => $usuario['telefono'],
                        // 'fecha_nacimiento' se elimina si no está en el UsuarioModel
                        'usuario'            => $usuario['usuario'], // Usar el campo 'usuario' de la DB
                        'foto'               => $foto_perfil,
                        'id_rol'             => $usuario['id_rol'], // Usar el campo 'id_rol' de la DB
                        // 'id_estado' y 'id_municipio' se eliminan si no están en el UsuarioModel
                    ],
                    'isLoggedIn' => true
                ]);

                // Redirigir según el rol del usuario (usando 'id_rol' de la DB)
                switch ($usuario['id_rol']) {
                    case 1: // Administrador (ID de rol 1)
                        return redirect()->to('/dashboard'); // Ruta para el administrador
                    case 2: // Operador (ID de rol 2)
                        return redirect()->to('/dash');      // Ruta para el operador
                    case 3: // Encuestador (ID de rol 3)
                        return redirect()->to('/home');      // Ruta para el encuestador
                    default:
                        // Rol desconocido o no mapeado
                        $session->setFlashdata('error', 'Tu rol no está definido correctamente. Contacta al administrador.');
                        session()->destroy(); // Cerrar sesión por seguridad
                        return redirect()->to('/login');
                }
            } else {
                // Contraseña incorrecta
                $session->setFlashdata('error', 'Usuario/Correo o contraseña incorrectos.');
                return redirect()->to('/login');
            }
        } else {
            // Usuario no encontrado
            $session->setFlashdata('error', 'Usuario/Correo o contraseña incorrectos.');
            return redirect()->to('/login');
        }
    }

    /**
     * Cierra la sesión del usuario.
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        // No hay lógica de "recuérdame" en este UsuarioModel simplificado,
        // así que solo destruimos la sesión.
        session()->destroy();
        return redirect()->to('/login'); // Redirige al login
    }

    /**
     * Muestra el formulario de registro de usuario.
     * @return string
     */
    

    
}
