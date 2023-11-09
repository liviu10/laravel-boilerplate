<template>
  <div class="admin-section admin-section--loading">
    <q-inner-loading :showing="visible">
      <q-spinner-gears size="50px" color="primary" />
    </q-inner-loading>
  </div>
</template>

<script setup lang="ts">
interface IPageLoading {
  visible: boolean;
}

withDefaults(defineProps<IPageLoading>(), {});
</script>

<style lang="scss" scoped></style>
