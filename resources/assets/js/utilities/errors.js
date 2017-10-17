 class Errors {
    /**
     * Create a new Error instance
     */
    constructor() {
        this.errors = {};
    }

    /**
     * Determine if errors exist for the given field
     *
     * @param {string} field
     */
    has(field) {
        return this.errors.hasOwnProperty(field);
    }

    /**
     * Determine if we have any errors
     */
    any() {
        return Object.keys(this.errors).length > 0;
    }

    /**
     * Retrive the error message for the field
     *
     * @param {string} field
     */
    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
        return '';
    }

    /**
     * Record new errors
     *
     * @param {object} errors
     */
    record(errors) {
        this.errors = errors;
    }

    /**
     * Clear specified or all error fields
     *
     * @param {string|null} field
     */
    clear(field = null) {
        if (field) {
            delete this.errors[field];
            return;
        }

        this.errors = {};
    }
}

export default Errors;
