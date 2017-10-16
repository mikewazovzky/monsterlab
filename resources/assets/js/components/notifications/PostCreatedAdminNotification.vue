<template>
    <div>
        <span class="admin">[Admin]</span> New post
        <a :href="postHref" v-text="notification.data.post.slug"></a>
        has been published by
        <a :href="profileHref" v-text="notification.data.user.name"></a>
    </div>
</template>

<script>
    export default {
        props: ['notification'],

        computed: {
            postHref() {
                return `/posts/${this.notification.data.post.slug}`;
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
