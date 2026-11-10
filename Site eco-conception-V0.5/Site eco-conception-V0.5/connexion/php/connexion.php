
<?php
require_once("classConnexion.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
}else{
    $login = trim($_POST['login']) ?? '';
    $password = $_POST['motdepasse'] ?? '';
    $oConnexion = new classConnexion();
    $status = $oConnexion->connect($login, $password);

    if($status == true){
        session_start();
        // renouvellement de l'id de session
        session_regenerate_id(true);
        $_SESSION['user'] = $login;
        header('Location: ../backend.php');
    }else{
        header('Location: ../index.php');
    }
}
