<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
</script>

<template>
    <AppLayout title="Management">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="max-w-sm w-full lg:max-w-full m-4">
                            <div class="bg-white rounded-b lg:rounded-b-none lg:rounded-r py-4 flex flex-col justify-between leading-normal">
                                <div>
                                    <div class="text-gray-900 font-bold text-xl mb-2">
                                        Can coffee make you a better developer?
                                    </div>
                                    <p class="text-gray-700 text-base">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
                                    </p>
                                </div>
                            </div>

                            <div>
                                <PrimaryButton>
                                    Go to
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
