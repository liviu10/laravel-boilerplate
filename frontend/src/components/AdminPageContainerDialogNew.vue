<template>
  <div class="admin-section__container-dialog-new">
    <div v-for="model in dataModel" :key="model.id">
      <q-input
        v-if="model.type !== 'select'"
        autocomplete="off"
        :class="model.errors && model.errors !== undefined ? 'input-error' : ''"
        dense
        :label="model.name"
        outlined
        :required="model.required"
        square
        stack-label
        :type="dataModelType(model.type)"
        v-model="model.value"
      />
      <q-select
        v-else
        dense
        emit-value
        :label="model.name"
        map-options
        :options="model.options"
        options-dense
        outlined
        square
        stack-label
        v-model="model.value"
      />
      <p>
        {{ model.errors }}
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { computed } from 'vue';

// Import generic components, libraries and interfaces
import { CreateModelInterface } from 'src/interfaces/ApiResponseInterface';
import { InputType } from 'src/types/InputType';
import { inputType } from 'src/composables/InputType';

interface AdminPageContainerDialogInterface {
  dataModel?: CreateModelInterface[];
}

/**
 * Display the data model type.
 * @param {string} type - The data model type.
 * @returns {InputType}
 */
const dataModelType = computed(() => {
  return ((type: string): InputType => {
    const fieldType = inputType.value(type)
    if (fieldType && fieldType !== undefined) {
      return fieldType
    } else {
      return 'text'
    }
  })
});

withDefaults(defineProps<AdminPageContainerDialogInterface>(), {});
</script>

<style lang="scss" scoped>
@import "src/css/utilities/_rem_convertor.scss";

.admin-section__container-dialog-new {
  & div {
    margin: rem-convertor(8px) 0;
    & p {
      margin-bottom: 0;
      color: #FF0000;
      font-weight: 700;
    }
  }
}
.input-error {
  border: rem-convertor(1px) solid #FF0000 !important;
}
</style>
