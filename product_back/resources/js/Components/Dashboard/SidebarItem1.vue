<script setup>
import { ref } from 'vue'
import SidebarItem from './SidebarItem1.vue';

defineProps({
  menu: Object,
})

const isOpen = ref(false)

</script>

<template>
  <component :is="menu.href=='#'?'a':'ILink'" :href="menu.href" class="gap-4 list-group-item" @click="isOpen = !isOpen">
    <component :is="typeof menu.icon =='function' ?menu.icon:'i' " :class="typeof menu.icon == 'string' ? menu.icon : ''" class="text-xl list-group-item-icon " />
    <div class="flex-1 list-group-item-subtitle">{{ menu.text }}</div>
    <i v-if="!!menu['children']" class="text-xl list-group-item-icon " :class="isOpen ? 'ti-angle-down' : 'ti-angle-right'" />
  </component>
  <div :class="isOpen ? 'block' : 'hidden'" class="ml-8">
    <SidebarItem v-for="menu in menu['children']" :key="menu.text" :menu="menu"></SidebarItem>
  </div>
</template>

<style scoped></style>
