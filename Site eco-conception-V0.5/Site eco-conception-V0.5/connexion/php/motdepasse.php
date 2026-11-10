<?php
    $login = "admin";
    $motDePasse = "123456";
    $hash = password_hash($motDePasse, PASSWORD_DEFAULT);
    echo "Login : ".$login."<br/>";
    echo "Mot de passe : ".$motDePasse."<br/>";
    echo "Mode de passe crypté : ".$hash."<br/>";
?>