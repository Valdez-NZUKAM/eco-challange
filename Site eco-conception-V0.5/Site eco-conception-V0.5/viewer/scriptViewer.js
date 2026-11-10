var imgPostition = 0;
var myTimerInterval;
var timeScrolling = 4000; 

/******************************************
Fonction JS à appeler au chargement de la page web
*******************************************/
//loadImg("./viewer/imgViewer.xml");
/******************************************
// Démarrage du timer pour le scrolling automatique
*******************************************/
// myTimerInterval = setInterval(myTimerScrollImg, timeScrolling);


/******************************************
FONCTION permettant de colorier les selecteurs d'images en blanc
*******************************************/
function unselectSelectorsImg(){
	let tabSelecteur = document.getElementsByClassName('selectorViewer');
	for(let i=0; i<tabSelecteur.length; i++){
		tabSelecteur[i].style.backgroundColor = "white";
	}
}

/******************************************
FONCTION permet d'afficher une image en particulier du viewer
*******************************************/
function displayImg(imgNumber){
	// Récupérer la taille d'une image
	let slider  = document.getElementById('slider');
	let img  = slider.firstChild.nextSibling;
	let sizeImg = img.width;
	// Calculer le positionnement du slider pour afficher l'image concernée
	let newPosition = imgNumber * sizeImg * -1;
	let strNewPosition = newPosition.toString()+"px";
	
	// positionner le slider
	slider.style.left = strNewPosition;
}

/******************************************
FONCTION permettant déplacer le slider d'images
*******************************************/
function scrollImg(imgSelector){
	// Stopper le timer de défilement
	clearInterval(myTimerInterval);
	// Colorier le selecteur d'image concernée
	unselectSelectorsImg();
	//imgSelector.style.backgroundColor = "lightGrey";
	imgSelector.style.backgroundColor = "#54b454";
	// Récupérer la position de l'image à partir de son attribut name
	imgPostition = imgSelector.getAttribute('name');
	// Afficher l'image concernée
	displayImg(imgPostition);
	// relancer le timer de défilement
	myTimerInterval = setInterval(myTimerScrollImg, timeScrolling);
}

/******************************************
FONCTION permettant le décallage automatique du slider
*******************************************/
function myTimerScrollImg() {
	let nbImg = document.getElementsByClassName('selectorViewer').length;
	imgPostition ++;
	if (imgPostition == nbImg){
		imgPostition = 0;
	}
	// Colorier le selecteur d'image concernée
	unselectSelectorsImg();
	let imgSelector = document.getElementsByName(imgPostition)[0];
	//imgSelector.style.backgroundColor = "lightGrey"
	imgSelector.style.backgroundColor = "#54b454";
	// Afficher l'image concernée
	displayImg(imgPostition);
}

/******************************************
FONCTION permettant le chargment des images à partir d'un fichier XML
*******************************************/
function loadImg(path, targetContainer){
	const xhr = new XMLHttpRequest();
    // Traitement de la réponse
    xhr.onload = function () {
        // Récupération contenu XML
        const xml = xhr.responseXML;
        if (!xml) {
            console.error("Le document XML est invalide.");
            return;
        }else{
            // Conteneurs
            // Création de la fenêtre cntenant le slider
            const containerSlider = document.createElement("div");
            containerSlider.id = "containerSlider";
            // Création du slider d'images dans la page
            const slider = document.createElement("div");
            slider.id = "slider";
            targetContainer.appendChild(containerSlider);
            containerSlider.appendChild(slider);
            // Création du conteneur des bulles de selection
            const scroll = document.createElement("div");
            scroll.id = "scroll";
            targetContainer.appendChild(scroll);
           
            // Récupération de toutes les balises <image> dans le xml
            const images = xml.getElementsByTagName("image");
            // Parcours des images
            for (let i = 0; i < images.length; i++) {
                // Génération de la balise <IMG>
                const src = images[i].getElementsByTagName("src")[0].textContent;
                // Création de l'image
                const img = document.createElement("img");
                img.src = src;
                slider.appendChild(img);

                // Génération de la bulle de sélection de l'image
                // Génération de la balise <DIV>
                const div = document.createElement("div");
                div.className = "selectorViewer";
                div.setAttribute("name", i);
                // Premier sélecteur en vert
                if (i === 0) {
                    div.style.backgroundColor = "#54b454";
                }
                // Association de la fonction scrollImg
                div.addEventListener("click", function () {
                    scrollImg(this);
                });
                // Ajout au conteneur
                scroll.appendChild(div);
            }            
        }
    };
	// Callback error
    xhr.onerror = function () {
        console.error("Erreur réseau lors du chargement du XML.");
    };

	// Préparation de la requête
    xhr.open("GET", path, true);
    // Envoi de la requête AJAX
    xhr.send();
}


