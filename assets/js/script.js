

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