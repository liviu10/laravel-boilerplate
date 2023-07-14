<template>
  <q-page class="admin admin--page">
    <admin-page-title :admin-page-title="currentRouteTitle" />

    <admin-page-description :admin-application-name="applicationName" />

    <admin-page-container :admin-route-name="currentRouteName">
      <template v-slot:admin-content>
        <div class="admin-section admin-section--content">
          <q-card
            v-for="(resource, index) in availableResources"
            :key="index"
            :class="cardMargins(index) + ' q-my-sm'"
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
                <p>{{ t(resource.meta.caption as string) }}</p>
                <q-list v-if="resource.children && resource.children.length" bordered separator>
                  <q-item v-for="(children, index) in resource.children" :key="index" clickable v-ripple>
                    <q-item-section v-if="children.meta">
                      <q-item-label>
                        <a :href="children.path">{{ t(children.meta.title as string) }}</a>
                      </q-item-label>
                      <q-item-label>
                        {{ t(children.meta.caption as string) }}
                      </q-item-label>
                    </q-item-section>
                  </q-item>
                </q-list>
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
import { Ref, computed, ref } from 'vue';
import { RouteRecordRaw, useRouter } from 'vue-router';
import { useI18n } from 'vue-i18n';

// Import generic components, libraries and interfaces
import AdminPageTitle from 'src/components/AdminPageTitle.vue';
import AdminPageDescription from 'src/components/AdminPageDescription.vue';
import AdminPageContainer from 'src/components/AdminPageContainer.vue';

// Defined the translation variable
const { t } = useI18n({});

// Get current route title and route name
const router = useRouter();
let currentRouteTitle = ref(router.currentRoute.value.meta.title)
let currentRouteName = ref(router.currentRoute.value.name);

// Get application name
const applicationName: string | undefined = process.env.APP_NAME

// Get all available resources
let availableResources: Ref<RouteRecordRaw[] | undefined> = computed(() => {
  const allResources = router.options.routes[0].children;
  const displayResources: RouteRecordRaw[] | undefined = []
  allResources?.forEach((resource) => {
    if (resource.name !== 'HomePage') {
      displayResources.push(resource)
    }
  })
  return displayResources
});
function cardMargins(cardIndex: number): string | void {
  if (cardIndex % 2 === 0) {
    return 'q-mr-sm'
  } else if (cardIndex === 1) {
    return 'q-mr-none'
  }
}
</script>

<style lang="scss" scoped>
@import 'src/css/utilities/rem_convertor';
@import 'src/css/utilities/_flexbox.scss';

.admin-section {
  &--content {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    & .q-card {
      width: 45%;
      box-shadow: none;
      &__section {
        padding: rem-convertor(8px);
        & .card-title {
          margin-bottom: 0;
          font-size: rem-convertor(20px);
          font-weight: 700;
          text-transform: uppercase;
          text-align: center;
        }
        & .card-body {
          & p {
            margin: rem-convertor(8px) 0
          }
          & .q-list {
            & .q-item {
              padding: rem-convertor(8px);
            }
          }
        }
      }
    }
  }
}
</style>
