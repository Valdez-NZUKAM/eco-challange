<?php
require_once("ClassProduitDerive.php");

$oProduitDerive = new ClassProduitDerive();
$produitsDerives = $oProduitDerive->getAll();
echo "<div class='tous-les-produits'>";
foreach ($produitsDerives as $produit) {
    $nom = htmlspecialchars($produit['produit']);
    $photo = htmlspecialchars($produit['photo']);
    echo "<div class='produit'>";
    echo "<div>".$nom."</div>";
    echo "<img class='img-produit' src = '".$photo."' alt = '".$nom."'></img>";
    echo "</div>";
}
echo "</div>";
