<template>
  <div class="admin-section__dialog-body-content">
    <div v-if="checkObject.handleCheckIfArray(dataModel)">
      <div v-for="input in dataModel" :key="input.id">
        <q-select
          v-if="checkObject.handleCheckIfArray(input.configuration_options)"
          dense
          emit-value
          :label="t(`t(${translationString}.data_model.${input.field}`)"
          map-options
          outlined
          square
          stack-label
          v-model="input.value"
          :options="input.configuration_options"
        />
        <q-input
          v-else
          dense
          :label="t(`${translationString}.data_model.${input.field}`)"
          outlined
          square
          stack-label
          :type="input.type"
          v-model="input.value"
        />
      </div>
    </div>

    <div v-else>
      <card-go-to-configure-resource :resource="resource" />
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
import CardGoToConfigureResource from 'src/components/CardGoToConfigureResource.vue';

interface IManagementCardCreate {
  actionName: TDialog | undefined;
  dataModel?: IConfigurationInput[];
  resource: string;
  translationString: string;
}

defineProps<IManagementCardCreate>();

// Defined the translation variable
const { t } = useI18n({});

// Check if object is array
const checkObject = new HandleObject();
</script>

<style lang="scss" scoped></style>
