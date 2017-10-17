<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">

                <div class="form-group form-group-sm">
                    <label for="name" class="col-sm-3">Password</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control input-sm" name="password" v-model="form.password">
                        <span class="error-message" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></span>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <label for="password" class="col-sm-3">Confirm Password</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control input-sm" name="password" v-model="form.password_confirmation">
                        <span class="error-message" v-if="form.errors.has('password_confirmation')" v-text="form.errors.get('password_confirmation')"></span>
                    </div>
                </div>

                <button class="btn btn-sm btn-info" :disabled="form.errors.any()">Update</button>

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
                    password:  '*******',
                    password_confirmation: '*******'
                })
            }
        },

        computed: {
            endpoint() {
                return `/profiles/${this.user.slug}/password`;
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
