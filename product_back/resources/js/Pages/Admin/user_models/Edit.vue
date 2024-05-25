<template>
  <Layout :title="title">
    <div>
      <h1><BackButton href="/admin/user_models" />{{ title }}</h1>
      <Fields :data="data" @save="submit"></Fields>
    </div>
  </Layout>
</template>

<script setup>
import Layout from "@/Layouts/AdminLayout.vue";
import BackButton from '@/Components/BackButton.vue';
import Fields from "./Fields.vue";

const title = 'User Models Засах'

const props = defineProps({
  data: [Object],
})

/**
 * Inertia Form
 * @constructor
 * @param {import("@inertiajs/vue3").InertiaForm} form - inertia form.
 */
const submit = (form) => {
  form.put('/admin/user_models/'+props.data.id, {
    headers: { back: new URLSearchParams(window.location.search).get("callback")},
    preserveScroll: true,
    replace: true,
    onSuccess: () => form.reset(),
    onError: () => ({}),
    onFinish: () => ({}),
  });
};
</script>

