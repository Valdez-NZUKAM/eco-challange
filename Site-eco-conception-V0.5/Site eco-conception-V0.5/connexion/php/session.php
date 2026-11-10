<?php
$scriptPath = $_SERVER['SCRIPT_NAME'] ?? '';
$connexionMarker = '/connexion/';
$connexionPosition = strpos($scriptPath, $connexionMarker);

if ($connexionPosition === false) {
    throw new RuntimeException('Impossible de déterminer le chemin de session de la connexion.');
}

$cookiePath = substr(
    $scriptPath,
    0,
    $connexionPosition + strlen($connexionMarker)
);
$cookiePath = implode('/', array_map(
    static function (string $segment): string {
        return rawurlencode(rawurldecode($segment));
    },
    explode('/', $cookiePath)
));

session_set_cookie_params([
    'lifetime' => 0,
    'path' => $cookiePath,
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax',
]);

session_start();
