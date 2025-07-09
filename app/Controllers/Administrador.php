<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\EncuestaModel; // Importar tu EncuestaModel
use App\Models\UsuarioModel;  // Importar tu UsuarioModel
use App\Models\RolModel;      // Importar tu RolModel para los roles de usuario
// Si tienes un modelo para respuestas, impórtalo aquí:
// use App\Models\RespuestaModel;

class Administrador extends Controller // Asegúrate de que este nombre de clase coincida con el nombre del archivo (Administrador.php)
{
    // Método constructor
    public function __construct()
    {
        // En CodeIgniter 4, se recomienda cargar helpers en el método `initController` si es para todo el controlador
        // o directamente donde se usan si es esporádico. Para `BaseController`, el helper `url` ya suele estar cargado.
        // Si no usas BaseController y necesitas el helper aquí, descoméntalo:
        // helper('url');
    }

    // Método para la página principal del administrador (dashboard)
    public function index()
    {
        $session = session(); // Obtener la instancia de la sesión

        // Validar si el usuario está logueado y es administrador
        // Asumo que id_rol = 1 es el rol de Administrador.
        // Asegúrate de que tu lógica de sesión esté guardando el 'id_rol' correctamente.
        if (!$session->get('isLoggedIn') || ($session->get('usuario')['id_rol'] ?? null) != 1) {
            // Si no está logueado o no es administrador, redirigir a la página de login
            return redirect()->to(base_url('login'))->with('error', 'Acceso no autorizado. Por favor, inicia sesión como administrador.');
        }

        // Instanciar tus modelos
        $encuestaModel = new EncuestaModel();
        $usuarioModel = new UsuarioModel();
        $rolModel = new RolModel(); // Instanciar tu RolModel
        // Si tienes un RespuestaModel, instáncialo:
        // $respuestaModel = new RespuestaModel();

        // --- Obtener datos para las estadísticas del dashboard desde la base de datos ---

        // Total de Encuestas
        $totalEncuestas = $encuestaModel->countAllResults();
        // Simulación de valor anterior para el cálculo del porcentaje
        $previousTotalEncuestas = 240; // Ejemplo: valor del mes anterior

        // Encuestas Activas
        $encuestasActivas = $encuestaModel->where('activa', 1)->countAllResults();
        // Simulación de valor anterior para el cálculo del porcentaje
        $previousEncuestasActivas = 115; // Ejemplo: valor del mes anterior

        // Total de Usuarios Registrados
        $usuariosRegistrados = $usuarioModel->countAllResults();
        // Simulación de valor anterior para el cálculo del porcentaje
        $previousUsuariosRegistrados = 480; // Ejemplo: valor del mes anterior

        // Total de Respuestas:
        $totalRespuestas = 7500; // Valor de ejemplo si no tienes un sistema de respuestas en DB todavía.
        $previousTotalRespuestas = 7600; // Ejemplo: valor del mes anterior

        // --- Cálculo de porcentajes de cambio ---
        $percentageChangeTotalEncuestas = 0;
        if ($previousTotalEncuestas > 0) {
            $percentageChangeTotalEncuestas = (($totalEncuestas - $previousTotalEncuestas) / $previousTotalEncuestas) * 100;
        }

        $percentageChangeEncuestasActivas = 0;
        if ($previousEncuestasActivas > 0) {
            $percentageChangeEncuestasActivas = (($encuestasActivas - $previousEncuestasActivas) / $previousEncuestasActivas) * 100;
        }

        $percentageChangeTotalRespuestas = 0;
        if ($previousTotalRespuestas > 0) {
            $percentageChangeTotalRespuestas = (($totalRespuestas - $previousTotalRespuestas) / $previousTotalRespuestas) * 100;
        }

        $percentageChangeUsuariosRegistrados = 0;
        if ($previousUsuariosRegistrados > 0) {
            $percentageChangeUsuariosRegistrados = (($usuariosRegistrados - $previousUsuariosRegistrados) / $previousUsuariosRegistrados) * 100;
        }

        // --- Datos para los gráficos ---

        // Ejemplo de datos para el gráfico de barras (Encuestas Creadas por Mes)
        $labelsEncuestasMes = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'];
        $dataEncuestasMes = [30, 45, 60, 55, 70, 85]; // Datos estáticos de ejemplo

        // Ejemplo de datos para el gráfico de pastel (Distribución de Tipos de Encuesta)
        $labelsTiposEncuesta = ['Satisfacción', 'Mercado', 'Producto', 'Servicio'];
        $dataTiposEncuesta = [40, 25, 20, 15]; // Datos estáticos de ejemplo

        // --- Datos para el gráfico de Usuarios por Rol ---
        // Obtener el conteo de usuarios por cada id_rol
        $usersByRole = $usuarioModel->select('id_rol, COUNT(*) as count')
                                    ->groupBy('id_rol')
                                    ->findAll();

        $labelsRoles = [];
        $dataRoles = [];

        // Obtener todos los roles para asegurar que incluso los roles sin usuarios aparecen con conteo 0
        $allRoles = $rolModel->findAll();
        $roleMap = [];
        foreach ($allRoles as $role) {
            $roleMap[$role['id_rol']] = $role['nombre_rol'];
        }

        // Inicializar los conteos de roles
        $roleCounts = [];
        foreach($roleMap as $id => $name) {
            $roleCounts[$id] = 0;
        }

        // Asignar los conteos reales
        foreach ($usersByRole as $item) {
            $roleCounts[$item['id_rol']] = $item['count'];
        }

        // Preparar los datos para la vista
        foreach ($roleCounts as $id_rol => $count) {
            $labelsRoles[] = "'" . esc($roleMap[$id_rol] ?? 'Desconocido') . "'"; // Nombre del rol
            $dataRoles[] = $count; // Cantidad de usuarios
        }

        // --- Últimas Encuestas Recientes ---
        $ultimasEncuestas = $encuestaModel->orderBy('fecha_creacion', 'DESC')->limit(5)->findAll();

        // --- Preparar datos del usuario logueado para la plantilla (sidebar y navbar) ---
        $userData = $session->get('usuario');

        $nombreCompleto = "Invitado";
        $rolTexto = "Rol Desconocido";
        // Asegúrate de que RECURSOS_ADMIN_IMAGES esté definida en `app/Config/Constants.php`
        // o usa una ruta directa como 'public/assets/images/faces/face15.jpg'
        $rutaFotoPerfil = base_url(defined('RECURSOS_ADMIN_IMAGES') ? RECURSOS_ADMIN_IMAGES . '/faces/face15.jpg' : 'public/assets/images/faces/face15.jpg');

        if ($session->get('isLoggedIn') && is_array($userData)) {
            $nombreCompleto = esc($userData['nombre'] ?? '') . ' ' .
                              esc($userData['apellido_paterno'] ?? '') . ' ' .
                              esc($userData['apellido_materno'] ?? '');

            $id_rol_usuario_actual = $userData['id_rol'] ?? null;
            if ($id_rol_usuario_actual) {
                $rolData = $rolModel->find($id_rol_usuario_actual);
                if ($rolData) {
                    $rolTexto = esc($rolData['nombre_rol']);
                } else {
                    $rolTexto = 'Rol Desconocido (ID: ' . $id_rol_usuario_actual . ')';
                }
            } else {
                $rolTexto = 'Sin Rol Asignado';
            }

            if (!empty($userData['foto'])) {
                $rutaFotoPerfil = base_url('public/img_user/' . esc($userData['foto']));
            }
        }

        // Array de datos que se pasarán a la vista
        $data = [
            'isLoggedIn' => $session->get('isLoggedIn'),
            'nombreCompleto' => $nombreCompleto,
            'rolTexto' => $rolTexto,
            'rutaFotoPerfil' => $rutaFotoPerfil,

            'totalEncuestas' => $totalEncuestas,
            'percentageChangeTotalEncuestas' => round($percentageChangeTotalEncuestas, 1),
            'encuestasActivas' => $encuestasActivas,
            'percentageChangeEncuestasActivas' => round($percentageChangeEncuestasActivas, 1),
            'totalRespuestas' => $totalRespuestas,
            'percentageChangeTotalRespuestas' => round($percentageChangeTotalRespuestas, 1),
            'usuariosRegistrados' => $usuariosRegistrados,
            'percentageChangeUsuariosRegistrados' => round($percentageChangeUsuariosRegistrados, 1),

            'labelsEncuestasMes' => $labelsEncuestasMes,
            'dataEncuestasMes' => $dataEncuestasMes,
            'labelsTiposEncuesta' => $labelsTiposEncuesta,
            'dataTiposEncuesta' => $dataTiposEncuesta,
            'labelsRoles' => $labelsRoles, // <<-- AÑADIDO: Etiquetas para el gráfico de roles
            'dataRoles' => $dataRoles,     // <<-- AÑADIDO: Datos para el gráfico de roles
            'ultimasEncuestas' => $ultimasEncuestas
        ];

        // Cargar la vista del dashboard y pasarle los datos
        return view('admin/dashboard', $data);
    }

    // Método para la visualización de estadísticas (vista estadisticas.php)
    public function estadisticas()
    {
        // ... (Tu lógica existente para estadisticas)
        return view('admin/estadisticas');
    }

    // Aquí puedes añadir otros métodos como `tablas()`, `users()`, `crear_encuesta()` etc.
    // public function tablas() { /* ... */ return view('admin/tablas'); }
    // public function users() { /* ... */ return view('admin/users'); }
}