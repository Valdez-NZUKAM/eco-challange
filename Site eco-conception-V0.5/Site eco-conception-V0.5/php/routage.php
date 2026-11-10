<?php
    $route = $_GET["page"];

    if($route == "Miels"){
        require_once("miels.php");
    }
    elseif($route == "Produits dérivés"){
        require_once("produitsDerives.php");
    }
    elseif($route == "Contact"){
        require_once("contact.php");
    }
    elseif($route == "Fabrication"){
        require_once("video.php");
    }    
    else{
        require_once("accueil.php");
    }

?>