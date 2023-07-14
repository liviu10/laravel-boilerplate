<template>
  <div class="row admin-section admin-section--container">
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-8 col-xl-8">
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

<style lang="scss" scoped>
@import 'src/css/utilities/rem_convertor';
@import 'src/css/utilities/_flexbox.scss';

.admin-section {
  @include flex-center();
  margin: rem-convertor(16px) 0;
  &--container {
    padding: rem-convertor(16px) 0;
  }
}
</style>
