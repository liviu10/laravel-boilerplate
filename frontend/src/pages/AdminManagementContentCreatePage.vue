<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t('admin.management.content.title')" />

    <page-description :page-description="t('admin.management.content.page_description')" />

    <div class="admin-section admin-section--container-create">
      <div v-if="checkObject.handleCheckIfArray(contentStore.getDataModel)">
        <div v-for="input in contentStore.getDataModel" :key="input.id">
          <q-select
            v-if="checkObject.handleCheckIfArray(input.configuration_options)"
            dense
            emit-value
            :label="t(`admin.management.${contentStore.resourceName.toLowerCase()}.data_model.${input.field}`)"
            outlined
            square
            stack-label
            v-model="input.value"
            :options="input.configuration_options"
          />
          <q-input
            v-else
            dense
            :label="t(`admin.management.${contentStore.resourceName.toLowerCase()}.data_model.${input.field}`)"
            outlined
            square
            stack-label
            v-model="input.value"
          />
        </div>
      </div>

      <div v-else>
        <management-card-go-to-configure-resource :resource="contentStore.resourceName.toLowerCase()" />
      </div>

      <div v-if="checkObject.handleCheckIfArray(tagStore.getDataModel)">
        <q-expansion-item v-model="tagExpansionItem" :label="t(`admin.management.${tagStore.resourceName.toLowerCase()}.title`)">
          <q-card>
            <q-card-section>
              <div v-for="input in tagStore.getDataModel" :key="input.id">
                <q-select
                  v-if="checkObject.handleCheckIfArray(input.configuration_options)"
                  dense
                  emit-value
                  :label="t(`admin.management.${tagStore.resourceName.toLowerCase()}.data_model.${input.field}`)"
                  outlined
                  square
                  stack-label
                  v-model="input.value"
                  :options="input.configuration_options"
                />
                <q-input
                  v-else
                  dense
                  :label="t(`admin.management.${tagStore.resourceName.toLowerCase()}.data_model.${input.field}`)"
                  outlined
                  square
                  stack-label
                  v-model="input.value"
                />
              </div>
            </q-card-section>
          </q-card>
        </q-expansion-item>
      </div>

      <div v-if="checkObject.handleCheckIfArray(mediaStore.getDataModel)">
        <q-expansion-item v-model="mediaExpansionItem" :label="t(`admin.management.${mediaStore.resourceName.toLowerCase()}.title`)">
          <q-card>
            <q-card-section>
              <div v-for="input in mediaStore.getDataModel" :key="input.id">
                <q-select
                  v-if="checkObject.handleCheckIfArray(input.configuration_options)"
                  dense
                  emit-value
                  :label="t(`admin.management.${mediaStore.resourceName.toLowerCase()}.data_model.${input.field}`)"
                  outlined
                  square
                  stack-label
                  v-model="input.value"
                  :options="input.configuration_options"
                />
                <q-input
                  v-else
                  dense
                  :label="t(`admin.management.${mediaStore.resourceName.toLowerCase()}.data_model.${input.field}`)"
                  outlined
                  square
                  stack-label
                  v-model="input.value"
                />
              </div>
            </q-card-section>
          </q-card>
        </q-expansion-item>
      </div>
    </div>
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { HandleObject } from 'src/utilities/HandleObject';
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';
import ManagementCardGoToConfigureResource from 'src/components/ManagementCardGoToConfigureResource.vue';

// Import Pinia's related utilities
import { useContentStore } from 'src/stores/management/content';
import { useTagStore } from 'src/stores/management/tags';
import { useMediaStore } from 'src/stores/management/media';

// Instantiate the pinia store
const contentStore = useContentStore();
const tagStore = useTagStore();
const mediaStore = useMediaStore();

// Defined the translation variable
const { t } = useI18n({});

// Check if object is array
const checkObject = new HandleObject();

// Tags expansion item
const tagExpansionItem = ref(false);

// Media expansion item
const mediaExpansionItem = ref(false);
</script>

<style lang="scss" scoped>
@import 'src/css/pages/admin/management.scss';
</style>
