<template>
  <div class="">
    <table class="w-full mt-2 text-gray-500 table-bordered ">
      <thead class="border-b ">
        <tr class="text-left">
          <th class="pl-2 w-11">
            <i class="ti-list" />
          </th>
          <th v-for="(header, i) in headers" :key="i" class="text-gray-600" @click="$emit('orderBy', header.order)">
            {{ header.name }}
          </th>
          <th class="w-20 pl-2 ">
            <ILink :href="`${url}/create`" class="btn btn-success ti-plus"></ILink>
          </th>
        </tr>
      </thead>
      <slot name='filter' />
      <tbody>
        <tr v-for="(row, index) in   datas.data  " :key="row.id" class="border-t hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="pl-2 ">{{ index + 1 }}</td>
          <td v-for="(header, i) in   headers  " :key="i" class="px-2 py-1 ">
            <ILink v-if="url" :href="url + '/' + row.id + '?' + (callback ?? '')" class="items-center focus:text-primary-500">
              {{ parseVal(row, header.key) }}
            </ILink>
            <span v-else class="items-center">{{ parseVal(row, header.key) }}</span>
          </td>
          <td class="py-1 pl-2 text-center">
            <DestroyButton :href="url + '/' + row.id" title="устгах" class="inline-block px-1 py-0"><i class="ti-trash" /></DestroyButton>

            <ILink v-if="url" :href="url + '/' + row.id + '/edit?' + (callback ?? '')" class="inline-block px-2 text-white bg-orange-500 rounded hover:bg-orange-700 " title="Засах">
              <i class="ti-pencil-alt" />
            </ILink>
          </td>
        </tr>
        <tr v-if="datas.data.length === 0">
          <td class="px-6 py-4 " :colspan="headers.length + 2">Мэдээлэл байхгүй </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { router } from '@inertiajs/vue3'
import { computed } from 'vue'
import DestroyButton from './DestroyButton.vue';

export default {
  props: {
    headers: { type: Object, required: true },
    datas: { type: Object, required: true },
    url: String,
    showAdd: { type: [Boolean], default: false },
  },
  emits: ['orderBy', 'showAdd', 'update:showAdd'],
  setup(props, { emit }) {
    const parseVal = (row, key) => {
      let ret = '';
      let keys = key.split('.');
      if (keys.length == 1) {
        ret = row[keys[0]];
      }
      else {
        let r = row;
        for (key of keys) {
          try {
            r = r[key];
          }
          catch (error) {
            console.info(keys, error?.message);
          }
        }
        ret = r;
        // if (row[keys[0]] && row[keys[0]][keys[1]]) ret = row[keys[0]][keys[1]] ?? ''
        // else ret = ''
      }
      return ret;
    };
    const isShow = computed({
      get() {
        return !!props.showAdd;
      },
      set(value) {
        emit('update:showAdd', value);
      },
    });
    const callback = "callback=" + (new URLSearchParams(window.location.search).get("callback") ?? encodeURIComponent(location.pathname + location.search))
    return {
      parseVal,
      isShow,
      callback,
    };
  },
  methods: {
    destroy(rowId) {
      if (confirm('Та устгахдаа итгэлтэй байна уу?')) {
        router.delete(this.url + '/' + rowId + (this.callback ?? ''));
      }
    },

    show() {
      this.show.values = !this.show.values;
      this.add;
    },
  },
  components: { DestroyButton }
}
</script>
