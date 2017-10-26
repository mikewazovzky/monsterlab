<template>
    <li class="list-group-item">
        <a href="#" @click.prevent="open = !open"><slot name="href"></slot></a>
        <p v-show="open"><slot></slot></p>
    </li>
</template>

<script>
    export default {
        props: ['show'],

        data() {
            return {
                open: this.show
            };
        },

        watch: {
            show() {
                this.open = this.show;
            }
        }
    };
</script>

<style scoped>
    p { margin-bottom: 0; }
</style>
