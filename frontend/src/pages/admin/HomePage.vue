<template>
  <q-page class="admin admin--page">
    <admin-page-title :admin-page-title="currentRouteTitle(router.currentRoute.value.meta)" />

    <admin-page-description
      :admin-route-name="currentRouteName(router.currentRoute.value.name)"
      :admin-application-name="applicationName"
      :admin-page-description="currentRouteDescription(router.currentRoute.value.meta)"
    />

    <admin-page-container :admin-route-name="currentRouteName(router.currentRoute.value.name)">
      <template v-slot:admin-content>
        <div class="admin-section__home-content">
          <q-card
            v-for="(resource, index) in availableResources"
            :key="index"
            class="q-my-sm"
            square
            bordered
          >
            <q-card-section>
              <p v-if="resource.meta" class="card-title">
                {{ t(resource.meta.title as string) }}
              </p>
            </q-card-section>
            <q-card-section>
              <div v-if="resource.meta" class="card-body">
                <p>
                  {{
                    t(resource.meta.caption as string, {
                      applicationName: applicationName,
                    })
                  }}
                </p>
                <div
                  v-if="resource.children && resource.children.length"
                  class="link-list"
                >
                  <template
                    v-for="(link, index) in getChildrenLinks(resource.children)"
                    :key="index"
                  >
                    <span v-if="index > 0">, </span>
                    <span v-html="link.outerHTML"></span>
                  </template>
                </div>
                <a v-else :href="resource.path">
                  {{ t('admin.generic.view_resource') }}
                </a>
              </div>
            </q-card-section>
          </q-card>
        </div>
      </template>
    </admin-page-container>
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { computed } from 'vue';
import { RouteRecordRaw, useRouter } from 'vue-router';
import { useI18n } from 'vue-i18n';

// Import generic components, libraries and interfaces
import AdminPageTitle from 'src/components/AdminPageTitle.vue';
import AdminPageDescription from 'src/components/AdminPageDescription.vue';
import AdminPageContainer from 'src/components/AdminPageContainer.vue';
import {
  currentRouteName,
  currentRouteTitle,
  currentRouteDescription
} from 'src/composables/RouteInfo';

// Defined the translation variable
const { t } = useI18n({});

// Get current route title and route name
const router = useRouter();

// Get application name
const applicationName: string | undefined = process.env.APP_NAME;

// Get all available resources
const availableResources = computed((): RouteRecordRaw[] | undefined => {
  const allResources = router.options.routes[0].children;
  const displayResources: RouteRecordRaw[] | undefined = [];
  allResources?.forEach((resource) => {
    if (resource.name !== 'HomePage' && resource.name !== 'DocumentationPage') {
      displayResources.push(resource);
    }
  });
  return displayResources as RouteRecordRaw[] | undefined;
});

// Generates an array of HTMLAnchorElement objects for the provided children routes.
const getChildrenLinks = (children: RouteRecordRaw[]): HTMLAnchorElement[] => {
  return children.map((child) => {
    const link = document.createElement('a');
    link.setAttribute('href', child.path);
    link.textContent = t(child.meta?.title as string);
    return link;
  });
};
</script>

<style lang="scss" scoped></style>
