<template>
  <form @submit.prevent="emit('save', form)" class="field-form">
    <div class="form-grid">
      <MyInput v-model="form.model.name" :error="form.errors.name" class="" label="Нэр" />
      <MyInput v-model="form.model.phone" :error="form.errors.phone" class="" label="Утас" />
      <MyInput v-model="form.model.username" :error="form.errors.username" class="" label="Нэр" />
      <MyInput v-model="form.model.password" type="password" autocomplete="new-password" :error="form.errors.password" class="" label="Нууц Үг" />
      <div>
        <label class="grid form-label text-capitalize">
          <span>Эрхийн Түвшин:</span>
          <slot></slot>
          <select v-model="form.model.roles">
            <option value="admin">admin</option>
            <option value="manager">manager</option>
            <option value="staff">staff</option>
          </select>
        </label>
        <div v-if="form.errors.roles" class="text-sm text-red-500">{{ form.errors.roles }}</div>
      </div>
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

const props = defineProps({
  data: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['save'])
const form = useForm({ model: { ...props.data } }).transform((data) => data.model);

/*
const v_id = computed({get:() => props.id,set:(value)=> emit('update:id')})
const v_name = computed({get:() => props.name,set:(value)=> emit('update:name')})
const v_phone = computed({get:() => props.phone,set:(value)=> emit('update:phone')})
const v_username = computed({get:() => props.username,set:(value)=> emit('update:username')})
const v_password = computed({get:() => props.password,set:(value)=> emit('update:password')})
const v_roles = computed({get:() => props.roles,set:(value)=> emit('update:roles')})
const v_remember_token = computed({get:() => props.remember_token,set:(value)=> emit('update:remember_token')})
const v_push_token = computed({get:() => props.push_token,set:(value)=> emit('update:push_token')})
const v_created_at = computed({get:() => props.created_at,set:(value)=> emit('update:created_at')})
const v_updated_at = computed({get:() => props.updated_at,set:(value)=> emit('update:updated_at')})
const v_deleted_at = computed({get:() => props.deleted_at,set:(value)=> emit('update:deleted_at')})
*/
</script>