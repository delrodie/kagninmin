import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        // Réinitialise les dropdowns Bootstrap après chaque navigation Turbo
        this.initializeDropdowns();

        // Écoute les navigations Turbo
        document.addEventListener('turbo:load', () => {
            this.initializeDropdowns();
        });
    }

    initializeDropdowns() {
        // Supprime les anciennes instances pour éviter les doublons
        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            if (toggle.dropdown) {
                toggle.dropdown.dispose();
            }
        });

        // Réinitialise
        const dropdowns = document.querySelectorAll('.dropdown-toggle');
        dropdowns.forEach(dropdown => {
            new bootstrap.Dropdown(dropdown);
        });
    }
}
