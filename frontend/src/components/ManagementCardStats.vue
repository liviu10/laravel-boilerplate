<template>
  <div>
    Stats records
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities

// Import library utilities, interfaces and components
import { TDialog } from 'src/interfaces/BaseInterface';

interface IManagementCardStats {
  actionName: TDialog | undefined;
  recordDetails?: [];
}

defineProps<IManagementCardStats>();
</script>

<style lang="scss" scoped></style>
