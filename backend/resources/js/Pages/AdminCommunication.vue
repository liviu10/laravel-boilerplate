<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    data: [
        {
            id: Number,
            title: String,
            description: String,
            path: String,
            button_label: String,
        }
    ]
});
</script>

<template>
    <AppLayout title="Communication">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                Communication
            </h2>
        </template>

        <div>
            <div class="flex flex-wrap max-w-7xl mr-auto ml-auto">
                <div v-for="(resource, index) in data" :key="index" class="w-full md:w-1/2 lg:w-1/2 xl:w-1/2 p-4">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ resource.title }}
                        </h3>
                        <div class="mt-3 max-w-full text-sm text-gray-600 text-justify">
                            {{ resource.description }}
                        </div>
                        <div class="text-center mt-4">
                            <a
                                :href="resource.path"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent
                                    rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                    hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none
                                    focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition
                                    ease-in-out duration-150"
                            >
                                {{ resource.button_label }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
