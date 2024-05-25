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

const title = 'User Models Үүсгэх'


defineProps({
  data: [Object],
})

const submit = (form) => {
  form.post('/admin/user_models', {
    headers: { back: new URLSearchParams(window.location.search).get("callback")},
    preserveScroll: true,
    replace: true,
    onSuccess: () => form.reset(),
    onError: () => ({}),
    onFinish: () => ({}),
  });
};
</script>
