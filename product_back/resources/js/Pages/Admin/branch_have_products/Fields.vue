<template>
  <form @submit.prevent="emit('save', form)" class="field-form">
    <div class="form-grid">
      <MySelect :value="form.model.branch" :error="form.errors.branch_id" class="" label="Branch Id" :url="`/admin/branches`" @changeId="id => form.model.branch_id = id" />
      <MySelect :value="form.model.product" :error="form.errors.product_id" class="" label="Product Id" :url="`/admin/products`" @changeId="id => form.model.product_id = id" />
      <MyInput v-model="form.model.pcount" type="number" :error="form.errors.pcount" class="" label="Тоо" />
      <MyInput v-model="form.model.reg_type" :error="form.errors.reg_type" class="" label="Зарлага Эсэх" />
      <MySelect :value="form.model.user" :error="form.errors.user_id" class="" label="User Id" :url="`/admin/user_models`" @changeId="id => form.model.user_id = id" />
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

const props = defineProps({
  data: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['save'])
const form = useForm({ model: { ...props.data } }).transform((data) => data.model);

/*
const v_id = computed({get:() => props.id,set:(value)=> emit('update:id')})
const v_branch_id = computed({get:() => props.branch_id,set:(value)=> emit('update:branch_id')})
const v_product_id = computed({get:() => props.product_id,set:(value)=> emit('update:product_id')})
const v_pcount = computed({get:() => props.pcount,set:(value)=> emit('update:pcount')})
const v_reg_type = computed({get:() => props.reg_type,set:(value)=> emit('update:reg_type')})
const v_user_id = computed({get:() => props.user_id,set:(value)=> emit('update:user_id')})
const v_created_at = computed({get:() => props.created_at,set:(value)=> emit('update:created_at')})
const v_updated_at = computed({get:() => props.updated_at,set:(value)=> emit('update:updated_at')})
*/
</script>