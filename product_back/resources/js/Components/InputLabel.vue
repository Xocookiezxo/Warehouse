<script setup>
defineProps({
    value: {
        type: [String, Number, Object, Array],
    },
    label: {
        type: String,
    },
});
</script>

<template>
    <label class="text-sm font-medium text-gray-700 ">
        <span v-if="label" class="mr-2">{{ label }}: </span>
        <span v-else>
            <slot />
        </span>
        <span class="opacity-80">{{ value }}</span>
    </label>
</template>
