<template>
    <li class="list-group-item">
        <a href="#" @click.prevent="open = !open"><span v-html="symbol"></span> <slot name="href"></slot></a>
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

        computed: {
            symbol() {
                return this.open ? '-' : '+';
            }
        },

        created() {
            events.$on('about', (status) => this.open = status);
        }
    };
</script>

<style scoped>
    p { margin-bottom: 0; }
    a { text-decoration: none; }
</style>
