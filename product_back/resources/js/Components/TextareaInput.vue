<template>
  <div :class="$attrs.class">
    <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
    <textarea v-if="readonly != true" :id="id" ref="input" v-bind="$attrs" class="w-full form-textarea" :class="[inputClass, error && 'error']" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
    <span v-else class="form-input read-only:bg-slate-100 min-h-[6rem]" :class="[inputClass, error && 'error']"> {{ modelValue }}</span>
    <small v-if="error" class="text-sm text-red-500">
      {{ error }}
    </small>
  </div>
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `textarea-${Math.random() * 1000}`
      },
    },
    modelValue: String,
    label: String,
    error: String,
    inputClass: [String],
    readonly: { type: [Boolean], default: false },
  },
  emits: ['update:modelValue'],
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
  },
}
</script>
