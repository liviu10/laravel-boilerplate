<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t(`${contentStore.getTranslationString}.title`)" />

    <page-description
      :page-description="t(`${contentStore.getTranslationString}.page_description`)"
    />

    <div class="admin-section admin-section--container-create">
      <div v-if="checkObject.handleCheckIfArray(contentStore.getDataModel)">
        <div v-for="input in contentStore.getDataModel" :key="input.id">
          <q-select
            v-if="checkObject.handleCheckIfArray(input.configuration_options)"
            dense
            emit-value
            :label="t(`${contentStore.getTranslationString}.data_model.${input.field}`)"
            outlined
            square
            stack-label
            v-model="input.value"
            :options="input.configuration_options"
          />
          <q-input
            v-else
            dense
            :label="t(`${contentStore.getTranslationString}.data_model.${input.field}`)"
            outlined
            square
            stack-label
            v-model="input.value"
          />
        </div>
      </div>

      <div v-else>
        <card-go-to-configure-resource :resource="contentStore.resourceName.toLowerCase()" />
      </div>

      <div v-if="checkObject.handleCheckIfArray(tagStore.getDataModel)">
        <q-expansion-item v-model="tagExpansionItem" :label="t(`${tagStore.getTranslationString}.title`)">
          <q-card>
            <q-card-section>
              <div v-for="input in tagStore.getDataModel" :key="input.id">
                <q-select
                  v-if="checkObject.handleCheckIfArray(input.configuration_options)"
                  dense
                  emit-value
                  :label="t(`${tagStore.getTranslationString}.data_model.${input.field}`)"
                  outlined
                  square
                  stack-label
                  v-model="input.value"
                  :options="input.configuration_options"
                />
                <q-input
                  v-else
                  dense
                  :label="t(`${tagStore.getTranslationString}.data_model.${input.field}`)"
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
        <q-expansion-item v-model="mediaExpansionItem" :label="t(`${mediaStore.getTranslationString}.title`)">
          <q-card>
            <q-card-section>
              <div v-for="input in mediaStore.getDataModel" :key="input.id">
                <q-select
                  v-if="checkObject.handleCheckIfArray(input.configuration_options)"
                  dense
                  emit-value
                  :label="t(`${mediaStore.getTranslationString}.data_model.${input.field}`)"
                  outlined
                  square
                  stack-label
                  v-model="input.value"
                  :options="input.configuration_options"
                />
                <q-input
                  v-else
                  dense
                  :label="t(`${mediaStore.getTranslationString}.data_model.${input.field}`)"
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
import CardGoToConfigureResource from 'src/components/CardGoToConfigureResource.vue';

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
