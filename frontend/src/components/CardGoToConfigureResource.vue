<template>
  <p class="admin-section admin-section--go-to-configure-resource">
    <q-icon name="warning" />
    {{
      t(`admin.generic.no_data_model`, {
        nonExistingModel: nonExistingModel || undefined,
      })
    }}
    <q-btn
      color="positive"
      dense
      :label="t('admin.generic.configure_resource')"
      square
      @click="handleNavigateToPage"
    >
      <q-tooltip>
        {{ t('admin.generic.configure_resource_tooltip') }}
      </q-tooltip>
    </q-btn>
  </p>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useRouter } from 'vue-router';
import { useI18n } from 'vue-i18n';

interface ICardGoToConfigureResource {
  nonExistingModel?: string;
  resource: string;
  translationString?: string;
}

const props = defineProps<ICardGoToConfigureResource>();

// Defined the translation variable
const { t } = useI18n({});

// Go to Configure resource
const router = useRouter();

// Handle navigate to page
const handleNavigateToPage = () => {
  return router.push({
    name: 'AdminSettingConfigurationResourceCreatePage',
    query: { key: props.resource },
  });
};
</script>

<style lang="scss" scoped>
@import 'src/css/components/go_to_configure_resource.scss';
</style>
