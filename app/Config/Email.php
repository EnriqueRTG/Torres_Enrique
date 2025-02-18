<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    /**
     * Dirección de correo del remitente por defecto.
     * Debe coincidir con la cuenta autenticada en el servidor SMTP.
     */
    public string $fromEmail  = 'tattoosupplystoreok@gmail.com';

    /**
     * Nombre del remitente que aparecerá en los correos enviados.
     */
    public string $fromName   = 'Tattoo Supply Store';

    /**
     * Destinatarios adicionales (opcional).
     */
    public string $recipients = '';

    /**
     * "User agent" que se utiliza en el encabezado del correo.
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * Protocolo para enviar el correo.
     * Opciones: 'mail', 'sendmail' o 'smtp'
     */
    public string $protocol = 'smtp';

    /**
     * Ruta del ejecutable de Sendmail.
     * (No se utiliza si el protocolo es SMTP)
     */
    public string $mailPath = '/usr/sbin/sendmail';

    /**
     * Host del servidor SMTP.
     * Para Gmail se utiliza: smtp.gmail.com
     */
    public string $SMTPHost = 'smtp.gmail.com';

    /**
     * Nombre de usuario SMTP.
     * Normalmente, la dirección de correo que usas para enviar mensajes.
     */
    public string $SMTPUser = 'tattoosupplystoreok@gmail.com';

    /**
     * Contraseña del servidor SMTP.
     * IMPORTANTE: Se obtiene desde la variable de entorno SMTP_PASS para protegerla.
     */
    public string $SMTPPass = '';

    /**
     * Puerto SMTP.
     * Para Gmail con TLS se utiliza el puerto 587.
     */
    public int $SMTPPort = 587;

    /**
     * Tiempo de espera para la conexión SMTP (en segundos).
     */
    public int $SMTPTimeout = 5;

    /**
     * Indica si se deben mantener conexiones SMTP persistentes.
     */
    public bool $SMTPKeepAlive = false;

    /**
     * Tipo de cifrado para la conexión SMTP.
     * Gmail requiere 'tls' para conexiones seguras.
     */
    public string $SMTPCrypto = 'tls';

    /**
     * Habilita el ajuste de palabras en el correo.
     */
    public bool $wordWrap = true;

    /**
     * Número de caracteres al que se ajusta la línea.
     */
    public int $wrapChars = 76;

    /**
     * Tipo de correo que se enviará: 'text' o 'html'.
     */
    public string $mailType = 'html';

    /**
     * Conjunto de caracteres utilizado en el correo.
     */
    public string $charset = 'UTF-8';

    /**
     * Valida las direcciones de correo.
     */
    public bool $validate = true;

    /**
     * Prioridad del correo (1 = mayor, 5 = menor; 3 = normal).
     */
    public int $priority = 3;

    /**
     * Carácter de nueva línea, para cumplir con RFC 822.
     */
    public string $CRLF = "\r\n";

    /**
     * Carácter de nueva línea.
     */
    public string $newline = "\r\n";

    /**
     * Habilita el envío de correos en modo BCC Batch.
     */
    public bool $BCCBatchMode = false;

    /**
     * Cantidad de correos en cada lote BCC.
     */
    public int $BCCBatchSize = 200;

    /**
     * Habilita la notificación de mensajes desde el servidor (Delivery Status Notification).
     */
    public bool $DSN = false;

    /**
     * Constructor.
     *
     * Aquí se asigna la contraseña SMTP a partir de la variable de entorno SMTP_PASS,
     * lo que permite proteger la contraseña y no dejarla codificada directamente en el archivo.
     */
    public function __construct()
    {
        parent::__construct();

        // Obtiene la contraseña SMTP de la variable de entorno SMTP_PASS.
        // Asegúrate de tener definida SMTP_PASS en tu archivo .env.
        $this->SMTPPass = env('SMTP_PASS', '');
    }
}
