<template>
  <Layout :title="title">
    <div>
      <h1>
        <BackButton href="/admin/supplies" />{{ title }}
        <ILink class="float-right ml-4 btn btn-warning" :href="`/admin/supplies/${data.id}/edit`">Засах</ILink>
        <DestroyButton :href="'/admin/supplies/' + props.data.id" class="float-right">Устгах</DestroyButton>
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

const title = 'Supplies дэлгэрэнгүй'

const fields = [
  { label: 'id', value: props.data.id },
  { label: 'нийлүүлэлтийн нэр', value: props.data.name },
  { label: 'төрөв', value: props.data.status },
  { label: 'Тайлбар', value: props.data.description },
  { label: 'created_at', value: props.data.created_at },
  { label: 'updated_at', value: props.data.updated_at }
]

</script>