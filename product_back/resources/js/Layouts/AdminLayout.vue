<template>
  <HeadTitle :title="title" />
  <main class="">
    <Sidebar v-model="sidebar" />
    <!-- <NavDrawer /> -->

    <div class="sm:ml-[300px]">
      <Header @menu:click="sidebar = true" />

      <!-- main content -->
      <FlashMessages />
      <div class="px-6 py-6">
        <slot />
      </div>
    </div>
  </main>
</template>
  
<script setup>

import FlashMessages from '@/Components/FlashMessages.vue'
import Sidebar from '@/Components/Dashboard/Sidebar.vue'
import Header from '@/Components/Dashboard/Header.vue'
import { ref } from 'vue'
import { Head as HeadTitle } from '@inertiajs/vue3'
defineProps({ title: { type: String, default: 'Гарчиг' } })
const sidebar = ref(false)


</script>
  