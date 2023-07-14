<template>
  <q-card
    :dark="dark"
    :square="square"
    :flat="flat"
    :bordered="bordered"
    :style="cssStyle"
  >
    <q-card-section>
      <p class="card-title">
        {{ cardTitle }}
      </p>
    </q-card-section>

    <q-card-section>
      <p class="card-body">
        {{ cardBody }}
      </p>
    </q-card-section>

    <q-card-actions v-if="cardAction.visible">
      <generic-button :color="cardAction.color" :label="cardAction.label" />
    </q-card-actions>
  </q-card>
</template>

<script setup lang="ts">
// Import framework related utilities

// Import generic components, libraries and interfaces
import GenericButton from 'src/components/generic/GenericButton.vue';

interface GenericCardProps {
  dark?: boolean,
  square?: boolean,
  flat?: boolean,
  bordered?: boolean,
  cssStyle?: string,
  cardTitle: string,
  cardBody: string,
  cardAction: {
    visible: boolean,
    label: string,
    color: string
  }
}

// Defines the event emitters for the component.
withDefaults(defineProps<GenericCardProps>(), {});
</script>

<style lang="scss" scoped>
@import 'src/css/utilities/_rem_convertor.scss';

.q-card {
  border: rem-convertor(1px) solid #000000;
  box-shadow: none;
  &__section {
    & .card-title, & .card-body {
      margin-bottom: 0;
    }
    & .card-title {
      font-size: rem-convertor(20px);
      font-weight: 700;
      text-transform: uppercase;
      text-align: center;
    }
  }
  &__actions {
    & .q-btn {
      margin-left: auto;
      margin-right: auto;
      border-radius: 0;
    }
  }
}
</style>
