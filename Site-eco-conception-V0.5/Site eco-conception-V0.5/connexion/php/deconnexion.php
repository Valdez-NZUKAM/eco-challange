<?php
    require_once("session.php");
    $_SESSION = [];
    session_destroy();
    header('Location: ../index.php');
?>