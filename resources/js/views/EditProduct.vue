<template>
    <div class="h-auto flex  justify-center p-10">
        <div class="w-[50%] rounded-md shadow-lg bg-gray-300 h-auto flex flex-col items-center justify-center">
            <form @submit.prevent="updateProduct" id="productForm" class="bg-gray-300 shadow-md rounded p-8 flex flex-col gap-5 min-w-full">
                <h1 class="text-2xl p-2 font-semibold sticky top-0 bg-gray-300">Edit Product</h1>
                <div class="flex flex-col gap-1">
                    <label class="text-gray-700 text-sm font-bold" for="username">
                        Name
                    </label>
                    <input @keyup="errors.name = null" v-model="product.name" class="border border-gray-300 shadow rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" id="productName" type="text" placeholder="Product Name">
                    <div class="text-sm text-red-500 font-semibold" v-if="errors?.name">{{ errors?.name[0] }}</div>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-gray-700 text-sm font-bold" for="username">
                        Description
                    </label>
                    <textarea @keyup="errors.description = null" v-model="product.description" class="border border-gray-300 shadow rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" id="productDescription" placeholder="Product Description"></textarea>
                    <div class="text-sm text-red-500 font-semibold" v-if="errors?.description">{{ errors?.description[0] }}</div>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-gray-700 text-sm font-bold" for="username">
                        Price
                    </label>
                    <input @keyup="errors.price = null" v-model="product.price" class="border border-gray-300 shadow rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" id="productPrice" type="number" placeholder="Product Price">
                    <div class="text-sm text-red-500 font-semibold" v-if="errors?.price">{{ errors?.price[0] }}</div>
                </div>
                <div class="flex gap-1">
                    <div class="w-1/2 flex flex-col">
                        <label class="text-gray-700 text-sm font-bold" for="username">
                            Discount
                        </label>
                        <div class="flex gap-3 items-center pt-2">
                            <div class="flex gap-1">
                                <input @change="errors.discountType = null" v-model="product.discountType" :checked="product.discountType=='percent'" value="percent" class="size-6" type="radio" id="percent"  name="discountType">
                                <label for="percent">Percent</label>
                            </div>
                            <div class="flex gap-1">
                                <input @change="errors.discountType = null" v-model="product.discountType" :checked="product.discountType=='amount'" value="amount" class="size-6" type="radio" id="amount"  name="discountType">
                                <label for="amount">Amount</label>
                            </div>
                        </div>
                        <div class="text-sm text-red-500 font-semibold" v-if="errors?.discountType">{{ errors?.discountType[0] }}</div>
                    </div>
                    <div class="w-1/2 flex flex-col gap-1">
                        <label class="text-gray-700 text-sm font-bold" for="username">
                            Discount Value
                        </label>
                        <input @keyup="errors.discountValue = null" v-model="product.discountValue" class="border border-gray-300 shadow rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" id="discountValue" type="number" :placeholder="product.discountType == 'percent' ? 'Enter Discount Percent' : 'Enter Discount Amount'">
                        <div class="text-sm text-red-500 font-semibold" v-if="errors?.discountValue">{{ errors?.discountValue[0] }}</div>
                    </div>
                </div>
                <div class="flex justify-between w-full">
                    <label class="text-gray-700 text-sm font-bold" for="username">
                        Images
                    </label>
                    <button @click="changeImages" class="text-xs px-1 py-0.5 bg-orange-500 rounded text-white" type="button">Change Images</button>
                </div>
                <div class="container grid grid-cols-2 md:grid-cols-4 gap-3 justify-center">
                    <img v-for="image in product.images" :key="image" :src="image" class="size-36 rounded" />
                </div>
                <div class="flex items-center justify-between">
                    <div class="p-2" :class="status ? 'bg-green-500 text-white' : 'text-red-500'" >
                        {{ message }}
                    </div>
                    <button class="bg-green-700 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
    import { reactive,ref,onMounted } from "vue";
    import { randomImages } from "../general.js";
    import { useRoute,useRouter } from 'vue-router'
    import axios from 'axios'

    let status = ref('') ;
    let message = ref(null) ;
    let errors = ref(null) ;

    const route = useRoute()
    const router = useRouter()
    const productId = route.params.id ;

    const product  = reactive({
        name: '',
        description: '',
        price: '',
        discountType: '',
        discountValue: '',
        images: []
    }) ;

    onMounted(() => {
        getProduct(productId) ;
    });

    const getProduct = async (id) => {
        let response = reactive({}) ;
        try {
            response = await axios.get(`/products/${id}`)
            if(response.status==200) {
                product.name = response.data.name
                product.description = response.data.description
                product.price = response.data.price.full
                product.discountType = response.data.discount.type
                product.discountValue = response.data.discount.amount
                product.images = response.data.images
            }
        } catch(error) {
            response = error.response
            status.value = false ;
            message.value = response.statusText ;
            if(response.status == 404) {
                router.push({ name: 'errorPage', query: { code: '404' } })
            } else if(response.status == 500) {
                router.push({ name: 'errorPage', query: { code: '500' } })
            }
        }
    };

    const changeImages = () => {
        product.images = randomImages()
    } ;

    const updateProduct = async () => {
        errors.value = null;
        let response = reactive({}) ;
        try{
            response = await axios.put(`/products/${productId}`, product)
            if(response.status == 200) {
                status.value = true ;
                message.value = response.data.message
                setTimeout(() => {
                    router.push('/listProducts')
                },3000)
            }
        } catch(error) {
            response = error.response
            status.value = false ;
            if(response.status == 422) {
                message.value = "Validation Error" ;
                errors.value = response.data.errors;
            } else if(response.status == 500) {
                router.push({ name: 'errorPage', query: { code: '500' } })
            } else if(response.status == '404') {
                router.push({ name: 'errorPage', query: { code: '404' } })
            } else {
                message.value = response.statusText ;
            }
        }
        setTimeout(() => {
            message.value = null ;
            status.value = false ;
        },2000)
    } ;




</script>
