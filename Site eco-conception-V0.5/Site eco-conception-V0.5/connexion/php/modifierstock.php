<?php
    session_start();
    require_once("ClassMiel.php");

    // Il faut être connecté et envoyer le formulaire en POST
    if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../backend.php');
        exit;
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $action = $_POST['action'] ?? '';

    // plus -> +1, moins -> -1
    if ($action === 'plus') {
        $delta = 1;
    } elseif ($action === 'moins') {
        $delta = -1;
    } else {
        header('Location: ../backend.php');
        exit;
    }

    if ($id !== false && $id !== null && $id > 0) {
        $miel = new ClassMiel();
        $miel->changerStock($id, $delta);
    }
    header('Location: ../backend.php');
?>