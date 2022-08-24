import { Controller } from '@hotwired/stimulus';
import AOS from 'aos/dist/aos';

export default class extends Controller {
    static targets = [ "navbar" ]

    oldScrollY = 0;

    connect() {

        window.addEventListener('scroll', () => {
            if (this.oldScrollY < window.scrollY) {
                this.navbarTarget.style.position = 'relative';
                this.navbarTarget.style.top = '0'
                console.log('down');
            } else {
                this.navbarTarget.style.position = 'fixed';
                this.navbarTarget.style.top = document.querySelector('header').offsetHeight + 'px';
                console.log('up');
            }
            this.oldScrollY = window.scrollY;
        });
    }
}
