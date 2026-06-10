import { Controller } from '@hotwired/stimulus';
import * as bootstrap from 'bootstrap';

export default class extends Controller {
    connect() {

        document.querySelectorAll('[data-bs-toggle="dropdown"]')
            .forEach(el => {
                bootstrap.Dropdown.getOrCreateInstance(el);
            });

        document.querySelectorAll('[data-bs-toggle="offcanvas"]')
            .forEach(el => {
                bootstrap.Offcanvas.getOrCreateInstance(el);
            });
    }
}
