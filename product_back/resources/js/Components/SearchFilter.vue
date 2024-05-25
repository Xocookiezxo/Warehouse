<template>
  <div class="flex items-center">
    <div class="flex w-full bg-gray-100 divide-x rounded shadow">
      <Dropdown align="left" overlay class="hover:bg-gray-100 w-28">
        <template #trigger>
          <div class="flex items-baseline justify-center ">
            <span class="hidden text-gray-700 md:inline">Filter</span>
            <svg class="w-2 h-2 fill-gray-700 md:ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 961.243 599.998">
              <path d="M239.998 239.999L0 0h961.243L721.246 240c-131.999 132-240.28 240-240.624 239.999-.345-.001-108.625-108.001-240.624-240z" />
            </svg>
          </div>
        </template>
        <template #content>
          <div class="px-4 py-6 mt-2 bg-white rounded " :style="{ maxWidth: `${maxWidth}px` }">
            <slot></slot>
          </div>
        </template>
      </Dropdown>

      <input v-model="searchRef" class="relative w-full px-6 py-3 rounded-r focus:outline-none focus:ring" autocomplete="off" type="text" name="search" placeholder="Search…" />
    </div>
    <button class="ml-3 text-sm text-gray-500 hover:text-gray-700 focus:text-indigo-500" type="button" @click="reset">
      Цэвэрлэх
    </button>
  </div>
</template>

<script>

import useDebouncedRef from '@/utils/useDebouncedRef'
import { watch } from 'vue'
import Dropdown from './Dropdown.vue'

export default {
  components: {
    Dropdown,
  },
  props: {
    search: String,
    maxWidth: {
      type: Number,
      default: 300,
    },
  },
  emits: ['reset', 'update:search'],
  setup(props, { emit }) {
    //search text
    const searchRef = useDebouncedRef(props.search, 400)
    watch(searchRef, val => emit('update:search', val))
    //reset
    const reset = () => {
      searchRef.value = ''
      emit('reset')
    }

    return { searchRef, reset }
  },
}
</script>
