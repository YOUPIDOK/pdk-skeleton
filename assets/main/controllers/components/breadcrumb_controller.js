import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [ "breadcrumb" ];

    connect() {
        this.breadcrumbTarget.scrollLeft = this.breadcrumbTarget.scrollWidth - this.breadcrumbTarget.clientWidth;
    }
}
