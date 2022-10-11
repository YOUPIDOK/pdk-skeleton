import { Controller } from '@hotwired/stimulus';
import Choices from "choices.js";

export default class extends Controller {
    static targets = [ "select" ];
    static values = {
        options: String
    }

    default_options  = {
        loadingText: 'Chargement...',
        noResultsText: 'Aucun résultat',
        noChoicesText: 'Aucun choix',
        itemSelectText: 'Sélectionner',
    }

    connect() {
        // Extarct options parameter to JSON
        this.options = JSON.parse(this.optionsValue);

        // Merge default options and options parameter
        Object.entries(this.default_options).forEach(([key, value]) => {
            if (this.options[key] === undefined) {
                this.options[key] = value;
            }
        });

        // Create choises
        this.choices = new Choices(this.selectTarget, this.options);
    }
}
