<template>
    <div class="attention">
        <span class="admin">[Admin]</span> New user
        <a :href="profileHref" v-text="notification.data.user.name"></a>
        has been REGISTERED.
    </div>
</template>

<script>
    export default {
        props: ['notification'],

        computed: {
            profileHref() {
                return `/profiles/${this.notification.data.user.slug}`;
            }
        }
    };
</script>

<style scoped>
    .attention { color: red; }
    .admin { font-weight: bold; }
</style>
