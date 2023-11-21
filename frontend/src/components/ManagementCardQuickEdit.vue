<template>
  <div>
    Quick edit record

    <q-separator class="q-my-md" />

    <pre>{{ dataModel }}</pre>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities

// Import library utilities, interfaces and components
import { IConfigurationInput } from 'src/interfaces/ConfigurationResourceInterface';

interface IManagementCardQuickEdit {
  dataModel?: IConfigurationInput[];
}

const props = defineProps<IManagementCardQuickEdit>();
</script>

<style lang="scss" scoped></style>
