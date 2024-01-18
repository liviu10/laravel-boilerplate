<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t(`${configurationResourceStore.getTranslationString}.title`)" />

    <page-description
      :page-description="t(`${configurationResourceStore.getTranslationString}.page_description`)"
    />

    <div class="admin-section admin-section--container">
      <q-card>
        <q-card-section>
          configuration id: {{ configurationResourceStore.getDataModel }}
          <card-create
            action-name="create"
            :data-model="configurationResourceStore.getDataModel"
            :resource="configurationResourceStore.getResourceName"
            :translation-string="configurationResourceStore.getTranslationString"
          />
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { HandleRoute } from 'src/utilities/HandleRoute';
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';
import CardCreate from 'src/components/CardCreate.vue';

// Import Pinia's related utilities
import { useConfigurationResourceStore } from 'src/stores/settings/configuration_resources';

// Instantiate the pinia store
const configurationResourceStore = useConfigurationResourceStore();

// Defined the translation variable
const { t } = useI18n({});

// Get configuration resource id
const handleRoute = new HandleRoute();
const resourceKeyName = handleRoute.handleResourceNameFromRoute();
configurationResourceStore.handleGetConfigurationId(resourceKeyName)
.then(() => {
  const configurationResource = configurationResourceStore.getResourceConfiguration
  if (configurationResource && Array.isArray(configurationResource) && configurationResource.length) {
    configurationResourceStore.handleGetInputs(configurationResource)
  } else {
    // TODO: Display notification to user that something went wrong
  }
});

</script>

<style lang="scss" scoped>
@import 'src/css/pages/admin/settings.scss';
</style>
