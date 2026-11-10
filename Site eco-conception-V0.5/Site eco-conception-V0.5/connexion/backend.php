<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }

    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    require_once("./php/ClassMiel.php");
    $miel = new ClassMiel();
    $miels = $miel->getListMiels();
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestion des stocks | Mellifica</title>
        <link href="style.css?v=6" rel="stylesheet">
        <script src="./js/functions.js"></script>
    </head>
    <body class="admin-page">
        <header class="admin-header">
            <a class="admin-brand" href="./index.php" aria-label="Retour à la page de connexion Mellifica">
                <img id="logo" src="img/logo_Mellifica.png" alt="">
                <span>Mellifica</span>
            </a>
            <img class="admin-bee" src="./gif/abeille.gif" alt="">
            <form class="admin-logout-form" action="./php/deconnexion.php" method="GET">
                <button class="admin-logout" type="submit">Déconnexion</button>
            </form>
        </header>

        <main class="admin-main">
            <section class="admin-intro" aria-labelledby="admin-title">
                <span class="admin-kicker">ESPACE ADMINISTRATEUR</span>
                <h1 id="admin-title">Gestion des stocks</h1>
                <p>Consultez et gérez les informations de vos miels.</p>
            </section>

            <section class="admin-add-panel" aria-labelledby="add-title">
                <div class="admin-panel-heading">
                    <h2 id="add-title">Ajouter un miel</h2>
                    <p>Ajoutez un produit à votre catalogue.</p>
                </div>
                <form class="admin-add-form" action="./php/ajouterMiel.php" method="POST">
                    <div class="admin-form-field">
                        <label for="type">Nom du miel</label>
                        <input type="text" id="type" name="type" placeholder="Ex. Miel de lavande" required>
                    </div>
                    <div class="admin-form-field">
                        <label for="photo">Chemin de la photo</label>
                        <input type="text" id="photo" name="photo" placeholder="images/miel.jpg" required>
                    </div>
                    <button class="admin-add-button" type="submit">Ajouter le miel</button>
                </form>
            </section>

            <section class="inventory-section" aria-labelledby="inventory-title">
                <div class="inventory-heading">
                    <div>
                        <h2 id="inventory-title">Vos miels</h2>
                        <p>Gérez vos produits et leurs informations.</p>
                    </div>
                    <span class="inventory-count"><?= count($miels) ?> produits</span>
                </div>

                <?php if (empty($miels)): ?>
                    <div class="inventory-empty">Aucun miel enregistré pour le moment.</div>
                <?php else: ?>
                    <div class="stock-grid">
                        <?php foreach ($miels as $unMiel): ?>
                            <?php $type = $unMiel['type'] ?? ''; ?>
                            <article class="stock-card">
                                <div class="stock-photo">
                                    <?php if (!empty($unMiel['photo'])): ?>
                                        <img
                                            src="<?= htmlspecialchars($unMiel['photo'], ENT_QUOTES, 'UTF-8') ?>"
                                            alt="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>"
                                            loading="lazy"
                                        >
                                    <?php else: ?>
                                        <div class="stock-photo-empty">Photo non disponible</div>
                                    <?php endif; ?>
                                </div>
                                <div class="stock-card-content">
                                    <div class="stock-title-row">
                                        <h3><?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?></h3>
                                        <span class="stock-id">#<?= (int) $unMiel['id'] ?></span>
                                    </div>
                                    <div class="stock-quantity-row">
                                        <span class="stock-label">Quantité</span>
                                        <div class="quantity-control">
                                            <button
                                                type="button"
                                                class="quantity-button"
                                                data-quantity-change="-1"
                                                aria-label="Diminuer la quantité de <?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>"
                                                disabled
                                            >−</button>
                                            <output class="stock-quantity" aria-live="polite">0</output>
                                            <button
                                                type="button"
                                                class="quantity-button"
                                                data-quantity-change="1"
                                                aria-label="Augmenter la quantité de <?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>"
                                            >+</button>
                                        </div>
                                    </div>
                                    <div class="stock-actions">
                                        <button
                                            type="button"
                                            class="stock-action-button stock-edit-button"
                                            data-edit-miel
                                            data-miel-id="<?= (int) $unMiel['id'] ?>"
                                            data-miel-type="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>"
                                            data-miel-photo="<?= htmlspecialchars($unMiel['photo'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        >Modifier</button>
                                        <button
                                            type="button"
                                            class="stock-action-button stock-delete-button"
                                            data-delete-miel
                                            data-miel-id="<?= (int) $unMiel['id'] ?>"
                                            data-miel-type="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>"
                                        >Supprimer</button>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </main>

        <dialog class="admin-dialog" id="editMielDialog" aria-labelledby="editDialogTitle">
            <form action="./php/modifierMiel.php" method="POST" id="editMielForm">
                <h2 id="editDialogTitle">Modifier le miel</h2>
                <input type="hidden" name="id" id="editMielId">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                <div class="admin-form-field">
                    <label for="editMielType">Nom du miel</label>
                    <input type="text" id="editMielType" name="type" maxlength="255" required>
                </div>
                <div class="admin-form-field">
                    <label for="editMielPhoto">Chemin de la photo</label>
                    <input type="text" id="editMielPhoto" name="photo" maxlength="255" required>
                </div>
                <div class="admin-dialog-actions">
                    <button class="admin-dialog-cancel" type="button" data-close-dialog>Annuler</button>
                    <button class="admin-add-button" type="submit">Enregistrer</button>
                </div>
            </form>
        </dialog>

        <dialog class="admin-dialog" id="deleteMielDialog" aria-labelledby="deleteDialogTitle">
            <form action="./php/supprimerMiel.php" method="POST">
                <h2 id="deleteDialogTitle">Supprimer ce miel ?</h2>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                <p>Confirmez la suppression de <strong id="deleteMielName"></strong>. Cette action est définitive.</p>
                <input type="hidden" name="id" id="deleteMielId">
                <div class="admin-dialog-actions">
                    <button class="admin-dialog-cancel" type="button" data-close-dialog>Annuler</button>
                    <button class="admin-delete-confirm" type="submit">Supprimer</button>
                </div>
            </form>
        </dialog>

        <dialog class="admin-dialog" id="confirmEditDialog" aria-labelledby="confirmEditTitle">
            <form method="dialog">
                <h2 id="confirmEditTitle">Confirmer la modification ?</h2>
                <p>Les informations de ce miel seront mises à jour.</p>
                <div class="admin-dialog-actions">
                    <button class="admin-dialog-cancel" type="button" data-close-dialog>Annuler</button>
                    <button class="admin-add-button" type="button" data-confirm-edit>Confirmer</button>
                </div>
            </form>
        </dialog>
    </body>
</html>
