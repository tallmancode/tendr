<template>
    <div class="hero" style="position: relative">
        <transition-group name="fade" tag="div">
            <div v-for="i in [currentIndex]" :key="i">
                <img :src="currentImg" />
            </div>

        </transition-group>
    </div>
</template>
<script>
export default {
    name: 'HomeHero',
    data() {
        return {
            images: [
                "/media/banners/banner-1.jpg",
                "/media/banners/banner-2.jpg",
                "/media/banners/banner-3.jpg",
            ],
            timer: null,
            currentIndex: 0,
            slideInterval: 10000
        }
    },
    mounted: function() {
        this.startSlide();
    },
    methods: {
        startSlide: function() {
            this.timer = setInterval(this.next, this.slideInterval);
        },
        next: function() {
            this.currentIndex += 1;
        },
    },
    computed: {
            currentImg: function() {
                return this.images[Math.abs(this.currentIndex) % this.images.length];
            }
        }
}
</script>
