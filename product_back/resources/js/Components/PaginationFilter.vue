<template>
  <div class="flex flex-wrap justify-end  mb-2">
    <select :value="modelValue" @change="(event)=>$emit('update:modelValue',event.target.value)">
      <option value="10">10/{{ total }}</option>
      <option value="30">30/{{ total }}</option>
      <option value="50">50/{{ total }}</option>
      <option value="100">100/{{ total }}</option>
      <option value="500">500/{{ total }}</option>
      <option value="1000">1000/{{ total }}</option>
    </select>
  </div>
</template>

<script>

export default {
  props: {
    modelValue: [Number, String],
    total: Number,
  },
  emits: ['update:modelValue'],
}
</script>
