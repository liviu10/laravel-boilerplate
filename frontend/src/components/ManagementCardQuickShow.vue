<template>
  <div class="admin-section__dialog-body-content">
    <q-list v-for="(record, index) in recordDetails?.results" :key="index" bordered separator>
      <q-item v-for="(value, key) in record" :key="key">
        <q-item-section>
          <q-item-label caption>
            {{ t(`admin.management.${resource.toLowerCase()}.data_model.${key}`) }}
          </q-item-label>
          <q-item-label>
            <template v-if="key === 'visibility'">
              <q-badge color="primary" :label="value" />
            </template>
            <template v-else-if="key === 'content_url'">
              <a :href="value">{{ value }}</a>
            </template>
            <template v-else-if="key === 'content_type'">
              <q-badge color="primary" :label="value" />
            </template>
            <template v-else-if="key === 'description'">
              {{ (value as string).length > 100 ? (value as string).slice(0, 100) + '...' : value }}
            </template>
            <template v-else>
              {{ value }}
            </template>
          </q-item-label>
        </q-item-section>
      </q-item>
    </q-list>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { IRootObject, TDialog } from 'src/interfaces/BaseInterface';

interface IManagementCardShow {
  actionName: TDialog | undefined;
  recordDetails?: IRootObject & {
    results: object[];
  };
  resource: string;
}

defineProps<IManagementCardShow>();

// Defined the translation variable
const { t } = useI18n({});
</script>

<style lang="scss" scoped></style>
