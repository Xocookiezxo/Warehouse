<template>
  <div :class="$attrs.class">
    <label class="grid form-label text-capitalize">
      <span v-if="label">{{ label }}:</span>
      <slot></slot>
      <input ref="input" v-bind="{ ...$attrs, class: null }" class="form-input" :class="{ error: error }" :type="type" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
    </label>
    <div v-if="error" class="text-sm text-red-500">{{ error }}</div>
  </div>
</template>

<script>
export default {
  props: {
    type: {
      type: [String, Number],
      default: 'text',
    },
    modelValue: [String, Number],
    label: [String],
    error: [String],
  },
  emits: ['update:modelValue'],
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
    setSelectionRange(start, end) {
      this.$refs.input.setSelectionRange(start, end)
    },
  },
}
</script>
