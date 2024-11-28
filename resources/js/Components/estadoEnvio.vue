<script setup>
import { computed } from 'vue';

const props = defineProps({
  status: {
    type: Boolean,
    required: true,
  },
});

const statusMap = {
  true: { class: 'text-white bg-green-700/90', label: 'Enviado' },
  false: { class: 'text-white bg-red-700/90', label: 'Pendiente' },
};

const badgeClass = computed(() => statusMap[props.status].class);
const statusLabel = computed(() => statusMap[props.status].label);
</script>

<template>
  <div :class="badgeClass" class="inline px-2 py-1 text-xs font-bold rounded-full text-center gap-x-2">
    {{ statusLabel }}
  </div>
</template>
