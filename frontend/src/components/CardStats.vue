<template>
  <div>
    Stats records
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities

// Import library utilities, interfaces and components
import { TDialog } from 'src/interfaces/BaseInterface';

interface ICardStats {
  actionName: TDialog | undefined;
  recordDetails?: [];
}

defineProps<ICardStats>();
</script>

<style lang="scss" scoped></style>
