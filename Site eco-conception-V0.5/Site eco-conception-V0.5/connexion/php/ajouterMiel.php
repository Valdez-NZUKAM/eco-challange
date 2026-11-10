<?php
    session_start();
    require_once("ClassMiel.php");

    // Pas connecté ou pas en POST : on renvoie vers la connexion
    if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../index.php');
        exit;
    }

    $type  = $_POST['type'] ?? '';
    $photo = $_POST['photo'] ?? '';
    // filter_input renvoie false si ce n'est pas un entier valide
    $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);

    // && : les 3 champs doivent être valides (avant, || en acceptait un seul)
    if ($type !== '' && $photo !== '' && $stock !== false && $stock !== null && $stock >= 0) {
        $miel = new ClassMiel();
        $miel->addMiel($type, $photo, $stock);
    }
    header('Location: ../backend.php');
?>