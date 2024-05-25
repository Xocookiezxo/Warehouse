<template>
  <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0">
    <div>
      <ILink href="/">
        logo
      </ILink>
    </div>

    <div class="w-full px-6 py-4 mt-6 bg-white shadow-md sm:max-w-md max-w-3x sm:rounded-lg">
      <slot />
    </div>
  </div>
</template>

<script>

export default {
  components: {
  },
}
</script>
