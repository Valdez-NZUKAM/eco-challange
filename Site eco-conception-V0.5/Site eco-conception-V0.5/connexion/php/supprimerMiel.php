<?php
   session_start();
    require_once("ClassMiel.php");

    // Pas connecté ou pas en POST : on renvoie vers la connexion
    if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../index.php');
        exit;
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id === false || $id === null || $id <= 0) {
        header('Location: ../backend.php');
        exit;
    }

    $miel = new ClassMiel();
    $miel->removeMiel($id);
    header('Location: ../backend.php');
?>