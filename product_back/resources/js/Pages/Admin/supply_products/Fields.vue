<template>
  <form @submit.prevent="emit('save', form)" class="field-form">
    <div class="form-grid">
      <MySelect :value="form.model.supply" :error="form.errors.supply_id" class="" label="Нийлүүлэлт" :url="`/admin/supplies`" @changeId="id => form.model.supply_id = id" />
      <MySelect :value="form.model.product" :error="form.errors.product_id" class="" label="Бүтээгдэхүүн" :url="`/admin/products`" @changeId="id => form.model.product_id = id" />
      <MyInput v-model="form.model.expected_count" type="number" :error="form.errors.expected_count" class="" label="Тоо" />
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
const v_supply_id = computed({get:() => props.supply_id,set:(value)=> emit('update:supply_id')})
const v_product_id = computed({get:() => props.product_id,set:(value)=> emit('update:product_id')})
const v_expected_count = computed({get:() => props.expected_count,set:(value)=> emit('update:expected_count')})
const v_pcount = computed({get:() => props.pcount,set:(value)=> emit('update:pcount')})
const v_description = computed({get:() => props.description,set:(value)=> emit('update:description')})
const v_created_at = computed({get:() => props.created_at,set:(value)=> emit('update:created_at')})
const v_updated_at = computed({get:() => props.updated_at,set:(value)=> emit('update:updated_at')})
*/
</script>