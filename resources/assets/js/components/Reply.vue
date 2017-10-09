<template>
    <div>
        <div v-if="!edit" class="panel panel-default">
            <div class="panel-heading">
                <div class="level">
                    <div class="flex">
                        <span v-text="ago"></span>
                        <a href="#" v-text="data.user.name"></a> posted:
                    </div>
                    <div v-if="canUpdate" class="buttons-block">
                        <button class="btn btn-xs btn-info" @click="edit = true">Edit</button>
                        <button class="btn btn-xs btn-danger" @click="onDelete">Delete</button>
                    </div>
                </div>
            </div>
            <div class="panel-body" v-text="data.body">
            </div>
        </div><!-- show reply panel -->

        <div v-else>
            <div class="form-group">
                <textarea name="body" class="form-control" rows="3" v-model="data.body"></textarea>
            </div>
            <button class="btn btn-xs btn-primary" @click="onUpdate">Update</button>
            <button class="btn btn-xs btn-warning" @click="onCancel">Cancel</button>
        </div><!-- edit reply area  -->
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props: ['item'],

        data() {
            return {
                edit: false,
                data: this.item
            };
        },

        computed: {
            endpoint() {
                return location.pathname + '/replies/' + this.data.id;
            },

            ago() {
                return moment(this.data.created_at).fromNow() + '...';
            },

            canUpdate() {
                return this.authorize('updateReply', this.item);
            }
        },

        methods: {
            onCancel() {
                this.reset();
            },

            onUpdate() {
                axios.patch(this.endpoint, this.data)
                    .then(response => {
                        this.edit = false;
                        // this.$emit('updated', response.data);
                        this.$emit('updated');
                    })
                    .catch(errors => {
                        this.reset();
                        console.error('Failed to load data.');
                    });
            },

            onDelete() {
                axios.delete(this.endpoint)
                    .then(response => this.$emit('deleted'))
                    .catch(errors => console.log(errors));
            },

            reset() {
                this.edit = false;
                this.data = this.item;
            }
        }
    };
</script>

<style scoped>
    button { margin: 0 2px; width: 52px;}
    .panel-heading { background-color: #f5f5f5; padding: 5px 15px; }
</style>
