<template>
  <div class="row admin-section admin-section--container">
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
      <slot name="content"></slot>
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { RouteRecordName } from 'vue-router';

// Defined the translation variable
const { t } = useI18n({});

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
    border: 1px solid green;
    padding: rem-convertor(16px) 0;
  }
}
</style>
