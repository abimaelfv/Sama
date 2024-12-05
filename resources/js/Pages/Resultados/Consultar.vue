<script setup>
import WebLayout from '@/Layouts/WebLayout.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    envios: {
        type: Object,
        required: true
    }
})

const verArchivo = (archivo) => {
    const baseUrl = window.location.origin;
    window.open(baseUrl + '/storage/archivos/' + archivo.arc_file, '_blank');
}

const descargarArchivo = (archivo) => {
    // Lógica para descargar el archivo
    console.log('Descargar archivo:', archivo);
    const link = document.createElement('a');
    link.href = archivo.url; // Asumiendo que "url" contiene el enlace de descarga
    link.download = archivo.arc_nombre;
    link.click();
}
</script>

<template>
    <WebLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl">
                    <div class="p-6 bg-white border border-gray-200 flex justify-center sm:hidden">
                        <ApplicationLogo class="h-14 fill-current text-gray-500" />
                    </div>
                    <table class="table-auto border-collapse border border-gray-200 w-full">
                        <tbody>
                            <tr>
                                <td rowspan="3" class="border border-gray-200 text-center">
                                    <div class="p-2 flex justify-center">
                                        <ApplicationLogo class="h-14 fill-current text-gray-500 hidden sm:block" />
                                    </div>
                                </td>
                                <td class="border border-gray-200  text-center py-3 px-3 font-bold" colspan="2">
                                    RESULTADOS DE LA CONSULTA MEDICA
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-3 border border-gray-200">DNI</td>
                                <td class="py-2 px-3 border border-gray-200">74937272</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-3 border border-gray-200">NOMBRES Y APELLIDOS</td>
                                <td class="py-2 px-3 border border-gray-200">ABIMAEL FERNANDEZ VENTURA</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="p-6 bg-gray-100 border border-gray-200">
                        <p class="font-semibold text-md text-primary">Documentos</p>
                    </div>

                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mt-4">
                            <div v-for="(envio, i) in envios" :key="i">
                                <div v-for="(archivo, j) in envio.archivos" :key="j"
                                    class="bg-white py-3 px-4 border border-gray-200 mb-4">
                                    <div class="block sm:flex justify-between items-center">

                                        <div class="flex items-center space-x-3">
                                            <span class="font-semibold text-sm cursor-pointer"
                                                @click="verArchivo(archivo)">
                                                {{ archivo.arc_nombre }}
                                            </span>
                                        </div>

                                        <div class="flex space-x-4 justify-between mt-4 sm:mt-0">
                                            <button @click="verArchivo(archivo)"
                                                class="bg-gray-50 border border-gray-300 px-4 py-2 rounded-sm hover:bg-gray-200 transition duration-300 text-sm">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>

                                            <a :href="route('descargar', archivo.arc_file)"
                                                class="bg-gray-50 border border-gray-300 px-4 py-2 rounded-sm hover:bg-gray-200 transition duration-300 text-sm">
                                                <i class="fa-solid fa-download mr-1"></i>
                                                Descargar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </WebLayout>

</template>
