<template>
    <div class="flex justify-center p-5">
        <div class="p-4 container md:max-w-2xl rounded-md shadow-lg bg-blue-200/60 flex flex-col items-center justify-center py-4">
            <div class="w-full flex justify-between items-center px-5">
                <h1 class="text-2xl p-2 font-semibold py-5">All Products ({{ products.length }})</h1>
                <RouterLink to="/addProduct">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-green-600">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                    </svg>
                </RouterLink>
            </div>
            <div class="w-full h-full px-5 space-y-3" v-if="error == null">
                <div v-for="product in products" :key="product.slug" class="p-2 rounded-md border border-gray-500 h-auto">
                    <div class="flex justify-between">
                        <div class="text-semibold">{{ product.name }}</div>
                        <div class="flex gap-5">
                            <RouterLink :to="`/editProduct/${product.id}`">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-blue-600">
                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                    <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                </svg>
                            </RouterLink>
                            <svg @click="deleteProduct(product.id)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-600 cursor-pointer">
                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div  v-if="error != null" class="p-10 flex justify-center">
                {{ error }}
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref,onMounted, reactive } from "vue";
    import { useRouter } from 'vue-router'
    import axios from 'axios'

    let products = ref([]) ;
    let error = ref(null) ;
    const router = useRouter()

    onMounted(() => {
        getProducts() ;
    });

    const getProducts = async () => {
        error.value = null
        let response = reactive({}) ;
        try{
            response = await axios.get('/products')
            products.value = response.data ;
        } catch(error) {
            response = error.response ;
            error.value = "Something went wrong"
        }
    };

    const deleteProduct = async (id) => {
        error.value = null
        let response = reactive({}) ;
        try {
            response = await axios.delete(`/products/${id}`)
            if(response.status == 200) {
                alert("Product Deleted")
                router.go(0)
            }
        } catch(error) {
            response = error.response
            router.push({ name: 'errorPage', query: { code: response.status } })
        }
    } ;
</script>
