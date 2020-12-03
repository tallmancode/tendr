<template>
    <div class="main">
        <header>
            <div class="header__top">
                <div class="container-fluid">
                    <div class="header__left">
                        <a href="" class="logo">
                            <img src="/media/logos/tendr-logo-inverse.png" alt="">
                        </a>
                    </div>
                    <div class="header__left">
                        <a  @click="logout">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <section class="content">
            <router-view></router-view>
        </section>
        <footer>

        </footer>
    </div>
</template>
<script>

export default {
    name: 'Frontend',
    components: {

    },
    methods: {
        logout(){
           this.$store.dispatch('auth/logOut')
        }
    }
}
</script>
