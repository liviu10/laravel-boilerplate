<template>
  <div v-if="topRightSlot" class="admin-section__container-table-top-right">
    <q-btn
      v-if="fullscreenButton"
      flat round dense
      :icon="props.inFullscreen ? 'fullscreen_exit' : 'fullscreen'"
      @click="props.toggleFullscreen"
    />
  </div>
</template>

<script setup lang="ts">
interface AdminPageContainerTableTopRightInterface {
  fullscreenButton?: boolean;
  topRightSlot?: boolean;
  props: {
    inFullscreen: boolean;
    toggleFullscreen: () => void;
  }
}
withDefaults(defineProps<AdminPageContainerTableTopRightInterface>(), {});
</script>
