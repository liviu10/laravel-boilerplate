<template>
  <q-footer elevated class="admin-layout-section admin-layout-section--footer">
    <q-toolbar>
      <div class="admin-layout-section__footer-title">
        <p>
          <span>{{ adminApplicationName }}</span>
          {{ copyrightInfo }}
        </p>
      </div>
    </q-toolbar>
    <q-toolbar>
      <div class="admin-layout-section__footer-designer">
        <p>
          Designed by
          <a :href="designerContactUrl" target="_blank">{{ designerName }}</a>
        </p>
      </div>
    </q-toolbar>
  </q-footer>
</template>

<script setup lang="ts">
interface AdminFooterProps {
  adminApplicationName: string;
  copyrightInfo: string;
  designerContactUrl: string;
  designerName: string;
}

withDefaults(defineProps<AdminFooterProps>(), {});
</script>
