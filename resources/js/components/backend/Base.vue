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
        <section class="sidebar">
            <ul class="sidebar__nav">
                <li class="sidebar__nav--item">
                    <router-link :to="{name: 'Dashboard'}">
                        <span class="sidebar__nav--icon">
                            <i class="icn icn-stats-bars"></i>
                        </span>Dashboard
                    </router-link>
                </li>
                 <li class="sidebar__nav--item">
                    <router-link :to="{name: 'Settings'}">
                        <span class="sidebar__nav--icon">
                            <i class="icn icn-cogs"></i>
                        </span>Settings
                    </router-link>
                </li>
            </ul>
        </section>
        <section class="main has-sidebar">
            <div class="content">
                <transition name="fade" mode="out-in">
                    <router-view/>
                </transition>
                </div>
            <div class="footer">s</div>
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
