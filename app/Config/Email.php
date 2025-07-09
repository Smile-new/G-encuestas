<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    /**
     * Dirección de correo del remitente.
     *
     * @var string
     */
    public $fromEmail = 'supportassistent@byteflower.mx';

    /**
     * Nombre del remitente.
     *
     * @var string
     */
    public $fromName = 'Soporte Asistente';

    /**
     * Dirección de los destinatarios.
     *
     * @var string
     */
    public $recipients;

    /**
     * El "User-Agent" del correo.
     *
     * @var string
     */
    public $userAgent = 'CodeIgniter';

    /**
     * Protocolo de envío de correos (mail, sendmail, smtp).
     *
     * @var string
     */
    public $protocol = 'smtp';

    /**
     * Dirección del servidor SMTP.
     *
     * @var string
     */
    public $SMTPHost = 'smtp.byteflower.mx'; // Asegúrate de que sea el correcto.

    /**
     * Usuario SMTP (tu correo electrónico de soporte).
     *
     * @var string
     */
    public $SMTPUser = 'supportassistent@byteflower.mx';

    /**
     * Contraseña SMTP.
     *
     * @var string
     */
    public $SMTPPass = 'SoporteAsistente78218912'; // Cambia por la contraseña real.

    /**
     * Puerto SMTP (usualmente 587 para TLS o 465 para SSL).
     *
     * @var int
     */
    public $SMTPPort = 587;

    /**
     * Seguridad SMTP (tls o ssl).
     *
     * @var string
     */
    public $SMTPCrypto = 'tls';

    /**
     * Tiempo de espera de la conexión SMTP (en segundos).
     *
     * @var int
     */
    public $SMTPTimeout = 10;

    /**
     * Mantener la conexión SMTP abierta entre envíos.
     *
     * @var bool
     */
    public $SMTPKeepAlive = false;

    /**
     * Tipo de contenido del correo (text o html).
     *
     * @var string
     */
    public $mailType = 'html';

    /**
     * Codificación de caracteres (UTF-8 recomendado).
     *
     * @var string
     */
    public $charset = 'UTF-8';

    /**
     * Si se debe validar el correo antes de enviarlo.
     *
     * @var bool
     */
    public $validate = true;

    /**
     * Prioridad del correo (1 = alta, 5 = baja, 3 = normal).
     *
     * @var int
     */
    public $priority = 3;

    /**
     * Longitud máxima de línea de texto antes de un salto de línea.
     *
     * @var int
     */
    public $wrapChars = 76;

    /**
     * Caracter de nueva línea según RFC 822.
     *
     * @var string
     */
    public $CRLF = "\r\n";

    /**
     * Caracter de nueva línea según RFC 822.
     *
     * @var string
     */
    public $newline = "\r\n";

    /**
     * Activar modo BCC Batch.
     *
     * @var bool
     */
    public $BCCBatchMode = false;

    /**
     * Número de emails en cada BCC batch.
     *
     * @var int
     */
    public $BCCBatchSize = 200;

    /**
     * Activar la confirmación de entrega desde el servidor.
     *
     * @var bool
     */
    public $DSN = false;
}
