<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mellifica</title>
        <link href="style.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/4.0.0/jquery.min.js"></script>
        <script src="./js/functions.js"></script>
    </head>
    <body>
        <header>
            <img id="logo" src="img/logo_Mellifica.png" alt="Logo de Mellifica" />
            <div id="titre">Mellifica</div>
            <img id="gif" src="./gif/abeille.gif">
        </header>
        <main>
            <div id="soustitre">Connexion</div>
            <section>
                <form id="formConnexion" action="./php/connexion.php" method="POST">
                    <div>
                        <label for="login">Login: </label>
                        <input
                            type="text"
                            id="login"
                            name="login"
                        >
                    </div>
                    <div>
                        <label for="motdepasse">Mot de passe: </label>
                        <input
                            type="password"
                            id="motdepasse"
                            name="motdepasse"
                        >
                    </div>
                    <div class="bouton" onclick="envoiFormulaire(this.closest('form'))">Se connecter</div>
                </form>
            </section>
        </main>
    </body>
</html>
