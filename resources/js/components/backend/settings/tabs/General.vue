<template>
    <form @submit.prevent="handleSubmit()">
        <div class="form-group">
            <input type="text" name="" id=""  class="form-control" v-model="generalSettings.site_name">
        </div>
        <div class="form-group">
            <input type="text" name="" id=""  class="form-control" v-model="generalSettings.test">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">
                Save
            </button>
        </div>

    </form>
</template>

<script>
    import{mapActions, mapGetters, mapState} from 'vuex'

    export default {
        data() {
            return {
                generalSettings: []
            };
        },
        async mounted(){
            await this.getSettingsByGroup('general').then((res) => this.generalSettings = res);
        },
        methods:{
            ...mapActions('settings', ['getSettingsByGroup']),
            handleSubmit(){
                axios
                    .post('/api/settings/general', this.generalSettings)
                    .then((resp) => {
                        console.log(resp)
                    })
            },

        },
    }
</script>


