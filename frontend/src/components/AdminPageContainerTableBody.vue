<template>
  <q-tr :props="props" class="admin-section__container-table-body">
    <q-td v-for="col in props.cols" :key="col.name" :props="props">
      <div v-if="col.name === 'actions'">
        <q-btn
          v-if="showRecordButton"
          color="info"
          dense
          square
          @click="openDialog(actionMethods[0], recordId)"
        >
          <q-icon name="visibility" />
        </q-btn>
        <q-btn
          v-if="editRecordButton"
          color="warning"
          dense
          square
          @click="openDialog(actionMethods[1], recordId)"
        >
          <q-icon name="edit" />
        </q-btn>
        <q-btn
          v-if="showRecordButton"
          color="negative"
          dense
          square
          @click="openDialog(actionMethods[2], recordId)"
        >
          <q-icon name="delete" />
        </q-btn>
      </div>
      <div v-else>
        {{ col.value }}
      </div>
    </q-td>
  </q-tr>
</template>

<script setup lang="ts">
// Import vue related utilities
import { QTrProps } from 'quasar';
import { useI18n } from 'vue-i18n';

// Import generic components, libraries and interfaces
import { notificationSystem } from 'src/library/NotificationSystem';

// Defined the translation variable
const { t } = useI18n({});

interface AdminPageContainerTableHeaderInterface {
  deleteRecordButton?: boolean;
  editRecordButton?: boolean;
  showRecordButton?: boolean;
  props: QTrProps['props'];
  recordId: number;
}
withDefaults(defineProps<AdminPageContainerTableHeaderInterface>(), {});

const emit = defineEmits<{
  (event: 'actionMethodDialog', action: 'show' | 'edit' | 'delete', recordId: number): void;
}>();

const actionMethods: { [key: number]: 'show' | 'edit' | 'delete' } = {
  0: 'show',
  1: 'edit',
  2: 'delete',
};
function openDialog(action: 'show' | 'edit' | 'delete', recordId: number) {
  const isInvalidRecordId = !recordId || typeof recordId !== 'number' || recordId === null;
  if (isInvalidRecordId) {
    const notificationTitle = t('admin.generic.notification_warning_title');
    const notificationMessage = t('admin.generic.notification_warning_message', { recordId: `${recordId}` });
    console.log(
      `The operation could not be performed. Invalid record id: ${recordId}!`
    );
    notificationSystem(notificationTitle, notificationMessage, 'warning');
  } else {
    emit('actionMethodDialog', action, recordId)
  }
}
</script>
