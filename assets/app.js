import './stimulus_bootstrap.js';

// JavaScript

/*  Button Go Top */
const btnGoTop = document.querySelector(".btn-gotop");
const navbar = document.querySelector(".navbar");
const sticky = navbar.offsetTop;

window.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
        btnGoTop.style.display = "block";
        navbar.classList.add("fixed-top");
    } else {
        btnGoTop.style.display = "none";
        navbar.classList.remove("fixed-top");
    }
});

btnGoTop.addEventListener("click", () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
});




import './styles/app.css';
import './styles/btn-top.css';
import './styles/responsive.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
