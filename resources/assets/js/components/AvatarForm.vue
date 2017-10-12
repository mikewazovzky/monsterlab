<template>
    <div>
        <img :src="avatar" @click="onClick" width="100" height="100" class="mr-1">

        <form v-if="canUpdate" method="POST" enctype="multipart/form-data">
            <image-upload v-show="false" name="avatar" @loaded="onLoad" ref="imageUpload"></image-upload>
            <small>click image to change</small>
        </form>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload';

    export default {
        props: ['user', 'size', 'changable'],

        components: { ImageUpload },

        data() {
            return {
                avatar: this.user.avatar_path
            }
        },

        computed: {
            canUpdate() {
                return this.authorize(signedInUser => signedInUser.id === this.user.id);
            }
        },

        methods: {
            onClick() {
                this.$refs.imageUpload.$emit('click');
            },

            onLoad(avatar) {
                const data = new FormData();

                data.append('avatar', avatar.file);

                axios.post(`/users/${this.user.name}/avatar`, data)
                    .then(() => {
                        flash('Avatar uploaded!');

                        this.avatar = avatar.src;
                    })
                    .catch(() => flash('Failed to load an avatar', 'danger'));
            }
        }
    };
</script>

<style scoped>
    small { font-size: 0.7em; }
</style>
