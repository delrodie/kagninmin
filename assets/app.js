import './stimulus_bootstrap.js';
import './js/scroll-animate.js';
import './styles/app.css';
import './styles/btn-top.css';
import './styles/responsive.css';

function initAnimations() {
    // Réinitialise les éléments animate.css
    document.querySelectorAll('.animate__animated').forEach(el => {
        // Force le re-déclenchement en retirant puis remettant les classes
        el.style.animationPlayState = 'paused';
        void el.offsetWidth; // Reflow trick
        el.style.animationPlayState = 'running';
    });
}

function initNavbar() {
    const btnGoTop = document.querySelector(".btn-gotop");
    const navbar = document.querySelector(".navbar");

    if (!btnGoTop || !navbar) return;

    // Nettoie les anciens listeners pour éviter les doublons
    window.removeEventListener("scroll", handleScroll);
    window.addEventListener("scroll", handleScroll);

    btnGoTop.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
}

function handleScroll() {
    const btnGoTop = document.querySelector(".btn-gotop");
    const navbar = document.querySelector(".navbar");

    if (!btnGoTop || !navbar) return;

    if (window.scrollY > 100) {
        btnGoTop.style.display = "block";
        navbar.classList.add("fixed-top");
    } else {
        btnGoTop.style.display = "none";
        navbar.classList.remove("fixed-top");
    }
}

function pwaInstall() {
    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        document.getElementById('install-container').style.display = 'block';
    });

    window.addEventListener('appinstalled', () => {
        document.getElementById('install-container').style.display = 'none';
    })
}

// Déclenché à chaque navigation Turbo ET au premier chargement
document.addEventListener("turbo:load", () => {
    initNavbar();
    initAnimations();
    pwaInstall();
});


