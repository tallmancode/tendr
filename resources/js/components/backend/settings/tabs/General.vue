<template>
    <form @submit.prevent="handleSubmit()">
        <div class="form-group">
            <input type="text" name="" id=""  class="form-control" v-model="name">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">
                Save
            </button>
        </div>
    </form>
</template>

<script>
    export default {
        name: 'General',
        data() {
            return {
                name: ''
            };
        },
        methods:{
            handleSubmit(){
                axios
                    .post('/api/settings/general', {site_name: this.name})
                    .then((resp) => {
                        console.log(resp)
                    })
            }
        }
    }
</script>


