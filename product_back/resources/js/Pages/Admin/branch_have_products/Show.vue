<template>
  <Layout :title="title">
    <div>
      <h1>
        <BackButton href="/admin/branch_have_products" />{{ title }}
        <ILink class="float-right ml-4 btn btn-warning" :href="`/admin/branch_have_products/${data.id}/edit`">Засах</ILink>
        <DestroyButton :href="'/admin/branch_have_products/' + props.data.id" class="float-right">Устгах</DestroyButton>
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

const title = 'Branch Have Products дэлгэрэнгүй'

const fields = [
  { label: 'id', value: props.data.id },
  { label: 'branch_id', value: props.data?.branch?.name ?? '' },
  { label: 'product_id', value: props.data?.product?.name ?? '' },
  { label: 'тоо', value: props.data.pcount },
  { label: 'Зарлага эсэх', value: props.data.reg_type },
  { label: 'user_id', value: props.data?.user?.name ?? '' },
  { label: 'Тайлбар', value: props.data.description },
  { label: 'created_at', value: props.data.created_at },
  { label: 'updated_at', value: props.data.updated_at }
]

</script>