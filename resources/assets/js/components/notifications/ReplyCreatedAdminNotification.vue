<template>
    <div>
        <span class="admin">[Admin]</span> New reply has been posted to
        <a :href="postHref" v-text="notification.data.post_slug"></a>
        by
        <a :href="profileHref" v-text="notification.data.user.name"></a>
    </div>
</template>

<script>
    export default {
        props: ['notification'],

        computed: {
            postHref() {
                return `/posts/${this.notification.data.post_slug}`;
            },

            profileHref() {
                return `/profiles/${this.notification.data.user.slug}`;
            }
        }
    };
</script>

<style scoped>
    .admin { color: red; font-weight: bold; }
</style>
