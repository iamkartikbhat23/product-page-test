<template>
    <div class=" flex  justify-center p-2 md:p-10 bg-pale-orangee font-montserrat">
        <div class="container rounded-md h-auto flex flex-col items-center justify-center">
            <h1 class="text-4xl p-2 font-semibold">Products</h1>
            <div class="w-full grid grid-cols-1 md:grid-cols-4 gap-4 p-5">
                <div class="rounded-md border border-orangee h-full rounded-md shadow-md shadow-orangee" v-for="product in products" :key="product.id">
                    <RouterLink :to="`/shop/product/${product.slug}`">
                        <img lazy-loading :src="product.image" class="w-auto h-auto rounded-md" />
                        <div class="p-2 space-y-3 bg-whitee rounded-md h-[7rem] flex flex-col justify-between">
                            <div class="text-xl font-semibold text-slate-700">{{ product.name }}</div>
                            <div class="text-lg text-slate-700 text-end">{{ product.price }}</div>
                        </div>
                    </RouterLink>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
    import { ref,onMounted,reactive } from "vue";
    import axios from 'axios'

    let products = ref([]) ;

    onMounted(() => {
        getProducts() ;
    });

    const getProducts = async () => {
        let response = reactive({}) ;
        try{
            response = await axios.get('/products')
            products.value = response.data ;
        } catch(error) {
            response = error.response ;
            router.push({ name: 'errorPage', query: { code: response.status } })
        }
    };
</script>
