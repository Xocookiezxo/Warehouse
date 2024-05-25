<template>
    <ILink :href="callback" class="mr-2 ti-arrow-circle-left"></ILink>
</template>
<script setup >
const props = defineProps({
    href: {
        type: [String],
        required: true,
    }
})
const callback = new URLSearchParams(window.location.search).get("callback") ?? props.href
</script>