<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">

                <div class="form-group form-group-sm">
                    <label for="name" class="col-sm-3">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input-sm" name="name" v-model="form.name" required :disabled="!canUpdate">
                        <span class="error-message" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                    </div>
                </div>

                <div v-if="canUpdate" class="form-group form-group-sm">
                    <label for="email" class="col-sm-3">Email</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control input-sm" name="email" v-model="form.email" required :disabled="!canUpdate">
                        <span class="error-message" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <label for="country" class="col-sm-3">Country</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="country" v-model="form.country" @change="form.errors.clear('country')" :disabled="!canUpdate">
                            <option value="Russia">Russia</option>
                            <option value="USA">USA</option>
                            <option value="undefined">undefined</option>
                        </select>
                        <span class="error-message" v-if="form.errors.has('country')" v-text="form.errors.get('country')"></span>
                    </div>
                </div>

                <button v-if="canUpdate" class="btn btn-sm btn-info" :disabled="form.errors.any()">Update</button>

            </form>
        </div>
    </div>
</template>

<script>
    import Form from '../utilities/Form';

    export default {
        props: ['user'],

        data() {
            return {
                form: new Form({
                    name:  this.user.name,
                    email: this.user.email,
                    country: this.user.country
                })
            }
        },

        computed: {
            endpoint() {
                return `/profiles/${this.user.slug}/data`;
            },

            canUpdate() {
                return this.authorize('updateProfile', this.user);
            }
        },

        methods: {
            onSubmit() {
                this.form.patch(this.endpoint)
                    .then(data => console.log(data))
                    .catch(errors => console.log(errors));
            }
        }
    }
</script>

<style scoped>
    .row { margin: 10px 0; }
    label { font-size: 0.9em; }
    .error-message { font-size: 0.8em; color: red; }
</style>
