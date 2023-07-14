<template>
  <q-page class="admin admin--page">
    <admin-page-title :admin-page-title="currentRouteTitle" />

    <admin-page-description :admin-application-name="applicationName" />

    <admin-page-container :admin-route-name="currentRouteName">
      <template v-slot:admin-content>
        <div class="admin-section admin-section--content">
          <generic-card />

          <!-- <q-card class="">
            <q-card-section>
              <div class="">User profile and permissions</div>
            </q-card-section>

            <q-card-section>
              User roles and permissions define the level of access and actions a user can perform within a system. They ensure proper security and control by assigning specific privileges based on roles like webmaster, administrator, accountant, sales, client.
            </q-card-section>

            <q-card-actions>
              <q-btn>View more</q-btn>
            </q-card-actions>
          </q-card> -->
        </div>
      </template>
    </admin-page-container>
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { ref } from 'vue';
import { useRouter } from 'vue-router';

// Import generic components, libraries and interfaces
import AdminPageTitle from 'src/components/AdminPageTitle.vue';
import AdminPageDescription from 'src/components/AdminPageDescription.vue';
import AdminPageContainer from 'src/components/AdminPageContainer.vue';
import GenericCard from 'src/components/generic/GenericCard.vue';

// Get current route title and route name
const router = useRouter();
let currentRouteTitle = ref(router.currentRoute.value.meta.title)
let currentRouteName = ref(router.currentRoute.value.name);

// Get application name
const applicationName: string | undefined = process.env.APP_NAME
</script>

<style lang="scss" scoped></style>
