<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import DialogModal from "@/Components/DialogModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import estadoEnvio from "@/Components/estadoEnvio.vue";

const props = defineProps({
    users: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    id: "",
    archivos: [],
});

const modal = ref(false);
const user = ref(null);
const fileInput = ref(null);

const abrirModal = (data) => {
    user.value = data;
    form.id = data.id;
    form.archivos = [];
    modal.value = true;
};

const subir = (event) => {
    form.archivos = Array.from(event.target.files);
};

const loading = ref(false);

const enviar = () => {
    if (loading.value) return;
    loading.value = true;

    const formData = new FormData();
    formData.append("id", form.id);

    form.archivos.forEach((archivo, index) => {
        formData.append(`archivos[${index}]`, archivo);
    });

    form.post(route("resultados.enviar"), {
        preserveScroll: true,
        data: formData,
        onSuccess: () => {
            modal.value = false;
            form.reset();
        },
        onError: (errors) => {
            console.error("Error al enviar:", errors);
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};
</script>

<template>
    <AppLayout title="Resultados">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Resultados
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">N°</th>
                                    <th scope="col" class="px-6 py-3">
                                        Nombres y Apellidos
                                    </th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">
                                        Teléfono
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Envío
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Acción
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, i) in users" :key="user.id"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ i + 1 }}
                                    </td>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ user.name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ user.email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ user.phone }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <estadoEnvio :status="user.se_envio ?? 0" />
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="bg-prim text-white py-1 px-2 rounded text-sm"
                                            @click="abrirModal(user)">
                                            <i class="fa-solid fa-paper-plane"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <DialogModal :show="modal" @close="modal = false">
            <template #title>Enviar correo</template>
            <template #content>
                <div>
                    <InputLabel for="email" value="Usuario" />
                    <TextInput :value="user?.name" type="text" class="mt-1 block w-full bg-gray-100" disabled />
                </div>

                <div class="mt-4">
                    <InputLabel for="archivo" value="Cargar archivos" />
                    <input type="file" multiple ref="fileInput" @change="subir"
                        class="mt-4 block w-full border border-gray-200 focus:shadow-sm rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 file:border-0 file:bg-gray-100 ltr:file:mr-4 rtl:file:ml-4 file:py-3 file:px-4" />
                    <div v-if="form.archivos.length > 0" class="mt-2">
                        <p class="mb-2">Archivos seleccionados:</p>
                        <ul>
                            <li v-for="(archivo, j) in form.archivos" :key="j" class="border p-2 mb-1">
                                {{ archivo.name }}
                            </li>
                        </ul>
                    </div>
                    <InputError class="mt-2" :message="form.errors.archivos" />
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="modal = false">
                    Cancelar
                </SecondaryButton>

                <PrimaryButton class="ms-3" @click="enviar" :disabled="form.archivos.length === 0 || loading">
                    <template v-if="loading">
                        <i class="fa fa-spinner fa-spin mr-2"></i> Enviando...
                    </template>
                    <template v-else>
                        Enviar
                    </template>
                </PrimaryButton>

            </template>
        </DialogModal>
    </AppLayout>
</template>
