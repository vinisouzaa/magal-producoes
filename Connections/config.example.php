<?php

/**
 * Copie este arquivo para Connections/config.php no servidor e configure as
 * variáveis de ambiente. Nunca publique o arquivo config.php com credenciais.
 */

$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME') ?: 'nome_do_banco';
$dbUser = getenv('DB_USER') ?: 'usuario_do_banco';
$dbPass = getenv('DB_PASSWORD') ?: 'senha_do_banco';

$con = new PDO(
    "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
    $dbUser,
    $dbPass,
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    )
);

$URLprotocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$URLhost = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$urlBase = $URLprotocolo . '://' . $URLhost . '/';

