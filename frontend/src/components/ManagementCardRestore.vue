<template>
  <div class="admin-section__dialog-body-content">
    <div v-if="checkObject.handleCheckIfObject(recordDetails) && checkObject.handleCheckIfArray(recordDetails?.results)">
      <q-list class="q-my-sm" v-for="(record, index) in recordDetails?.results" :key="index" bordered separator>
        <q-item v-for="(value, key) in record" :key="key">
          <q-item-section>
            <q-item-label caption>
              {{ t(`admin.management.${resource.toLowerCase()}.data_model.${key}`) }}
            </q-item-label>
            <q-item-label>
              {{ value }}
            </q-item-label>
          </q-item-section>
        </q-item>
      </q-list>

      <q-separator class="q-my-md" />

      {{ t("admin.generic.restore_confirmation_message") }}
    </div>

    <div v-else>
      <management-card-no-data :action-name="actionName" />
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { HandleObject } from 'src/utilities/HandleObject';
import { IRootObject, TDialog } from 'src/interfaces/BaseInterface';
import ManagementCardNoData from 'src/components/ManagementCardNoData.vue';

interface IManagementCardRestore {
  actionName: TDialog | undefined;
  recordDetails?: IRootObject & {
    results: object[];
  };
  resource: string;
}

defineProps<IManagementCardRestore>();

// Defined the translation variable
const { t } = useI18n({});

// Check if object is array
const checkObject = new HandleObject();
</script>

<style lang="scss" scoped></style>
