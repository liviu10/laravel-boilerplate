<template>
  <div v-if="routerConfig && !routerConfig.children">
    <q-item clickable tag="a" :href="routerConfig.path">
      <q-item-section avatar>
        <q-icon :name="displayNavigationIcon(routerConfig.meta?.icon)" />
      </q-item-section>
      <q-item-section>
        <q-item-label>
          {{ displayNavigationLabel(t(routerConfig.meta?.title as string)) }}
        </q-item-label>
      </q-item-section>
    </q-item>
  </div>

  <div v-else>
    <q-expansion-item
      :icon="displayNavigationIcon(routerConfig.meta?.icon)"
      :label="displayNavigationLabel(t(routerConfig.meta?.title as string))"
    >
      <q-item
        v-for="(item, index) in routerConfig.children"
        :key="index"
        :v-bind="item"
        :clickable="item.children ? undefined : true"
        :tag="item.children ? undefined : 'a'"
        :href="item.children ? undefined : item.path"
        dense
        :class="item.children ? 'navbar-submenu' : ''"
      >
        <q-item-section>
          <q-item-label v-if="!item.children">
            {{ displayNavigationLabel(t(item.meta?.title as string)) }}
          </q-item-label>
          <q-expansion-item
            v-else
            dense
            :label="displayNavigationLabel(t(item.meta?.title as string))"
          >
            <q-item
              v-for="(subItem, index) in item.children"
              :key="index"
              :v-bind="subItem"
              :href="subItem.path"
              dense
            >
              <q-item-section>
                {{ displayNavigationLabel(t(subItem.meta?.title as string)) }}
              </q-item-section>
            </q-item>
          </q-expansion-item>
        </q-item-section>
      </q-item>
    </q-expansion-item>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { computed } from 'vue';
import type { RouteRecordRaw } from 'vue-router';
import { useI18n } from 'vue-i18n';

interface AdminNavigationBarProps {
  routerConfig: RouteRecordRaw;
  applicationName: string | undefined;
}

// Defined the translation variable
const { t } = useI18n({});

/**
 * Returns a string representation of the navigation
 * icon if it is a valid string.
 * @param navigationIcon - The navigation icon to be displayed.
 * @returns The string representation of the
 * navigation icon, or undefined if it is not a valid string.
 */
const displayNavigationIcon = computed(() => {
  return (navigationIcon: string | unknown): string | undefined => {
    if (navigationIcon && typeof navigationIcon === 'string') {
      return String(navigationIcon);
    } else {
      return undefined;
    }
  };
});

/**
 * Returns a string representation of the navigation
 * label; if it is a valid string.
 * @param navigationLabel - The navigation label to be displayed.
 * @returns The string representation of the navigation
 * label, or undefined if it is not a valid string.
 */
const displayNavigationLabel = computed(() => {
  return (navigationLabel: string | unknown): string | undefined => {
    if (navigationLabel && typeof navigationLabel === 'string') {
      return String(navigationLabel);
    } else {
      return undefined;
    }
  };
});

withDefaults(defineProps<AdminNavigationBarProps>(), {});
</script>
