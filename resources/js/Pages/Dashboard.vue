<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';

defineProps({news: Array})

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <!--POI: create component-->
        <div class="py-12">
            <div v-for="item in news">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                        <div class="mb-4 text-gray-900 font-bold">
                            <a :href=item.guid class="hover:bg-gray-50">{{ item.title }}</a>
                        </div>

                        <div class="mb-4 text-gray-900">{{ item.description }}</div>

                        <div class="mb-2 text-sm text-gray-900 italic text-sm">{{ item.postedAt }}, {{
                                item.category
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
