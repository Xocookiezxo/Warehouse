<template>
  <Layout :title="title">
    <div>
      <h1>
        <BackButton href="/admin/user_models" />{{ title }}
        <ILink class="float-right ml-4 btn btn-warning" :href="`/admin/user_models/${data.id}/edit`">Засах</ILink>
        <DestroyButton :href="'/admin/user_models/' + props.data.id" class="float-right">Устгах</DestroyButton>
      </h1>
      <div class="show-grid">
        <InputLabel v-for="item in fields" :key="item.label" v-bind="item" class="border-b border-dashed" />
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from '@/Layouts/AdminLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import BackButton from '@/Components/BackButton.vue';
import DestroyButton from '@/Components/DestroyButton.vue';

const props = defineProps({
  data: [Object],
});

const title = 'User Models дэлгэрэнгүй'

const fields = [
  { label: 'id', value: props.data.id },
  { label: 'Нэр', value: props.data.name },
  { label: 'Утас', value: props.data.phone },
  { label: 'Нэр', value: props.data.username },
  { label: 'Нууц үг', value: props.data.password },
  { label: 'Эрхийн түвшин', value: props.data.roles },
  { label: 'remember_token', value: props.data.remember_token },
  { label: 'push_token', value: props.data.push_token },
  { label: 'created_at', value: props.data.created_at },
  { label: 'updated_at', value: props.data.updated_at },
  { label: 'deleted_at', value: props.data.deleted_at }
]

</script>