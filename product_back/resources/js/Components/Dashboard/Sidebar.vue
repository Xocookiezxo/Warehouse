<script setup>

import { toRefs, ref, watch } from 'vue'

import Backdrop from '../Backdrop.vue';
import SidebarItem from './SidebarItem.vue';
import AdminMenu from '../AdminMenuList';
import { onMounted } from 'vue';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
const props =
  defineProps({
    modelValue: { type: Boolean, default: false },
  })

const { modelValue } = toRefs(props)

const emit = defineEmits(['update:modelValue'])

const isOpen = ref(props.modelValue)

watch(
  modelValue,
  (val) => {
    isOpen.value = val
  },
  { immediate: true },
)

watch(isOpen, (val) => {
  emit('update:modelValue', val)
})
const user = computed(() => usePage().props.auth.user)

const menus = ref(AdminMenu)

onMounted(() => {

  menus.value = menus.value.filter((d) => d.roles.includes(user.value.roles))



});

</script>

<template>
  <Backdrop v-if="isOpen" @click="isOpen = false" />

  <aside class="px-2 w-10/12 sm:w-[300px] border-r h-screen fixed top-0 border-gray-200 pb-2 bg-white z-10 flex-col transition-all duration-300 transform sm:transform-none" :class="isOpen ? 'translate-x-0' : '-translate-x-full'">
    <div>
      <div class="list list-hover">
        <div class="px-2 py-1 pb-2">
          <div class="nav-drawer-title">Агуулах удирдах</div>
          <div class="nav-drawer-subtitle"> </div>
        </div>
        <div class="my-1 -mx-2 border-b"></div>
        <SidebarItem v-for="menu in menus" :key="menu.text" :menu="menu" />
      </div>
    </div>
  </aside>
</template>

<style scoped></style>
