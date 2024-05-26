<template>
  <Layout :title="title">
    <div>
      <h1 class="mb-8 text-xl font-bold">{{ title }}</h1>
      <div class="flex items-center justify-between mb-6">
        <SearchFilter v-model:search="form.model.search" class="w-full mr-4" @reset="form.reset">

        </SearchFilter>

      </div>
      <div class="bg-white rounded shadow">
        <PaginationFilter v-model="form.model.per_page" :total="datas.total" />
        <AdminTable :headers="headers" :datas="datas" url="/admin/user_models" @order-by="(v) => orderBy(form, v)">
          <template #filter>
            <AdminTableFilter v-model:model="form.model" :headers="headers" />
          </template>
        </AdminTable>
        <Pagination :links="datas.links" />
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import SearchFilter from '@/Components/SearchFilter.vue'
import AdminTable from '@/Components/AdminTable.vue'
import AdminTableFilter from '@/Components/AdminTableFilter.vue'
import { useForm } from '@inertiajs/vue3'
import { watch } from 'vue'
import PaginationFilter from '@/Components/PaginationFilter.vue'
import { debounce } from '@/utils/useDebouncedRef'
import orderBy from '@/utils/orderBy'
import MySelect from '@/Components/MySelect.vue'
import MyInput from '@/Components/MyInput.vue'

const props = defineProps({
  datas: Object,
  filters: { type: Object, default: () => ({ search: '' }) },
});

const title = 'User Models жагсаалт'

const headers = [
  { key: 'register', name: 'Регистр', order: 'register' },
  { key: 'ovog', name: 'Овог', order: 'ovog' },
  { key: 'name', name: 'Нэр', order: 'name' },
  { key: 'branch.name', name: 'Салбар', order: 'branch_id', url: '/admin/branches' },
  { key: 'phone', name: 'Утас', order: 'phone' },
  { key: 'username', name: 'Нэвтрэх нэр', order: 'username' },
  { key: 'roles', name: 'Эрхийн түвшин', order: 'roles' },

]

const form = useForm({ model: { ...props.filters, per_page: props.datas.per_page } })
  .transform(data => data.model)

watch(() => form.model, debounce(() => form.get('', { preserveState: true }), 150), { deep: true })

</script>
