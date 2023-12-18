<template>
  <div class="admin-section__grid-table-body-actions">
    <q-btn
      color="info"
      dense
      icon="arrow_drop_down"
      :label="t('admin.generic.actions_label')"
      square
    >
      <q-tooltip>
        {{ t('admin.generic.actions_label_tooltip') }}
      </q-tooltip>
      <q-menu fit square>
        <q-list>
          <q-item
            v-for="action in moreActions"
            :key="action.id"
            clickable
            dense
            v-close-popup
            @click="action.clickEvent"
          >
            <q-item-section>
              <span>
                <q-icon :name="action.icon" />
                {{ t(action.label as string) }}
              </span>
            </q-item-section>
          </q-item>
        </q-list>
      </q-menu>
    </q-btn>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import { TDialog } from 'src/interfaces/BaseInterface';

// Defined the translation variable
const { t } = useI18n({});

interface IMoreActions {
  id: number
  clickEvent: () => void
  icon: string
  label: string
}

interface IGridTableBodyActions {
  actionMethods: { [key: number]: TDialog }
  moreActions: IMoreActions[]
}

withDefaults(defineProps<IGridTableBodyActions>(), {});
</script>

<style lang="scss" scoped>
@import 'src/css/components/component_menu.scss';
</style>
