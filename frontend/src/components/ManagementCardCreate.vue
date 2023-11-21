<template>
  <div class="admin-section__dialog-body-content">
    Create new record

    <div v-if="dataModel && Array.isArray(dataModel) && dataModel.length">
      <div v-for="input in dataModel" :key="input.id">
        <q-input
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
      <p>
        The data model does not exist.
        Please configure the resource.
        If the problem persist you can contact the administrator.
      </p>
      <q-btn
        color="primary"
        dense
        :label="t('admin.generic.configure_resource')"
        square
        @click="goToConfigureResource"
      />
    </div>

    <pre>{{ dataModel }}</pre>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { LocationQueryRaw, NavigationFailure, useRouter } from 'vue-router';
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { IConfigurationInput } from 'src/interfaces/ConfigurationResourceInterface';
import { HandleRoute } from 'src/utilities/HandleRoute';

interface IManagementCardCreate {
  dataModel?: IConfigurationInput[];
  resource: string
}

const props = defineProps<IManagementCardCreate>();

// Defined the translation variable
const { t } = useI18n({});

// Navigate to route
const navigateToRoute = new HandleRoute()
const router = useRouter();
const goToConfigureResource = (): Promise<void | NavigationFailure | undefined> =>
  navigateToRoute.handleNavigateToRoute(
    router,
    'AdminSettingConfigurationResourcePage',
    { resource: props.resource } as unknown as LocationQueryRaw
  )
</script>

<style lang="scss" scoped></style>
