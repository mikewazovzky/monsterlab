<template>
    <button :class="classes" :disabled="!signedIn" @click="toggle">
        <span class="glyphicon glyphicon-star"></span>
        <span v-text="count"></span>
    </button>
</template>

<script>
export default {
    props: ['post'],

    data() {
        return {
            count: this.post.favoritesCount,
            active: this.post.isFavorited
        };
    },

    computed: {
        classes() {
            return ['btn', 'btn-xs',  this.active ? 'btn-primary' : 'btn-default'];
        },

        endpoint() {
            return '/posts/' + this.post.slug + '/favorites';
        }
    },

    methods: {
        toggle() {
            this.active ? this.destroy() : this.create();
        },

        create() {
            axios.post(this.endpoint);

            this.active = true;
            this.count++;
        },

        destroy() {
             axios.delete(this.endpoint);

            this.active = false;
            this.count--;
        }
    }
};
</script>

<style scoped>
    button { height: 20px; margin-right: 3px; }
</style>
