<template>
  <div class="admin-section__grid-table-body">
    <div v-for="col in tableBodyProps.cols" :key="col.label">
      <p v-if="col.label === 'content_type'">
        <span>{{ col.name }}:</span>
        <q-badge :label="col.value" />
      </p>
      <p v-else-if="col.label === 'content_url'">
        <span>{{ col.name }}:</span>
        <span>{{ col.value }}</span>
        <!-- <router-view :to="navigateToRoute.handleNavigateToRoute(col.value)">
          {{ col.value }}
        </router-view> -->
      </p>
      <p v-else-if="col.label === 'visibility'">
        <span>{{ col.name }}:</span>
        <q-badge :label="col.value" />
      </p>
      <p v-else>
        <span>{{ col.name }}:</span>
        <span>{{ col.value }}</span>
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities
import { QTableSlots } from 'quasar';
// import { useRouter } from 'vue-router';

// Import library utilities, interfaces and components
// import { HandleRoute } from 'src/utilities/HandleRoute';

interface IGridTableBody {
  resource?: string
  tableBodyProps: Omit<QTableSlots['item'], 'cols'> & { cols: {
    name: string
    label: string
    value: string
  }[] };
}

withDefaults(defineProps<IGridTableBody>(), {});

// Navigate to route
// const navigateToRoute = new HandleRoute()

// Go to management resource
// const router = useRouter();
</script>

<style lang="scss" scoped></style>
