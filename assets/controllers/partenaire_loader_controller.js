import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['content'];
    static values = { url: String };

    connect() {
        this.load();
    }

    async load() {
        try{
            const response = await fetch(this.urlValue);
            this.contentTarget.innerHTML = await response.text();
        } catch (e) {
            console.e("Erreur lors du chargement des partenaires: ", e);
            this.contentTarget.innerHTML = "<p> Impossible de charger les partenaires. </p>"
        }
    }
}
