# Optimisations de sobriété fonctionnelle

## Étapes réalisées

- Suppression du chargement de jQuery sur le site et sur la page de connexion : les scripts utilisés sont en JavaScript natif et ne dépendaient pas de jQuery.
- Ajout de `defer` aux scripts du site et de la connexion pour ne pas bloquer l’analyse du HTML pendant leur téléchargement.
- Conservation du viewer et de son défilement automatique, comme demandé.
- Arrêt du minuteur du viewer lorsqu’on quitte l’accueil. Il est démarré après le chargement de ses données XML et uniquement lorsque le viewer est présent.
- Utilisation des textes alternatifs déjà définis dans le XML pour les images du viewer.
- Conservation des rubriques séparées et chargées une par une à la demande. Le site ne récupère pas le contenu de toutes les rubriques au démarrage ; ce fonctionnement est plus sobre que de tout charger ensemble.
- Le script du viewer est différé avec `defer`. Sa feuille CSS reste incluse dans l’accueil, puisque c’est la page affichée au démarrage et qui contient le viewer.
- Création de `style.min.css`, `viewer/viewer.min.css`, `js/loadpage.min.js` et `viewer/scriptViewer.min.js`, puis mise à jour de `index.html` pour utiliser ces versions minifiées. Les fichiers sources restent disponibles et lisibles pour la maintenance. Le poids total de ces quatre ressources passe d’environ 12,4 Ko à 6,0 Ko (environ 52 % de moins, hors compression HTTP).
- Vérification de la syntaxe des deux scripts minifiés et de l’existence des quatre fichiers référencés par `index.html`.
- Réduction de la portée du cookie de session de l’administration à son dossier `/connexion/`, au lieu du chemin global par défaut `/`, afin que les ressources publiques hors de ce dossier ne reçoivent pas ce cookie. Le chemin est calculé à partir de l’URL et encodé correctement (y compris les espaces), pour rester valable si le projet est servi sous un autre préfixe.
- Vérification de l’en-tête HTTP local : le cookie PHP de l’administration est désormais limité au chemin du dossier `connexion`. Pour retester une ancienne session déjà ouverte, supprimer l’ancien cookie `PHPSESSID` enregistré pour `localhost` puis relancer l’audit ; cela peut déconnecter les autres applications PHP locales utilisant ce cookie.
- Ajout de règles de cache HTTP dans `.htaccess` : les ressources statiques (CSS, JavaScript, images, polices et XML) sont mises en cache pendant 7 jours ; les pages HTML/PHP doivent être revalidées à chaque visite afin de ne pas conserver d’ancien contenu dynamique.
- Vérification de la feuille de style de connexion signalée : `connexion/style.css` renvoie bien `Cache-Control: public, max-age=604800`, y compris avec une requête HTTP `HEAD`. Le même en-tête est présent sur le JavaScript de connexion ; la page PHP renvoie une règle distincte de revalidation.
- Mise en cache du `favicon.ico` par défaut de XAMPP à la racine `http://localhost/favicon.ico`. Comme cette URL est servie depuis `C:\xampp\htdocs`, en dehors du dossier du projet, une règle ciblée a été ajoutée dans `C:\xampp\htdocs\.htaccess` pour lui appliquer le cache de 7 jours.
- Généralisation de la minification aux six feuilles CSS et scripts chargés par le site public et l’espace connexion. `build-assets.js` utilise esbuild pour produire les fichiers `.min.css` et `.min.js` à partir des sources.
- Commandes de génération, à lancer dans `Site-eco-conception-V0.5/Site eco-conception-V0.5/` : `npm ci` après récupération du projet, puis `npm run build` avant publication. Pendant le développement, `npm run watch` régénère les versions minifiées dès qu’une source change. Les sources restent les fichiers à modifier ; ne pas éditer les fichiers `.min.*` à la main.
- Mise à jour des références dans les pages publiques et les deux pages de connexion/administration pour servir exclusivement les versions minifiées.
- Vérification : `npm run build` a généré les six fichiers ; les scripts minifiés passent la vérification de syntaxe JavaScript, et les ressources minifiées de connexion sont servies par Apache avec leur en-tête de cache.
- Correction « No cookie for static resources » : le CSS et le JavaScript de connexion sont désormais générés dans `assets/` à la racine du site, et les pages de connexion réutilisent les images partagées dans `img/` et `gif/`. Ces ressources ne sont donc plus demandées sous `/connexion/`, chemin restreint du cookie d’administration. Les pages et actions PHP restent sous `/connexion/` afin de conserver la session. Vérification à faire en audit après rechargement : les ressources administratives ne doivent plus recevoir le cookie de session.
- Redimensionnement des images d’en-tête avant leur envoi au navigateur : le logo passe de 5699 × 4182 (248 548 octets) à 100 × 73 (8 184 octets), et le GIF animé de l’abeille de 512 × 288 (2 075 395 octets) à 100 × 56 (409 992 octets). Les 155 images de l’animation sont conservées. Toutes les pages indiquent aussi les attributs `width` et `height` correspondants.
- Configuration HTTP/2 préparée pour XAMPP local : chargement du module `mod_http2` et annonce des protocoles `h2` et `http/1.1` dans l’hôte TLS Apache. La syntaxe Apache a été validée (`httpd -t`), mais l’instance active n’a pas encore été redémarrée : `httpd -k restart` a échoué car Apache n’est pas installé comme service Windows. Redémarrer Apache avec le bouton Stop/Start du panneau XAMPP, puis ouvrir le site en HTTPS (`https://localhost/eco-challange/Site-eco-conception-V0.5/Site%20eco-conception-V0.5/`) ; HTTP sur le port 80 reste en HTTP/1.1. Le certificat XAMPP local est auto-signé et ne contient pas de SAN ; le navigateur peut afficher un avertissement TLS, qu’il ne faut pas contourner en production. L’hébergement public doit également activer HTTP/2 dans sa propre configuration serveur.
- Préparation du déploiement Linux : correction de cinq `require_once` dont la casse ne correspondait pas au nom réel des fichiers PHP. Windows tolère souvent ces différences, mais les systèmes de fichiers Linux sont sensibles à la casse.

## Vérification du déploiement Linux (Ubuntu/Debian + Apache)

Les configurations Apache de XAMPP ne sont pas celles du serveur Linux : recopier les fichiers du projet, en particulier le `.htaccess` à la racine du site, puis configurer Apache et PHP sur la machine Linux.

1. Installer/vérifier Apache, PHP et MariaDB/MySQL. PHP doit avoir PDO MySQL (`php -m` doit afficher `PDO` et `pdo_mysql`). Utiliser la version PHP supportée par le code.
2. Servir le dossier du site par un VirtualHost Apache avec HTTPS. Dans le bloc `<Directory>` du DocumentRoot, autoriser `.htaccess` (`AllowOverride All`) et l’accès (`Require all granted`). Le `.htaccess` du projet définit les en-têtes de cache ; les règles de `C:\xampp\htdocs\.htaccess` ne concernent que XAMPP et ne sont pas à transférer.
3. Créer/configurer un VirtualHost, activer un certificat TLS valide pour le nom de domaine, puis vérifier les modules et la configuration :
   `sudo a2enmod headers ssl http2`
   `sudo apachectl -t`
   `sudo systemctl reload apache2`
   Pour HTTP/2, ajouter `Protocols h2 http/1.1` au VirtualHost HTTPS. Vérifier `apachectl -M` : `http2_module` doit être chargé. Avec PHP, utiliser PHP-FPM et `mpm_event` si le mode `prefork`/mod_php empêche HTTP/2.
4. Importer `mellifica.sql` dans MariaDB/MySQL. Créer un utilisateur SQL dédié à l’application, avec les seuls droits nécessaires sur `mellifica`. Configurer les paramètres dans les deux classes `ClassDatabase.php` (site public et connexion) ; ne pas conserver l’utilisateur `root` ni un mot de passe vide en production.
5. Si les fichiers générés `.min.css`/`.min.js` ne sont pas déjà livrés, installer Node.js puis lancer `npm ci` et `npm run build` depuis le dossier contenant `package.json`. Node.js n’est pas nécessaire à l’exécution du site une fois les fichiers générés.
6. Vérifier la casse exacte des noms de fichiers, images, dossiers et chemins `require_once` : Linux distingue majuscules et minuscules. Déployer dans un chemin simple, sans espace si possible, et donner à Apache un accès en lecture aux fichiers ; limiter l’écriture aux seuls dossiers qui en ont vraiment besoin.
7. Après déploiement, vérifier les pages publiques, la connexion/déconnexion admin, les opérations en base, le certificat, les erreurs Apache/PHP et les en-têtes :
   `curl -sSI https://exemple.tld/chemin/`
   `curl -sS -o /dev/null -w '%{http_version}\n' --http2 https://exemple.tld/chemin/`
   Les ressources statiques doivent avoir `Cache-Control` et ne pas recevoir le cookie de session ; le protocole attendu pour HTTP/2 est `2`. Ajouter un favicon dans le DocumentRoot ou référencer explicitement celui du site : `/favicon.ico` n’est pas automatiquement celui de XAMPP.

## À faire avec Squoosh

Les cinq images du viewer se trouvent dans `Site-eco-conception-V0.5/Site eco-conception-V0.5/PhotosSlider/`.
Les compresser avec Squoosh, comparer leur poids avant/après, puis remplacer les fichiers dans ce dossier en conservant leurs noms. Les images d’en-tête ont déjà été redimensionnées aux dimensions réellement affichées.

## Décisions et vérifications

- Les cinq images du viewer sont conservées : le sujet du projet demande un viewer fonctionnel.
- Les pages « Miels », « Produits dérivés », « Fabrication » et « Contact » sont conservées. Elles répondent à des besoins différents et sont déjà chargées uniquement quand le visiteur les sélectionne.
- Le viewer reste une fonctionnalité de l’accueil ; ses images ne sont pas supprimées.