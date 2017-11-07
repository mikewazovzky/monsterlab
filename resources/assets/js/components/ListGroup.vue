<script>
    export default {
        data() {
            return {
                show: false
            };
        },

        methods: {
            open() {
                this.show = true;
                events.$emit('about', this.show);
            },

            close() {
                this.show = false;
                events.$emit('about', this.show);
            },
        }
    };
</script>
