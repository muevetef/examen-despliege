<?php

namespace App\Controllers;

class ErrorController
{

    /**
     * Error 404 no encontrado
     *
     * @param string $message
     * @return void
     */
    static function notFound($message = "No se encuentra el recurso")
    {
        http_response_code(404);
        loadView('error', [
            'status' => '404',
            'message' => $message
        ]);
    }

    /**
     * Error 403 no autorizado
     *
     * @param string $message
     * @return void
     */
    static function unauthorized($message = "Este recurso requiere autorización")
    {
        http_response_code(403);
        loadView('error', [
            'status' => '403',
            'message' => $message
        ]);
    }
}
