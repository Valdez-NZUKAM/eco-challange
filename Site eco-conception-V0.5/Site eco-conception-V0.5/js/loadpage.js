let scrollUpdatePending = false;

window.addEventListener("scroll", function() {
    if (scrollUpdatePending) return;
    scrollUpdatePending = true;
    requestAnimationFrame(function() {
        scrollUpdatePending = false;
        updateActiveSection();
    });
}, { passive: true });
window.addEventListener("resize", updateActiveSection);

function updateActiveSection() {
    const sections = document.querySelectorAll(".page-section");
    const header = document.querySelector(".site-header");
    if (!sections.length || !header) return;

    const threshold = header.getBoundingClientRect().bottom + 12;
    let activePage = sections[0].dataset.page;
    sections.forEach(function(section) {
        if (section.getBoundingClientRect().top <= threshold) {
            activePage = section.dataset.page;
        }
    });
    if (window.scrollY + window.innerHeight >= document.documentElement.scrollHeight - 2) {
        activePage = sections[sections.length - 1].dataset.page;
    }
    document.querySelectorAll("nav a").forEach(function(link) {
        link.classList.toggle("active", link.dataset.page === activePage);
    });
}

const pages = [
    { name: "Accueil", heading: "Bienvenue dans notre univers" },
    { name: "Miels", heading: "Nos miels" },
    { name: "Produits dérivés", id: "Produits-derives", heading: "Les trésors de la ruche" },
    { name: "Fabrication", heading: "Le savoir-faire apicole" },
    { name: "Contact", heading: "Restons en contact" }
];

window.addEventListener("load", function() {
    const container = document.querySelector("main");
    pages.forEach(function(page) {
        const section = document.createElement("section");
        section.className = "page-section";
        section.id = "section-" + (page.id || page.name);
        section.dataset.page = page.name;
        container.appendChild(section);

        const request = new XMLHttpRequest();
        request.onload = function() {
            if (page.name === "Accueil") {
                section.innerHTML = this.responseText;
                loadImg("./viewer/imgViewer.xml", document.getElementById("viewer"));
                myTimerInterval = setInterval(myTimerScrollImg, timeScrolling);
                return;
            }

            const heading = document.createElement("div");
            heading.className = "content-section-heading";
            heading.innerHTML = "<p class=\"eyebrow\"><span></span> DÉCOUVRIR MELLIFICA</p><h2>" + page.heading + "</h2>";
            const content = document.createElement("div");
            content.className = "content-section-content";
            content.innerHTML = this.responseText;
            section.append(heading, content);
        };
        request.onerror = function() {
            section.textContent = "Cette rubrique est momentanément indisponible.";
        };
        request.open("GET", "./php/routage.php?page=" + encodeURIComponent(page.name));
        request.send();
    });
    updateActiveSection();
});

function loadPage(element, event) {
    event.preventDefault();
    const page = element.dataset.page || element.textContent.trim();
    const section = Array.from(document.querySelectorAll(".page-section")).find(function(item) {
        return item.dataset.page === page;
    });
    if (!section) return;

    const headerHeight = document.querySelector(".site-header").offsetHeight;
    const sectionTop = section.getBoundingClientRect().top + window.scrollY;
    window.scrollTo({ top: sectionTop - headerHeight - 12, behavior: "smooth" });
    document.querySelectorAll("nav a").forEach(function(link) {
        link.classList.toggle("active", link.dataset.page === page);
    });
    history.replaceState(null, "", "#" + section.id);
}
