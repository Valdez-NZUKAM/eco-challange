<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: ../index.php');
        exit;
    }else{
        require_once("./php/ClassMiel.php");
        $miel = new ClassMiel();
        $miels = $miel->getListMiels();
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mellifica</title>
        <link href="style.css" rel="stylesheet" />
        <script src="./js/functions.js"></script>
    </head>
    <body>
        <header>
            <img id="logo" src="img/logo_Mellifica.png" alt="Logo de Mellifica" />
            <div id="titre">Mellifica</div>
            <img id="gif" src="./gif/abeille.gif">
        </header>
        <form id="formDeconnexion" action="./php/deconnexion.php" method="GET">
                <div class="bouton" onclick="envoiFormulaire(this.closest('form'))">Déconnexion</div>
            </form>
        <main>
            <div id="soustitre">Connexion</div>
<!-- Ajout Miel -->             
            <section>               
                <p>Ajouter Miel</p>
                <form class="modifyMiel" action="./php/ajouterMiel.php" method="POST">
                    <label for="type">Type de miel :</label>
                    <input type="text" id="type" name="type">

                    <label for="photo">Chemin de la photo :</label>
                    <input type="text" id="photo" name="photo">

                    <div class="bouton" onclick="envoiFormulaire(this.closest('form'))">Ajouter</div>
                </form>
            </section>
<!-- Suppression Miel -->              
            <section>
                <p>Supprimer</p>
                <?php if (empty($miels)): ?>
                    <div>Aucun miel enregistré.</div>
                <?php else: ?>
                    <?php foreach ($miels as $unMiel): ?>
                        <div class="modifyMiel">
                            <span>
                                <?= htmlspecialchars(
                                    $unMiel['type'] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </span>
                            <span>
                                Identifiant :
                                <?= (int) $unMiel['id'] ?>
                            </span>
                            <form action="./php/supprimerMiel.php" method="POST">
                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= (int) $unMiel['id'] ?>"
                                >
                                <div class="bouton" onclick="envoiFormulaire(this.closest('form'))">Supprimer</div>
                            </form>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </main>
    </body>
</html>
