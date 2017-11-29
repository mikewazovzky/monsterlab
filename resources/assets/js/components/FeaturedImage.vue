<template>
    <div>
        <img :src="featured" @click="onClick" width="200" class="mr-1">

        <image-upload v-show="false" name="featured" @loaded="onLoad" ref="imageUpload"></image-upload>
        <br>
        <small>click here to change featured image</small>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload';

    export default {
        props: ['src'],

        components: { ImageUpload },

        data() {
            return {
                featured: this.src
            }
        },

        methods: {
            onClick() {
                this.$refs.imageUpload.$emit('click');
            },

            onLoad(featured) {
                const data = new FormData();

                this.featured = featured.src;

                data.append('featured', featured.file);
            }
        }
    };
</script>

<style scoped>
    img:hover { cursor: pointer; }
</style>
