/******************************************
Affichage au chargemenet de la page d'accueil
******************************************/  
window.addEventListener("load", function() {
    const myPage = "Accueil";
    // Mise à jour du titre de la page
    const sousTitre = document.getElementById("soustitre");
    sousTitre.innerHTML = myPage;

    // Create an XMLHttpRequest object
    const xhttp = new XMLHttpRequest();

    // Define a callback function
    xhttp.onload = function() {
        document.getElementsByTagName("section")[0].innerHTML = this.responseText;
        initializeViewer();
    };

    xhttp.onerror = function() {
        let errorString = "Page introuvable";
        document.getElementsByTagName("section")[0].innerHTML = errorString;
    };

    xhttp.open("GET", "./php/routage.php?page=" + encodeURIComponent(myPage));
    xhttp.send();   
});

/******************************************
Fonction dédiée à charger le contenu d'une page dans la section principale de la page index.html
******************************************/
function loadPage(element, event){
    // stoppe la propagation de l'événement 
    event.preventDefault();

    const myPage = element.innerHTML;
    clearInterval(myTimerInterval);

    // Mise à jour du titre de la page
    const sousTitre = document.getElementById("soustitre");
    sousTitre.innerHTML = myPage;

    // Create an XMLHttpRequest object
    const xhttp = new XMLHttpRequest();

    // Define a callback function
    xhttp.onload = function() {
        document.getElementsByTagName("section")[0].innerHTML = this.responseText;
        if (myPage === "Accueil") {
            initializeViewer();
        }
    };
    xhttp.onerror = function() {
        let errorString = "Page introuvable";
        document.getElementsByTagName("section")[0].innerHTML = errorString;
    };

    xhttp.open("GET", "./php/routage.php?page=" + encodeURIComponent(myPage));
    xhttp.send();
}

function initializeViewer() {
    const containerViewer = document.getElementById("viewer");
    if (!containerViewer) {
        return;
    }

    loadImg("./viewer/imgViewer.xml", containerViewer, function() {
        if (!containerViewer.isConnected) {
            return;
        }
        clearInterval(myTimerInterval);
        myTimerInterval = setInterval(myTimerScrollImg, timeScrolling);
    });
}
