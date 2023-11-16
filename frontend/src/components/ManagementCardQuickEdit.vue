<template>
  <div>
    Quick edit record

    <q-separator class="q-my-md" />
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities

// Import library utilities, interfaces and components

interface IManagementCardQuickEdit {
  dataModel?: [];
}

const props = defineProps<IManagementCardQuickEdit>();
</script>

<style lang="scss" scoped></style>
