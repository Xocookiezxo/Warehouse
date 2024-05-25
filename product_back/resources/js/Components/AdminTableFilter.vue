<template>
  <thead>
    <tr>
      <td></td>
      <template v-for="(h, i) in headers">
        <td v-if="!h.url" :key="h.name">
          <div class="search">
            <input v-model="model[h.key]" :type="h.type ?? 'search'" clearable class="w-full p-0 text-sm" />
          </div>
        </td>
        <td v-else :key="i">
          <MySelect :value="model[h.key]" class="min-w-[100px] p-0 text-sm" :url="h.url" @changeId="(id) => (model[h.order] = id)" />
        </td>
      </template>
    </tr>
  </thead>
</template>

<script setup>
import { computed } from "vue";
import MyInput from "./MyInput.vue";
import MySelect from "./MySelect.vue";

const props = defineProps({
  headers: { type: Object, required: true },
  model: { type: Object, required: true },
});
const emit = defineEmits(["update:model"]);
const model = computed({
  get: () => props.model,
  set: (v) => emit("update:model", v),
});
</script>
<style scoped>
.search {
  position: relative;

}

.search>input {
  padding-left: 14px;
}



.search::before {
  position: absolute;
  content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-6 h-6'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z' /%3E%3C/svg%3E%0A");
  width: 10px;
  height: 10px;
  top: 1px;
  left: 3px;
}
</style>
