// scroll-animate.js
(function() {
  // Observer pour déclencher les animations
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      const el = entry.target;
      const animationClass = el.getAttribute('data-animate');
      const delay = el.getAttribute('data-delay') || '0s';
      const duration = el.getAttribute('data-duration') || '1s';

      if (entry.isIntersecting) {
        el.style.animationDelay = delay;
        el.style.animationDuration = duration;
        el.style.opacity = 1;
        el.classList.add(animationClass);
      } else {
        // reset quand l’élément sort de la vue
        el.style.opacity = 0;
        el.classList.remove(animationClass);
      }
    });
  }, { threshold: 0.2 });

  // Appliquer l’observer à tous les éléments
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('[data-animate]').forEach(el => {
      observer.observe(el);
    });
  });

  // Animation par lettre 
    window.addEventListener('DOMContentLoaded', () => {
        const el = document.querySelector('.animate__titre');
        const text = el.textContent; // récupère le texte dynamique
        el.textContent = ''; // vide le contenu

        // découpe en lettres et crée des spans
        text.split('').forEach((char, index) => {
            const span = document.createElement('span');
            span.textContent = char;
            span.classList.add('letter', 'animate__animated', 'animate__fadeIn');
            span.style.animationDelay = `${index * 0.05}s`;
            span.style.animationDuration = '0.6s';
            el.appendChild(span);
        });
    });

  // Parallaxe (léger calcul sur scroll)
  window.addEventListener('scroll', () => {
    document.querySelectorAll('[data-parallax]').forEach(el => {
      const position = el.getBoundingClientRect().top;
      const factor = parseFloat(el.getAttribute('data-parallax')) || 0;
      const offset = position * factor * 0.1;
      el.style.transform = `translateY(${offset}px)`;
    });
  });
})();