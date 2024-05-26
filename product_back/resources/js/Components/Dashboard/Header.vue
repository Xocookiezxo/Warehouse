<script setup>
import Dropdown from '../Dropdown.vue'
import DropdownLink from '../DropdownLink.vue'
import Icon from '../Icon.vue'

import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const user = computed(() => usePage().props.auth.user)

</script>

<template>
  <header class="bg-white border-b border-gray-200">
    <div class="flex items-center justify-between gap-2 pl-3 pr-6">
      <button class="flex-shrink-0 inline px-4 py-2 rounded sm:hidden" @click="$emit('menu:click')">
        <i class="w-5 h-5 ti-menu" />
      </button>
      <ILink href="/" class="font-bold text-gray-400 text-ms sm:justify-center">
        <div class="flex items-center justify-center gap-2">

        </div>
      </ILink>

      <Dropdown align="right">
        <template #trigger>
          <span class="inline-flex rounded-md">
            <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
              {{ user?.name }}
              <Icon class="p-4 ti-angle-down" />
            </button>
          </span>
        </template>

        <template #content>
          <!-- <DropdownLink :href="('/change_password')" method="get" as="button">Нууц үг солих</DropdownLink> -->

          <DropdownLink :href="('/logout')" method="post" as="button">Log Out</DropdownLink>
        </template>
      </Dropdown>
    </div>
  </header>
</template>

<style scoped></style>
