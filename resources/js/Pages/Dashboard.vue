<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";
</script>

<template>
    <AppLayout :title="$t('Dashboard')">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t("Dashboard") }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
                <div class="mt-6">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div
                        class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8"
                    >
                        <pre class="text-sm text-gray-600 font-normal">
                            {{ $page.props.auth }}
                        </pre>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
