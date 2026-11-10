<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../backend.php');
        exit;
    }

    $csrfToken = $_POST['csrf_token'] ?? null;
    if (!is_string($csrfToken) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
        header('Location: ../backend.php');
        exit;
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $type = $_POST['type'] ?? null;
    $photo = $_POST['photo'] ?? null;

    if ($id === false || $id === null || $id <= 0 || !is_string($type) || !is_string($photo)) {
        header('Location: ../backend.php');
        exit;
    }

    require_once("ClassMiel.php");
    $miel = new ClassMiel();
    $miel->updateMiel($id, $type, $photo);

    header('Location: ../backend.php');
    exit;
?>
