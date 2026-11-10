<?php
    require_once("ClassMiel.php");

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
?>