<template>
  <div class="admin-section__dialog-body-content">
    <div v-if="checkObject.handleCheckIfArray(dataModel)">
      <div v-for="input in dataModel" :key="input.id">
        <q-select
          v-if="checkObject.handleCheckIfArray(input.configuration_options)"
          dense
          emit-value
          input-debounce="0"
          :label="t(`${translationString}.data_model.${input.field}`)"
          map-options
          outlined
          square
          stack-label
          use-input
          v-model="input.value"
          :options="input.configuration_options"
          @filter="filterFn"
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
      <card-go-to-configure-resource non-existing-model="filter" :resource="resource" />
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { HandleObject } from 'src/utilities/HandleObject';
import { IConfigurationInput } from 'src/interfaces/ConfigurationResourceInterface';
import { TDialog } from 'src/interfaces/BaseInterface';
import CardGoToConfigureResource from 'src/components/CardGoToConfigureResource.vue';
import { ref } from 'vue';

interface ICardAdvancedFilter {
  actionName: TDialog | undefined;
  dataModel?: IConfigurationInput[];
  resource: string;
  translationString: string;
}

const props = defineProps<ICardAdvancedFilter>();

// Defined the translation variable
const { t } = useI18n({});

// Check if object is array
const checkObject = new HandleObject();

// Filter function
function filterFn(val: string, update: (arg0: () => void) => void) {
  const needle = val.toLowerCase();
  console.log('--> needle', needle, val);
  update(() => {
    // Assuming each input has its own options array
    props.dataModel?.forEach((input) => {
      if (input.configuration_options) {
        input.configuration_options = input.configuration_options.filter((option) => {
          console.log('--> option', option);
          return option.label.toLowerCase().includes(needle);
        });
      }
    });
  });
  console.log('---> dataModel', props.dataModel);
}
</script>

<style lang="scss" scoped></style>
