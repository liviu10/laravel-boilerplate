<template>
  <div class="admin-section__dialog-body-content">
    <div v-if="checkObject.handleCheckIfArray(dataModel)">
      <div v-for="input in dataModel" :key="input.id">
        <q-file
          :accept="input.accept"
          dense
          :label="t(`admin.management.${resource.toLowerCase()}.data_model.${input.field}`)"
          outlined
          square
          stack-label
          v-model="input.value"
        />
      </div>
    </div>

    <div v-else>
      <management-card-go-to-configure-resource :resource="resource.toLowerCase()" />
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { HandleObject } from 'src/utilities/HandleObject';
import { TDialog } from 'src/interfaces/BaseInterface';
import { IConfigurationInput } from 'src/interfaces/ConfigurationResourceInterface';

interface IManagementCardUpload {
  actionName: TDialog | undefined;
  dataModel?: IConfigurationInput[];
  resource: string
}

defineProps<IManagementCardUpload>();

// Defined the translation variable
const { t } = useI18n({});

// Check if object is array
const checkObject = new HandleObject();
</script>

<style lang="scss" scoped></style>
