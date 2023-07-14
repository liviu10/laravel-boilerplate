<template>
  <div v-if="routerConfig && !routerConfig.children">
    <q-item clickable tag="a" :href="routerConfig.path">
      <q-item-section avatar>
        <q-icon :name="displayNavigationIcon(routerConfig.meta?.icon)" />
      </q-item-section>
      <q-item-section>
        <q-item-label>{{ displayNavigationLabel(t(routerConfig.meta?.title as string)) }}</q-item-label>
        <q-item-label caption>{{ displayNavigationCaption(t(routerConfig.meta?.caption as string)) }}</q-item-label>
      </q-item-section>
    </q-item>
  </div>

  <div v-else>
    <q-expansion-item
      :icon="displayNavigationIcon(routerConfig.meta?.icon)"
      :label="displayNavigationLabel(t(routerConfig.meta?.title as string))"
      :caption="displayNavigationCaption(t(routerConfig.meta?.caption as string))"
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
          <q-item-label v-if="!item.children">{{ displayNavigationLabel(t(item.meta?.title as string)) }}</q-item-label>
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
              <q-item-section>{{ displayNavigationLabel(t(subItem.meta?.title as string)) }}</q-item-section>
            </q-item>
          </q-expansion-item>
        </q-item-section>
      </q-item>
    </q-expansion-item>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import type { RouteRecordRaw } from 'vue-router';
import { useI18n } from 'vue-i18n';

export interface AdminNavigationBarProps {
  routerConfig: RouteRecordRaw;
}

// Defined the translation variable
const { t } = useI18n({});

// Display the navigation icon name
function displayNavigationIcon(
  navigationIcon: string | object | unknown
): string {
  return String(navigationIcon);
}

// Display the navigation label
function displayNavigationLabel(navigationLabel: string | unknown): string {
  return String(navigationLabel);
}

// Display the navigation caption
function displayNavigationCaption(navigationCaption: string | unknown): string {
  return String(navigationCaption);
}

withDefaults(defineProps<AdminNavigationBarProps>(), {});
</script>
