<template>
    <div class="h-screen w-screen flex items-center justify-center font-montserrat">

        <div class="container py-5 rounded-md  flex flex-col items-center justify-evenly">
            <div class="flex flex-col md:flex-row max-w-4xl gap-16">
                <div class="hidden md:flex flex-col gap-5 items-start">
                    <img :src="product.mainImage" class="rounded-xl size-96"/>
                    <div class="flex justify-between w-96">
                        <div v-for="(image,index) in product.images" :key="index" class="rounded-lg border-[3px]" :class="product.mainImage==image ? 'border-orangee': 'border-white'">
                            <img :src="image" @click="product.mainImage = image" class="cursor-pointer rounded-md inset-0 size-20 rounded-md" />
                        </div>
                    </div>
                </div>
                <div class="md:hidden">
                    <ImageSwiper  :images="product.images"/>
                </div>
                <div class="p-5 space-y-10 w-full md:w-[30rem]">
                    <h1 class="text-3xl text-very-dark-blue font-bold">{{ product.name }}</h1>
                    <p class="text-base text-dark-gray-blue h-20">{{ product.description }}</p>
                    <div class="flex justify-between md:block space-y-1">
                        <div class="flex gap-4">
                            <div class="text-very-dark-blue text-2xl font-bold">${{ product.price.discounted }}</div>
                            <div class="bg-pale-orangee text-orangee text-sm py-0.5 px-1 rounded-md inline my-1 font-semibold">{{ product.discount.type=='percent' ? `${product.discount.amount}%` : `$${product.discount.amount}` }}</div>
                        </div>
                        <div class="text-md text-gray-blue line-through">
                            ${{ product.price.full }}
                        </div>
                    </div>
                    <div class="w-full md:flex gap-4 space-y-4 md:space-y-0 h-12 items-center py-3">
                        <div class="w-full md:basis-2/5 py-3 bg-light-gray-blue rounded-lg  flex gap-3 items-center justify-between select-none">
                            <div class="px-5 text-orangee font-bold text-md cursor-pointer" @click="counter!=0 ? counter-- : 0">-</div>
                            <div class="px-5 font-bold text-center text-md">{{ counter }}</div>
                            <div class="px-5 text-orangee font-bold text-md cursor-pointer" @click="counter++">+</div>
                        </div>
                        <button class="w-full md:basis-3/5 flex justify-center bg-orangee py-3 text-white gap-3 rounded-lg shadow-lg shadow-orange-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            <div class="text-md font-semibold">Add to cart</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { reactive,ref,onMounted } from "vue";
    import { useRoute,useRouter } from 'vue-router'
    import ImageSwiper from "./ImageSwiper.vue";
    import axios from 'axios'

    let counter = ref(0) ;

    const route = useRoute()
    const router = useRouter()
    const productSlug = route.params.slug ;

    const product  = reactive({
        name: '',
        description: '',
        price: '',
        discount: '',
        images: [],
        mainImage: null,
    }) ;

    onMounted(() => {
        getProduct() ;
    });

    const getProduct = async () => {
        let response = reactive({}) ;
        try {
            response = await axios.get(`/products/${productSlug}`)
            if(response.status==200) {
                product.name = response.data.name
                product.description = response.data.description
                product.price = response.data.price
                product.discount = response.data.discount
                product.images = response.data.images
                product.mainImage = response.data?.images[0]
            }
        } catch(error) {
            response = error.response
            if(response.status == 404) {
                router.push({ name: 'errorPage', query: { code: '404' } })
            } else if(response.status == 500) {
                router.push({ name: 'errorPage', query: { code: '500' } })
            }
        }
    };

</script>
