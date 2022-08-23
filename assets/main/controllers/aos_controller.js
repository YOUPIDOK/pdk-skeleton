import { Controller } from '@hotwired/stimulus';
import AOS from 'aos/dist/aos';

export default class extends Controller {

    initialize() {
        AOS.init();
    }
}
