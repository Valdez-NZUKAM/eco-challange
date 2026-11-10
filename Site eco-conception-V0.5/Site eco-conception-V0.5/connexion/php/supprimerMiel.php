<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }

    require_once("ClassMiel.php");

    $csrfToken = $_POST['csrf_token'] ?? null;
    if (!is_string($csrfToken) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
        header('Location: ../backend.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../backend.php');
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
    exit;
?>
