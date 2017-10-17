import Errors from './Errors';

class Form {
    /**
     * Create a new Form instance
     *
     * @param {object} data
     */
    constructor(data) {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }

    /**
     * Fetch all relevant data for the form
     */
    data() {
        const data = {};

        for (let field in this.originalData) {
            data[field] = this[field];
        }

        return data;
    }

    /**
     * Reset the form fields
     */
    reset() {
        for(let field in this.originalData) {
            this[field] = '';
        }

        this.errors.clear();
    }

    /**
     * Submit the form via post request
     *
     * @param {string} url
     */
    post(url) {
        return this.submit('post', url);
    }

    /**
     * Submit a patch request
     *
     * @param {string} url
     */
    patch(url) {
        return this.submit('patch', url);
    }

    /**
     * Submit a delete request
     *
     * @param {string} url
     */
    delete(url) {
        return this.submit('delete', url);
    }

    /**
     * Submit the form
     *
     * @param {string} requestType
     * @param {string} url
     */
    submit(requestType, url) {
        return new Promise((resolve, reject) => {
            axios[requestType](url, this.data())
                .then(response => {
                    this.onSuccess(response.data, requestType);
                    resolve(response.data);
                })
                .catch(error => {
                    this.onFailure(error.response.data);
                    reject(error.response.data);
                });
        });
    }

    /**
     * Handle a successfull form submition
     *
     * @param {object} data
     */
    onSuccess(data, requestType = 'post') {
        if (requestType != 'patch') {
            this.reset();
        }
    }

    /**
     * Handle a failed form submition
     *
     * @param {object} errors
     */
    onFailure({errors}) {
        this.errors.record(errors);
    }
}

export default Form;
