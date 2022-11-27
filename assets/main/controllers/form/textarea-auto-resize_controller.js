import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [ "textarea" ];

    connect() {
        this.resize();
    }

    resize() {
        this.textareaTarget.style.cssText = 'height:auto; padding:0';
        this.textareaTarget.style.cssText = 'height:' + (this.textareaTarget.scrollHeight + 10) + 'px';
    }
}
