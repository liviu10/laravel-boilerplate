<template>
  <div class="row admin-section admin-section--container">
    <div class="col-xs-10 col-sm-10 col-md-8 col-lg-8 col-xl-8">
      <slot name="admin-filters"></slot>
      <slot name="admin-content"></slot>
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { RouteRecordName } from 'vue-router';

interface AdminPageContainerInterface {
  adminRouteName?: RouteRecordName | null | undefined;
}

withDefaults(defineProps<AdminPageContainerInterface>(), {});
</script>
