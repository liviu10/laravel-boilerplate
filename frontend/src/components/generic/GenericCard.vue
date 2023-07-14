<template>
  <q-card class="">
    <q-card-section>
      <div class="">My account</div>
    </q-card-section>

    <q-card-section>
      The profile page allows users to update their personal information such as first name, last name, nickname, phone number, password, and profile image.
    </q-card-section>

    <q-card-actions>
      <q-btn>View more</q-btn>
    </q-card-actions>
  </q-card>
</template>

<script setup lang="ts">
// Import framework related utilities
import { useI18n } from 'vue-i18n';

// interface GenericCardProps {
//   color?: string;
//   dense?: boolean;
//   disable?: boolean;
//   displayTooltip?: boolean;
//   flat?: boolean;
//   icon?: string;
//   label?: string | number;
//   noCaps?: boolean;
//   noWrap?: boolean;
//   outline?: boolean;
//   padding?: string;
//   round?: boolean;
//   rounded?: boolean;
//   size?: string;
//   square?: boolean;
//   stack?: boolean;
//   textColor?: string;
//   tooltipMessage?: string;
//   type?: 'button' | 'submit' | 'reset' | undefined;
// }

// Defined the translation variable
const { t } = useI18n({});

// Defines the event emitters for the component.
// withDefaults(defineProps<GenericCardProps>(), {});
</script>

<style lang="scss" scoped></style>
