<template>
  <form @submit.prevent="emit('save', form)" class="field-form">
    <div class="form-grid">
      <MyInput v-model="form.model.name"  :error="form.errors.name" class="" label="Нэр" />
          <MyInput v-model="form.model.address"  :error="form.errors.address" class="" label="Хаяг" />
          <textarea-input v-model="form.description"  :error="form.errors.description" class="" label="Тайлбар" />
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
import TextareaInput from '@/Components/TextareaInput.vue'

const props = defineProps({
  data: { type: Object, default: () => ({})},
});

const emit = defineEmits(['save'])
const form = useForm({ model: { ...props.data } }).transform((data) => data.model);

/*
const v_id = computed({get:() => props.id,set:(value)=> emit('update:id')})
const v_name = computed({get:() => props.name,set:(value)=> emit('update:name')})
const v_address = computed({get:() => props.address,set:(value)=> emit('update:address')})
const v_description = computed({get:() => props.description,set:(value)=> emit('update:description')})
const v_created_at = computed({get:() => props.created_at,set:(value)=> emit('update:created_at')})
const v_updated_at = computed({get:() => props.updated_at,set:(value)=> emit('update:updated_at')})
*/
</script>