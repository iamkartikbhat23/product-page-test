<template>
    <div class="w-screen">
        <swiper :navigation="true" :modules="modules" class="size-">
            <swiper-slide v-for="image in images">
                <img :src="image" class="w-full h-full"/>
            </swiper-slide>
        </swiper>
    </div>
  </template>
  <script>
    // Import Swiper Vue.js components
    import { Swiper, SwiperSlide } from 'swiper/vue';

    // Import Swiper styles
    import 'swiper/css';

    import 'swiper/css/navigation';


    // import required modules
    import { Navigation } from 'swiper/modules';

    export default {
      components: {
        Swiper,
        SwiperSlide,
      },
      props: ['images'],
      setup() {
        return {
          modules: [Navigation],
        };
      },
    };
  </script>
<style>
    .swiper-button-prev, .swiper-button-next {
        color:black !important;
        padding:1rem;
        background-color: white;
        border-radius: 50%;
        font-family: 'Montserrat, sans-serif';
        font-size: 1px;
        font-weight: bold;
        width: 2.5rem;
        height: 2.5rem;
    }

    .swiper-button-prev:after {
        content: '﹤';
    }
    .swiper-button-next:after {
        content: '﹥';
    }

</style>
