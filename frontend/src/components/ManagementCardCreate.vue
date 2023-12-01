<template>
  <div class="admin-section__dialog-body-content">
    <div v-if="checkObject.handleCheckIfArray(dataModel)">
      <div v-for="input in dataModel" :key="input.id">
        <q-select
          v-if="checkObject.handleCheckIfArray(input.configuration_options)"
          dense
          emit-value
          :label="
            t(`admin.management.${resource.toLowerCase()}.data_model.${input.field}`)
          "
          outlined
          square
          stack-label
          v-model="input.value"
          :options="input.configuration_options"
        />
        <q-input
          v-else
          dense
          :label="
            t(`admin.management.${resource.toLowerCase()}.data_model.${input.field}`)
          "
          outlined
          square
          stack-label
          v-model="input.value"
        />
      </div>
    </div>

    <div v-else>
      <p>
        {{ t(`admin.management.${resource.toLowerCase()}.no_data_model`) }}
      </p>
      <q-btn
        color="primary"
        dense
        :label="t('admin.generic.configure_resource')"
        square
        @click="goToConfigureResource"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { LocationQueryRaw, NavigationFailure, useRouter } from 'vue-router';
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { IConfigurationInput } from 'src/interfaces/ConfigurationResourceInterface';
import { HandleObject } from 'src/utilities/HandleObject';
import { HandleRoute } from 'src/utilities/HandleRoute';

interface IManagementCardCreate {
  dataModel?: IConfigurationInput[];
  resource: string;
}

const props = defineProps<IManagementCardCreate>();

// Defined the translation variable
const { t } = useI18n({});

// Check if object is array
const checkObject = new HandleObject();

// Navigate to route
const navigateToRoute = new HandleRoute();
const router = useRouter();
const goToConfigureResource = (): Promise<void | NavigationFailure | undefined> =>
  navigateToRoute.handleNavigateToRoute(
    router,
    'AdminSettingConfigurationResourcePage',
    undefined,
    ({ resource: props.resource } as unknown) as LocationQueryRaw
  );
</script>

<style lang="scss" scoped></style>
