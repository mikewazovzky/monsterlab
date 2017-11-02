<template>
    <li v-if="count != 0" title="You have new notifications!">
        <a :href="userProfile">
            <span class="glyphicon glyphicon-bell"></span>
            <span class="label label-info" v-text="count"></span>
        </a>
    </li>
</template>

<script>
    export default {
        props: ['value'],

        data() {
            return {
                count: this.value
            };
        },

        computed: {
            userProfile() {
                return `http://${location.hostname}/profiles/${this.signedUser.slug}`;
            }
        },

        created() {
            window.events.$on('notifications:dismiss', () => this.count--);
            window.events.$on('notifications:dismiss-all', () => this.count = 0);
        }
    }
</script>
