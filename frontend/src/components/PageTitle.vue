<template>
  <div class="admin-section admin-section--header">
    <p class="admin-section__title">
      {{ pageTitle }}
    </p>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities

interface PageTitleInterface {
  pageTitle?: string | undefined;
}

withDefaults(defineProps<PageTitleInterface>(), {});
</script>
