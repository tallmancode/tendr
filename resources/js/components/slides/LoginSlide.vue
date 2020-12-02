<template>
    <div class="slide__panel right">
        <div class="slide__header">
            <h3>Login</h3>
            <a href="" class="slide__close" @click="$close"><i class="icn icn-clear"></i></a>
        </div>
        <div class="slide__body">
            <form @submit.prevent="handleSubmit">
                <div class="form-group" v-bind:class="{ 'error': errors.email }">
                    <input class="form-control" type="text" name="email" placeholder="Email" v-model="email">
                    <span v-if="errors.email">{{ errors.email[0]}}</span>
                </div>
                <div class="form-group" v-bind:class="{ 'error': errors.password }">
                    <input class="form-control" type="password" name="password" placeholder="Password" v-model="password">
                    <span v-if="errors.password">{{ errors.password[0]}}</span>
                </div>
                <input type="hidden" name="_token" :value="csrf">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
        <div class="slide_footer">

        </div>
    </div>
</template>
<script>
import Axios from 'axios'
export default {
    name: 'LoginSlide',
    data() {
        return{
            email: '',
            password: '',
            errors: false,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    methods: {
        async handleSubmit() {
            this.$snitch.log({message: 'Login form submitted', info: false, groups: ['auth']})
            this.errors = false;
            //console.log(process.env.APP_DOMAIN)
            await axios.get('/sanctum/csrf-cookie')
            await axios
                    .post('/login', {email: this.email, password: this.password})
                    .then((resp) => {
                        if(resp.status === 204){
                            window.location.href = process.env.MIX_AUTH_REDIRECT
                        }
                    })
                    .catch((e) => {
                        this.handleError(e)
                    })
        },
        handleError(e) {
            this.$snitch.log({message: e.response, groups: ['auth', 'errors']})
            if(e.response.status === 422){
                if(e.response.data.errors){
                    this.errors = e.response.data.errors
                }
            }
        }
    }
}
</script>
