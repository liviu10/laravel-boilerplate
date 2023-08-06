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
          {{ t('admin.generic.designed_by') }}
          <a :href="designerContactUrl" target="_blank">{{ designerName }}</a>
        </p>
      </div>
    </q-toolbar>
  </q-footer>
</template>

<script setup lang="ts">
// Import framework related utilities
import { useI18n } from 'vue-i18n';

// Defined the translation variable
const { t } = useI18n({});

interface AdminFooterProps {
  adminApplicationName: string;
  copyrightInfo: string;
  designerContactUrl: string;
  designerName: string;
}

withDefaults(defineProps<AdminFooterProps>(), {});
</script>
