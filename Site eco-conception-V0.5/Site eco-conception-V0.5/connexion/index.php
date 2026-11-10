<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion | Mellifica</title>
        <meta name="theme-color" content="#183b2b">
        <link href="style.css?v=5" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/4.0.0/jquery.min.js"></script>
        <script src="./js/functions.js"></script>
    </head>
    <body>
        <header class="site-header">
            <a class="brand" href="../index.html" aria-label="Mellifica, accueil">
                <img id="logo" src="img/logo_Mellifica.png" alt="Logo de Mellifica" />
                <span id="titre">Mellifica</span>
            </a>
            <img id="gif" src="./gif/abeille.gif" alt="Abeille en vol">
        </header>
        <main>
            <section class="connexion-card" aria-labelledby="soustitre">
                <div class="card-intro">
                    <span class="eyebrow">VOTRE ESPACE MELLIFICA</span>
                    <h1 id="soustitre">Connexion</h1>
                    <p>Retrouvez votre espace Mellifica et gérez votre collection de miels.</p>
                </div>
                <form id="formConnexion" action="./php/connexion.php" method="POST">
                    <div class="form-field">
                        <label for="login">Login</label>
                        <input
                            type="text"
                            id="login"
                            name="login"
                            placeholder="Votre identifiant"
                            autocomplete="username"
                            required
                        >
                    </div>
                    <div class="form-field">
                        <label for="motdepasse">Mot de passe</label>
                        <input
                            type="password"
                            id="motdepasse"
                            name="motdepasse"
                            placeholder="Votre mot de passe"
                            autocomplete="current-password"
                            required
                        >
                    </div>
                    <button class="bouton" type="submit">Se connecter</button>
                </form>
                <p class="card-note">Le meilleur du miel, au même endroit.</p>
            </section>
        </main>
        <footer>© Mellifica · Le goût de la nature</footer>
    </body>
</html>
