<template>
    <div v-if="canUpdateProfile">
        <table class="table table-condensed">
              <notification v-for="(item, index) in items" :key="item.id" :notification="item" @markedAsRead="remove(index)"></notification>
        </table>

        <button v-if="!empty" class="btn btn-info" @click="markAll">Mark All As Read</button>

        <p v-else>There no notifications at the moment.</p>
    </div>
</template>

<script>
    import Notification from './Notification.vue';

    export default {
        props: ['user'],

        components: { Notification },

        data() {
            return {
                items: []
            };
        },

        computed: {
            endpoint() {
                return `/profiles/${this.user.slug}/notifications`;
            },

            empty() {
                return this.items.length === 0;
            },

            canUpdateProfile() {
                return this.authorize('updateProfile', this.user);
            }
        },

        created() {
            axios.get(this.endpoint)
                .then(response => this.items = response.data);
        },

        methods: {
            remove(index) {
                this.items.splice(index, 1);
            },

            markAll() {
                axios.delete(this.endpoint)
                    .then(() => this.items = [])
                    .catch(errors => console.log(errors));
            }
        }
    };
</script>
