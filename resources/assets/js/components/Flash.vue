<template>
    <div class="alert alert-flash" :class="'alert-' + level"
        role="alert"
        v-show="show"
        v-text="body">
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {
                body: '',
                level: 'success',
                show: false
            };
        },

        created() {
            window.events.$on('flash', data => this.flash(data));

            if (!this.message) {
                return
            }

            if (typeof this.message === 'string') {
                this.body = this.message;
            }

            if (typeof this.message === 'object') {
                this.body = this.message.body;
                this.level = this.message.level ? this.message.level : 'success';
            }

            this.flash();

        },

        methods: {
            flash(data = null) {
                if (data) {
                    this.body = data.message;
                    this.level = data.level ? data.level : 'success';
                }

                this.show = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 2000);
            }
        }
    };
</script>

<style scoped>
    .alert { padding: 10px; position: fixed; right: 25px; bottom: 40px; color: #fff; }
    .alert-success { background-color: #55B4B0; }
    .alert-danger  { background-color: hsl(348, 100%, 61%); }
    .alert-warning { background-color: hsl(48, 100%, 67%); color: rgba(0, 0, 0, 0.7); }
    .alert-info    { background-color: hsl(217, 71%, 53%); }
</style>
