<template>
  <div>
    Show record
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities

// Import library utilities, interfaces and components

interface IManagementCardShow {
  recordDetails?: [];
}

const props = defineProps<IManagementCardShow>();
</script>

<style lang="scss" scoped></style>
