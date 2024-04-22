<template>
    <div class="h-full flex justify-center items-center p-5">
        <div class="p-4 container md:max-w-2xl rounded-md shadow-lg bg-red-200/60 h-72 flex flex-col items-center justify-center py-4 gap-10">
            <div class="text-5xl text-red-600 font-semibold">{{ code }}</div>
            <div class="text-2xl font-semibold">{{ errorMessage }}</div>
            <RouterLink to="/listProducts">
                <button class="rounded px-2 py-1 text-sm bg-blue-600 text-white">Home</button>
            </RouterLink>
        </div>
    </div>
</template>
<script setup>
    import { computed } from "vue";
    const props = defineProps({
            code: {
                type: String,
                default: 404
            }
    });
    const errorMessage = computed(() => {
        let code = props.code ;
        const errors = {
            '404' : () => "Not Found",
            '500' : () => "Server Error",
            '401' : () => "Unauthorized Access",
        }
        return errors[code]();
    }) ;
</script>
