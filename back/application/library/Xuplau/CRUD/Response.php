<?php
Namespace Xuplau\CRUD;

Class Response
{

    public static function Continue_100($menssage = '') {
        header ('HTTP/1.1 100 Continue');
        return $menssage;
    }

    public static function Switching_Protocols($menssage = '') {
        header ('HTTP/1.1 101 Switching Protocols');
        return $menssage;
    }

    public static function OK($menssage = 'Sucesso \\o/') {
        header ('HTTP/1.1 200 Ok');
        header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT");
        header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header ("Cache-Control: no-cache, must-revalidate");
        header ("Pragma: no-cache");
        return $menssage;
    }

    public static function Created($menssage = 'Sucesso \\o/') {
        header ('HTTP/1.1 201 Created');
        return $menssage;
    }

    public static function Accepted($menssage = 'Sucesso \\o/') {
        header ('HTTP/1.1 202 Accepted');
        return $menssage;
    }

    public static function Non_Authoritative_Information($menssage = 'Sucesso \\o/') {
        header ('HTTP/1.1 203 Non-Authoritative Information');
        return $menssage;
    }

    public static function No_Content($menssage = 'Sucesso \\o/') {
        header ('HTTP/1.1 204 No Content');
        return $menssage;
    }

    public static function Reset_Content($menssage = 'Sucesso \\o/') {
        header ('HTTP/1.1 205 Reset Content');
        return $menssage;
    }

    public static function Partial_Content($menssage = 'Sucesso \\o/') {
        header ('HTTP/1.1 206 Partial Content');
        return $menssage;
    }

    public static function Multiple_Choices($menssage = 'Está faltando alguma coisa') {
        header('HTTP/1.1 300 Multiple Choices');
        return $menssage;
    }

    public static function Moved_Permanently($menssage = 'Está faltando alguma coisa') {
        header('HTTP/1.1 301 Moved Permanently');
        return $menssage;
    }

    public static function Found($menssage = 'Está faltando alguma coisa') {
        header('HTTP/1.1 302 Found');
        return $menssage;
    }

    public static function See_Other($menssage = 'Está faltando alguma coisa') {
        header('HTTP/1.1 303 See Other');
        return $menssage;
    }

    public static function Not_Modified($menssage = 'Está faltando alguma coisa') {
        header('HTTP/1.1 304 Not Modified');
        return $menssage;
    }

    public static function Use_Proxy($menssage = 'Está faltando alguma coisa') {
        header('HTTP/1.1 305 Use Proxy');
        return $menssage;
    }

    public static function Unused($menssage = 'Está faltando alguma coisa') {
        header('HTTP/1.1 306 (Unused)');
        return $menssage;
    }

    public static function Temporary_Redirect($menssage = 'Está faltando alguma coisa') {
        header('HTTP/1.1 307 Temporary Redirect');
        return $menssage;
    }

    public static function Bad_Request($menssage = 'Está faltando alguma coisa') {
        header('HTTP/1.1 400 Bad Request');
        return $menssage;
    }

    public static function Unauthorized($menssage = 'You Shall Not Pass!') {
        header('HTTP/1.1 401 Unauthorized');
        return $menssage;
    }

    public static function Payment_Required($menssage = 'Fiado só no feriado de 30 de fevereiro') {
        header('HTTP/1.1 402 Payment Required');
        return $menssage;
    }

    public static function Forbidden($menssage = 'Você não pode acessar :p') {
        header('HTTP/1.1 403 Forbidden');
        return $menssage;
    }

    public static function Not_Found($menssage = 'Não encontramos o que deseja, mas valeu por tentar') {
        header('HTTP/1.1 404 Not Found');
        return $menssage;
    }

    public static function Method_Not_Allowed($menssage = '') {
        header('HTTP/1.1 405 Method Not Allowed');
        return $menssage;
    }

    public static function Not_Acceptable($menssage = '') {
        header('HTTP/1.1 406 Not Acceptable');
        return $menssage;
    }

    public static function Proxy_Authentication_Required($menssage = '') {
        header('HTTP/1.1 407 Proxy Authentication Required');
        return $menssage;
    }

    public static function Request_Timeout($menssage = '') {
        header('HTTP/1.1 408 Request Timeout');
        return $menssage;
    }

    public static function Conflict($menssage = 'Conflito detectado :(') {
        header('HTTP/1.1 409 Conflict');
        return $menssage;
    }

    public static function Gone($menssage = '') {
        header('HTTP/1.1 410 Gone');
        return $menssage;
    }

    public static function Length_Required($menssage = '') {
        header('HTTP/1.1 411 Length Required');
        return $menssage;
    }

    public static function Precondition_Failed($menssage = '') {
        header('HTTP/1.1 412 Precondition Failed');
        return $menssage;
    }

    public static function Request_Entity_Too_Large($menssage = '') {
        header('HTTP/1.1 413 Request Entity Too Large');
        return $menssage;
    }

    public static function Request_URI_Too_Long($menssage = '') {
        header('HTTP/1.1 414 Request-URI Too Long');
        return $menssage;
    }

    public static function Unsupported_Media_Type($menssage = '') {
        header('HTTP/1.1 415 Unsupported Media Type');
        return $menssage;
    }

    public static function Requested_Range_Not_Satisfiable($menssage = '') {
        header('HTTP/1.1 416 Requested Range Not Satisfiable');
        return $menssage;
    }

    public static function Expectation_Failed($menssage = '') {
        header('HTTP/1.1 417 Expectation Failed');
        return $menssage;
    }

    public static function Unprocessable_Entity($menssage = '') {
        header('HTTP/1.1 422 Unprocessable Entity');
        return $menssage;
    }

    public static function Internal_Server_Error($menssage = '') {
        header('HTTP/1.1 500 Internal Server Error');
        return $menssage;
    }

    public static function Not_Implemented($menssage = '') {
        header('HTTP/1.1 501 Not Implemented');
        return $menssage;
    }

    public static function Bad_Gateway($menssage = '') {
        header('HTTP/1.1 502 Bad Gateway');
        return $menssage;
    }

    public static function Service_Unavailable($menssage = '') {
        header('HTTP/1.1 503 Service Unavailable');
        return $menssage;
    }

    public static function Gateway_Timeout($menssage = '') {
        header('HTTP/1.1 504 Gateway Timeout');
        return $menssage;
    }

    public static function HTTP_Version_Not_Supported($menssage = '') {
        header('HTTP/1.1 505 HTTP Version Not Supported');
        return $menssage;
    }
}