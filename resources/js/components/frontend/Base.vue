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
                        <a @click="showLogin" class="logo">
                            sign in
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <section class="content full">
            <HomeHero></HomeHero>
            <!-- <div class="hero">
                <img src="/media/banners/banner-1.jpg" alt="">
            </div> -->
            <dialogs-wrapper transition-name="slide" wrapper-name="default"></dialogs-wrapper>
        </section>
        <footer>

        </footer>
    </div>
</template>
<script>
import { create } from 'vue-modal-dialogs'
import LoginSlide from '../slides/LoginSlide'
const LoginSlideAction = create({component:LoginSlide})

import HomeHero from './sliders/HomeHero'

export default {
    name: 'Frontend',
    components: {
        HomeHero
    },
    methods: {
        showLogin() {
            LoginSlideAction();
        }
    }
}
</script>
