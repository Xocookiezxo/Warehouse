<template>
  <div class="w-full" :class="{ 'form-group': formControl }">
    <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
    <vSelect v-model="selected" :loading="load" :multiple="multiple" v-bind="$attrs" req class="" :class="{ 'form-control': formControl, error: error }" :label="selectLabel" :filterable="filterable" :options="options" :placeholder="placeholder" @open="onOpen" @close="onClose" @search="onSearch">
      <template v-if="required" #search="{ attributes, events }">
        <input class="vs__search" :required="!selected" v-bind="attributes" autocomplete="off" v-on="events" />
      </template>
      <slot></slot>
      <template #no-options>
        <div class="p-2 text-red-500 text-bold">
          <span class="font-bold text-black">Мэдээлэл байхгүй байна</span>
        </div>
      </template>
      <template v-if="$slots.option" #option="op">
        <slot name="option" v-bind="op"></slot>
      </template>
    </vSelect>
    <div v-if="error" class="text-sm text-red-500">
      {{ error }}
    </div>
  </div>
</template>

<script>
import vSelect from 'vue-select'
import debounce from 'lodash/debounce'
import 'vue-select/dist/vue-select.css'
import axios from 'axios'

export default {
  components: {
    vSelect,
  },
  inheritAttrs: true,
  props: {
    id: {
      type: String,
      default() {
        return `select-input-${Math.random() * 1000}`
      },
    },
    storedOptions: { type: Array, default: () => [] },
    value: [Object, String, Number, Array],
    modelValue: [Object, String, Number, Array],
    label: String,
    url: String,
    placeholder: { type: String, default: '' },
    error: String,
    selectLabel: {
      type: String,
      default: 'name',
    },
    selectedKey: {
      type: String,
      default: 'id',
    },
    forceLoad: { type: Boolean, default: false },
    modelKey: { type: Boolean, default: false },
    formControl: { type: Boolean, default: false },
    getAll: { type: Boolean, default: false },
    perPage: { type: Number, default: 50 },
    onOpenAutoCall: { type: Boolean, default: true },
    required: { type: Boolean, default: false },
    filterable: { type: Boolean, default: false },
    multiple: { type: Boolean, default: false },
  },
  emits: ['input', 'changeId', 'onLoaded', 'update:modelValue', 'change'],
  data() {
    const tmpValue = this.modelValue ?? this.value
    return {
      observer: null,
      limit: 10,
      options: this.storedOptions ?? [],
      selected:
        typeof tmpValue == 'object'
          ? tmpValue
          : this.options?.find((v) => tmpValue == v[this.selectedKey]) ??
          this.storedOptions?.find((v) => tmpValue == v[this.selectedKey]) ??
          tmpValue,
      collection: this.storedOptions ?? [],
      load: false,
    }
  },
  watch: {
    modelValue(nv) {
      this.selected =
        typeof nv == 'object'
          ? nv
          : this.options?.find((v) => nv == v[this.selectedKey]) ?? nv
    },
    storedOptions() {
      this.collection = this.options = this.storedOptions
    },
    selected() {
      this.$emit('change', this.selected)
      if (this.modelKey && this.selected) {
        this.$emit('update:modelValue', this.selected[this.selectedKey] ?? null)
      } else {
        this.$emit('update:modelValue', this.selected)
      }
      if (this.selected) {
        this.$emit('changeId', this.selected[this.selectedKey] ?? null)
      } else {
        this.$emit('changeId', null)
      }
    },
  },
  mounted() {
    this.observer = new IntersectionObserver(this.infiniteScroll)
  },
  methods: {
    onLoaded() {
      this.$emit('onLoaded', this.collection)
    },
    onSearch(search, loading) {
      loading(true)
      this.search(loading, search, this)
    },
    async onOpen() {
      if (!this.onOpenAutoCall) return
      if (this.options.length == 0 || this.forceLoad) {
        this.load = true
        this.search((load) => (this.load = load), '', this)
      }
      if (this.hasNextPage) {
        await this.$nextTick()
        this.observer.observe(this.$refs.load)
      }
    },
    onClose() {
      this.observer.disconnect()
    },
    async infiniteScroll([{ isIntersecting, target }]) {
      if (isIntersecting) {
        const ul = target.offsetParent
        const scrollTop = target.offsetParent.scrollTop
        this.limit += 10
        await this.$nextTick()
        ul.scrollTop = scrollTop
      }
    },
    search: debounce((loading, search, vm) => {
      if (vm.filterable && vm.collection.length && !vm.forceLoad) {
        vm.options =
          search == ''
            ? vm.collection
            : vm.collection.filter((option) =>
              option.name.toLowerCase().includes(search.toLowerCase()),
            )
        loading(false)
      } else {
        axios(
          `${vm.url}${vm.url.includes('?') ? '&' : '?'}search=${encodeURIComponent(
            search,
          )}&only&per_page=${vm.perPage}${vm.getAll ? '&all' : ''}`,
        )
          .then((res) => res.data)
          .then((json) => {
            vm.options = json.data
            if (vm.getAll) {
              vm.collection = json.data
              vm.$root.prefecturesCollection = [...vm.collection]
              vm.onLoaded()
            }
            loading(false)
          })
      }
    }, 350),
  },
}
</script>
<style>
.v-select {
  @apply bg-white
}

.vs__selected-options {
  flex-wrap: nowrap !important;
  padding: 0;

}

.vs__search {
  margin: 0;
}

.vs__dropdown-toggle {
  padding: 0
}


.vs__spinner,
.vs__spinner:after {
  width: 2.5em;
  height: 2.5em;
}
</style>
