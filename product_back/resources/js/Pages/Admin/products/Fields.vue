<template>
  <form @submit.prevent="emit('save', form)" class="field-form">
    <div class="form-grid">
      <MyInput v-model="form.model.name" :error="form.errors.name" class="" label="Нэр" />
      <MySelect :value="form.model.provider" :error="form.errors.provider_id" class="" label="Нийлүүлэгч" :url="`/admin/providers`" @changeId="id => form.model.provider_id = id" />
      <MyInput v-model="form.model.barcode" :error="form.errors.barcode" class="" label="Баркод" />
      <MyInput v-model="form.model.price" type="number" :error="form.errors.price" class="" label="Үнэ" />
      <MySelect :value="form.model.product_category" :error="form.errors.product_category_id" class="" label="Бүтгээгдэхүүны Төрөл" :url="`/admin/product_categories`" @changeId="id => form.model.product_category_id = id" />
      <textarea-input v-model="form.model.description" :error="form.errors.description" class="" label="Тайлбар" />
    </div>
    <div class="form-footer">
      <ButtonPrimary :disabled="!form.isDirty || form.processing">
        Хадгалах
      </ButtonPrimary>
    </div>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import ButtonPrimary from "@/Components/ButtonPrimary.vue";
import MyInput from '@/Components/MyInput.vue'
import MySelect from '@/Components/MySelect.vue'
import TextareaInput from '@/Components/TextareaInput.vue'

const props = defineProps({
  data: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['save'])
const form = useForm({ model: { ...props.data } }).transform((data) => data.model);

/*
const v_id = computed({get:() => props.id,set:(value)=> emit('update:id')})
const v_name = computed({get:() => props.name,set:(value)=> emit('update:name')})
const v_provider_id = computed({get:() => props.provider_id,set:(value)=> emit('update:provider_id')})
const v_barcode = computed({get:() => props.barcode,set:(value)=> emit('update:barcode')})
const v_price = computed({get:() => props.price,set:(value)=> emit('update:price')})
const v_product_category_id = computed({get:() => props.product_category_id,set:(value)=> emit('update:product_category_id')})
const v_description = computed({get:() => props.description,set:(value)=> emit('update:description')})
const v_created_at = computed({get:() => props.created_at,set:(value)=> emit('update:created_at')})
const v_updated_at = computed({get:() => props.updated_at,set:(value)=> emit('update:updated_at')})
*/
</script>