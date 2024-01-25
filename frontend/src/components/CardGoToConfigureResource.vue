<template>
  <p class="admin-section admin-section--go-to-configure-resource">
    <q-icon name="warning" />
    {{ t(`admin.generic.no_data_model`, { nonExistingModel: nonExistingModel || undefined }) }}
    <a href="" @click="goToConfigureResource">
      {{ t('admin.generic.configure_resource') }}
    </a>
  </p>
</template>

<script setup lang="ts">
// Import vue related utilities
import { LocationQueryRaw, NavigationFailure, useRouter } from 'vue-router';
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { HandleRoute } from 'src/utilities/HandleRoute';

interface ICardGoToConfigureResource {
  nonExistingModel?: string
  resource: string
  translationString?: string
}

const props = defineProps<ICardGoToConfigureResource>();

// Defined the translation variable
const { t } = useI18n({});

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

<style lang="scss" scoped>
@import 'src/css/components/go_to_configure_resource.scss';
</style>
