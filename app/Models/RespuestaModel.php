<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Services;
use Config\Google; // Importante para la clave de API

class RespuestaModel extends Model
{
    protected $table = 'respuestas';
    protected $primaryKey = 'id_respuesta';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_usuario',
        'id_encuesta',
        'id_pregunta',
        'id_opcion',
        'respuesta_texto',
        'id_estado',
        'id_distritofederal',
        'id_distritolocal',
        'id_municipio',
        'id_seccion',
        'id_comunidad',
        'direccion', // <-- Campo para la dirección de texto de Google Maps
    ];

    protected $useTimestamps = true;
    protected $createdField = 'fecha_respuesta';
    protected $updatedField = '';
    protected $useSoftDeletes = false;

    /**
     * Obtiene una dirección limpia (Calle, Ciudad, Estado) desde Google Maps API
     * a partir de latitud y longitud.
     * Esta función es llamada por el controlador.
     */
    public function obtenerDireccion($lat, $lng)
    {
        // Carga la clave de API desde el archivo de configuración app/Config/Google.php
        $config = config(Google::class);
        $apiKey = $config->apiKey;

        if (empty($apiKey)) {
            log_message('error', 'La clave de API de Google no está configurada.');
            return null;
        }

        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&key={$apiKey}";
        $client = Services::curlrequest();

        try {
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            if (json_last_error() !== JSON_ERROR_NONE || empty($data['results'][0])) {
                return 'Dirección no encontrada';
            }

            $components = $data['results'][0]['address_components'];
            $addressParts = [
                'route' => '',       // Calle
                'street_number' => '', // Número
                'locality' => '',    // Ciudad
                'administrative_area_level_1' => '', // Estado
            ];

            foreach ($components as $component) {
                $type = $component['types'][0];
                if (array_key_exists($type, $addressParts)) {
                    $addressParts[$type] = $component['long_name'];
                }
            }
            
            $finalAddress = [];
            if (!empty($addressParts['route'])) {
                $finalAddress[] = trim($addressParts['route'] . ' ' . $addressParts['street_number']);
            }
            if (!empty($addressParts['locality'])) {
                $finalAddress[] = $addressParts['locality'];
            }
            if (!empty($addressParts['administrative_area_level_1'])) {
                $finalAddress[] = $addressParts['administrative_area_level_1'];
            }

            return !empty($finalAddress) ? implode(', ', $finalAddress) : 'Dirección parcial o no encontrada';

        } catch (\Exception $e) {
            log_message('error', 'Error al conectar con Google Maps API: ' . $e->getMessage());
        }

        return null;
    }
}