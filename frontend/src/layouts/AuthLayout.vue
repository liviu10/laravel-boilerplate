<template>
  <q-layout class="auth auth--layout" view="lFf Lpr lHh">
    <q-page-container class="auth__container">
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts"></script>

<style lang="scss" scoped>
@import 'src/css/layouts/authentication.scss';
</style>
