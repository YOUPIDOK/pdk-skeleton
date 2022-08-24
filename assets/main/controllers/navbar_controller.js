import { Controller } from '@hotwired/stimulus';
import AOS from 'aos/dist/aos';

export default class extends Controller {
    static targets = [ "navbar" ]

    oldScrollY = 0;

    connect() {
        window.addEventListener('scroll', () => {
            let main = document.querySelector("main");

            // If scroll down
            if (this.oldScrollY < window.scrollY) {
                // Reset initals attributs
                this.navbarTarget.style.position = 'initial';
                this.navbarTarget.style.top = '0'
                main.style.marginTop = '0';
            }

            // If scroll up
            if (this.oldScrollY > window.scrollY) {
                // Show only on window
                this.navbarTarget.style.position = 'fixed';

                // Show only on top + headerHeight
                let header = document.querySelector('header');
                this.navbarTarget.style.top = header.offsetHeight + 'px';

                // Add navbarHeight on main because position fixed set initial navabar space to empty
                main.style.marginTop = this.navbarTarget.offsetHeight + 'px';
            }

            this.oldScrollY = window.scrollY;
        });
    }
}
