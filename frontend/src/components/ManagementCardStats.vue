<template>
  <div>
    Stats records
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities

// Import library utilities, interfaces and components

interface IManagementCardStats {
  recordDetails?: [];
}

const props = defineProps<IManagementCardStats>();
</script>

<style lang="scss" scoped></style>
