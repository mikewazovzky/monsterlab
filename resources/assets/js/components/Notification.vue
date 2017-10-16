<template>
    <tbody>
        <tr>
            <td v-text="notification.created_at"></td>
            <td>
                <component v-bind:is="notificationType" :notification="notification"></component>
            </td>
            <td>
                <button class="btn btn-xs btn-info" @click="markAsRead">Mark As Read</button>
            </td>
        </tr>
    </tbody>
</template>

<script>
    import UserConfirmed from './notifications/UserConfirmed.vue';
    import UserRegistered from './notifications/UserRegistered.vue';
    import PostCreatedAdminNotification from './notifications/PostCreatedAdminNotification.vue';
    import ReplyCreatedAdminNotification from './notifications/ReplyCreatedAdminNotification.vue';
    import ReplyCreatedUserNotification from './notifications/ReplyCreatedUserNotification.vue';
    import DefaultNotification from './notifications/DefaultNotification.vue';

    export default {
        props: ['notification'],

        components: {
            UserConfirmed,
            UserRegistered,
            PostCreatedAdminNotification,
            ReplyCreatedAdminNotification,
            ReplyCreatedUserNotification,
            DefaultNotification
        },

        data() {
            return {
                notificationType: 'DefaultNotification'
            };
        },

        mounted() {
            this.notificationType = Object.keys(this.$options.components).includes(this.type) ? this.type : 'DefaultNotification';
        },

        computed: {
            endpoint() {
                return `${location.pathname}/notifications`;
            },

            type() {
                return this.notification.type.split('\\').pop();
            }
        },

        methods: {
            markAsRead() {
                axios.delete(`${this.endpoint}/${this.notification.id}`)
                    .then(() => this.$emit('markedAsRead'))
                    .catch(errors => console.log(errors));
            }
        }
    };
</script>
