<?php
require_once("ClassMiel.php");

$oMiel = new ClassMiel();
$miels = $oMiel->getTypeOfMiels();
echo "<div class='tous-les-produits'>";
foreach ($miels as $miel) {
    $nom = htmlspecialchars($miel['type']);
    $photo = htmlspecialchars($miel['photo']);
    echo "<div class='produit'>";
    echo "<div>".$nom."</div>";
    echo "<img class='img-produit' src='".$photo."'></img>";
    echo "</div>";
}
echo "</div>"
?>