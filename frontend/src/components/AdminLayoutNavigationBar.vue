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

// Import generic components, libraries and interfaces
import {
  displayIconInfo,
  displayLabelInfo
} from 'src/library/TextOperations/TextOperations';

interface AdminNavigationBarProps {
  routerConfig: RouteRecordRaw;
  applicationName: string | undefined;
}

// Defined the translation variable
const { t } = useI18n({});

/**
 * Generate display information for a navigation icon.
 * @param {string | unknown} navigationIcon - The navigation icon identifier.
 * @returns {string | undefined} Display information for the navigation icon, or undefined if not found.
 */
const displayNavigationIcon = computed(() => {
  return (navigationIcon: string | unknown): string | undefined => {
    return displayIconInfo.value(navigationIcon)
  };
});

/**
 * Generate display label information for navigation.
 * @param {string | unknown} navigationLabel - The navigation label identifier.
 * @returns {string | undefined} Display label information for navigation, or undefined if not found.
 */
const displayNavigationLabel = computed(() => {
  return (navigationLabel: string | unknown): string | undefined => {
    return displayLabelInfo.value(navigationLabel)
  };
});

withDefaults(defineProps<AdminNavigationBarProps>(), {});
</script>
src/library/TextOperations/TextOperations
