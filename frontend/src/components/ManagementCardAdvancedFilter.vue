<template>
  <div>
    Advanced filters

    <pre>{{ dataModel }}</pre>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities

// Import library utilities, interfaces and components
import { IConfigurationInput } from 'src/interfaces/ConfigurationResourceInterface';

interface IManagementCardAdvancedFilter {
  dataModel?: IConfigurationInput[];
}

const props = defineProps<IManagementCardAdvancedFilter>();
</script>

<style lang="scss" scoped></style>
