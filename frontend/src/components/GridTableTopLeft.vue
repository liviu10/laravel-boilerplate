<template>
  <div class="admin-section__grid-table-top-left">
    <q-btn
      color="info"
      dense
      icon="more_vert"
      :label="t('admin.generic.options_label')"
      square
    >
      <q-tooltip>
        {{ t('admin.generic.options_label_tooltip') }}
      </q-tooltip>
      <q-menu fit square>
        <q-list>
          <q-item
            v-for="option in moreOptions.slice(0, moreOptions.length - 1)"
            :key="option.id"
            clickable
            dense
            v-close-popup
            @click="option.clickEvent"
          >
            <q-item-section>
              <span>
                <q-icon :name="option.icon" />
                {{ t(option.label as string) }}
              </span>
            </q-item-section>
          </q-item>
          <q-separator v-if="moreOptions.length > 1" />
          <q-item
            v-for="option in moreOptions.slice(-1)"
            :key="option.id"
            clickable
            dense
            v-close-popup
            @click="option.clickEvent"
          >
            <q-item-section>
              <span>
                <q-icon :name="option.icon" />
                {{ t(option.label as string) }}
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

interface IMoreOptions {
  id: number
  clickEvent: () => void
  icon: string
  label: string
}

interface IGridTableTopLeft {
  actionMethods: { [key: number]: TDialog }
  moreOptions: IMoreOptions[]
}

withDefaults(defineProps<IGridTableTopLeft>(), {});
</script>

<style lang="scss" scoped>
@import 'src/css/components/component_menu.scss';
</style>
