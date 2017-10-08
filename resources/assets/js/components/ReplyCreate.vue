<template>
    <div>
        <div class="form-group">
            <textarea name="body" class="form-control" rows="3" placeholder="post your comment here..." v-model="data.body">
            </textarea>
        </div>
        <button class="btn btn-primary" @click="create">Post</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: {
                    body: ''
                }
            };
        },

        computed: {
            endpoint() {
                return location.pathname + '/replies';
            }
        },

        methods: {
            create() {
                axios.post(this.endpoint, this.data)
                    .then(response => {
                        // this.$emit('created', response.data);
                        this.$emit('created');
                        this.data.body = '';
                    })
                    .catch(errors => console.error(errors));
            }
        }
    };
</script>
