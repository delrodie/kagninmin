import { Controller } from '@hotwired/stimulus';
import { Fancybox } from '@fancyapps/ui';

export default class extends Controller {
    connect() {
        // Détruit toute instance existante pour éviter les doublons
        this.disconnect();

        // Initialise Fancybox
        this.fancybox = Fancybox.bind('[data-fancybox]', {
            // Options recommandées
            Carousel: {
                infinite: false,
            },
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: [],
                    right: ["close"],
                },
            },
            Images: {
                zoom: true,
            },
            // Animation plus fluide
            showClass: "fancybox-zoomIn",
            hideClass: "fancybox-zoomOut",
        });
    }

    disconnect() {
        // Nettoyage important avec Turbo
        if (this.fancybox) {
            this.fancybox.destroy();
            this.fancybox = null;
        }
    }
}
