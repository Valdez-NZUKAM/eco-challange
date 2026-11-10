<?php
    require_once("ClassMiel.php");

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../backend.php');
        exit;
    }

    $type = $_POST['type'] ?? null;
    $photo = $_POST['photo'] ?? null;

    if (!is_string($type) || !is_string($photo)) {
        header('Location: ../backend.php');
        exit;
    }

    if($type !== '' || $photo !== ''){
        $miel = new ClassMiel();
        $miel->addMiel($type, $photo);
    }
    header('Location: ../backend.php');
?>
