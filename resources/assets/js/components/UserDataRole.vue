<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">

                <div class="form-group form-group-sm">
                    <label for="country" class="col-sm-3">Role</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="role" v-model="form.role" @change="form.errors.clear('role')">
                            <option value="reader">reader</option>
                            <option value="writer">writer</option>
                            <option value="admin">admin</option>
                        </select>
                        <span class="error-message" v-if="form.errors.has('role')" v-text="form.errors.get('role')"></span>
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
                    role:  this.user.role,
                })
            }
        },

        computed: {
            endpoint() {
                return `/profiles/${this.user.slug}/role`;
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
