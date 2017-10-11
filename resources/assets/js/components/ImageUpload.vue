<template>
    <input type="file" accept="image/*" @change="onChange" ref="input">
</template>

<script>
    export default {
        created() {
            this.$on('click', data => this.$refs.input.click());
        },

        methods: {
            onChange(evt) {
                if (!evt.target.files.length) return;

                const file = evt.target.files[0];

                const reader = new FileReader();

                reader.readAsDataURL(file);

                reader.onload = (e) => {
                    const src = e.target.result;
                    this.$emit('loaded', { src, file });
                };
            }
        }
    };
</script>
