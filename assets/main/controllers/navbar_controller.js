import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [ "navbar" ]

    oldScrollY = 0;

    connect() {
        window.addEventListener('scroll', () => {
            // If scroll down
            if (this.oldScrollY < window.scrollY) {
                this.navbarTarget.classList.remove('top-0');
                this.navbarTarget.classList.remove('position-sticky');
            }

            // If scroll up
            if (this.oldScrollY > window.scrollY) {
                this.navbarTarget.classList.add('position-sticky');
                this.navbarTarget.classList.add('top-0');
            }

            this.oldScrollY = window.scrollY;
        });
    }
}
