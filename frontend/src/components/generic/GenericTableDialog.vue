<template>
  <q-dialog v-model="$props.openDialog">
    <q-card>
      <q-card-section>
        <div class="text-h6">Alert</div>
      </q-card-section>

      <q-card-section class="q-pt-none">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum repellendus sit voluptate voluptas eveniet porro. Rerum blanditiis perferendis totam, ea at omnis vel numquam exercitationem aut, natus minima, porro labore.
      </q-card-section>

      <q-card-actions align="right">
        <q-btn flat label="OK" color="primary" @click="closeDialog" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script setup lang="ts">
// Import framework related utilities
import { useI18n } from 'vue-i18n';

// Import generic components
import GenericButton from './GenericButton.vue';

// Defined the translation variable
const { t } = useI18n({});

// Defines the event emitters for the component.
const emit = defineEmits([
  'closeDialog',
]);

// Defines the props for the component.
const props = defineProps<{
  openDialog: boolean;
  dialogName: 'new-record' | 'download-records' | 'upload-records' | 'show-record' | 'edit-record' | 'delete-record' | undefined;
}>();

function closeDialog(): void {
  emit('closeDialog');
}
</script>

<style lang="scss" scoped></style>
