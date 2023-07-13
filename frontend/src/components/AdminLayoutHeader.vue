<template>
  <q-header elevated class="admin-layout admin-layout__header">
    <q-toolbar>
      <q-btn
        flat
        dense
        round
        icon="menu"
        aria-label="Menu"
        @click="emit('toggleLeftDrawer', true)"
      />
      <q-toolbar-title class="admin-layout admin-layout__header__title">
        {{ adminApplicationName }}
      </q-toolbar-title>
    </q-toolbar>
  </q-header>
</template>

<script setup lang="ts">
// Import framework related utilities
import { defineEmits } from 'vue';

interface AdminHeaderProps {
  adminApplicationName: string;
}
const emit = defineEmits<{
  (event: 'toggleLeftDrawer', value: boolean): void;
}>();
withDefaults(defineProps<AdminHeaderProps>(), {});
</script>
