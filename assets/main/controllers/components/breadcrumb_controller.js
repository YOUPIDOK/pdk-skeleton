import { Controller } from '@hotwired/stimulus';
import AOS from 'aos/dist/aos';

export default class extends Controller {
    static targets = [ "breadcrumb" ];

    connect() {
        this.breadcrumbTarget.scrollLeft = this.breadcrumbTarget.scrollWidth - this.breadcrumbTarget.clientWidth;
    }
}
