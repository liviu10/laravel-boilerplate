<template>
  <q-page class="admin admin--page">

    <page-title :page-title="t('admin.home.title')" />

    <page-description :page-description="t('admin.home.page_description')" />

    <div class="admin-section admin-section--content">
      <div class="admin-section__statistics-communication">
        <q-card>
          <q-card-section>
            <q-icon color="primary" name="chat" />
          </q-card-section>
          <q-card-section>
            15
          </q-card-section>
          <q-card-section>
            {{ t('admin.home.statistic_contact_messages') }}
          </q-card-section>
        </q-card>
        <q-card>
          <q-card-section>
            <q-icon color="primary" name="campaign" />
          </q-card-section>
          <q-card-section>
            3
          </q-card-section>
          <q-card-section>
            {{ t('admin.home.statistic_newsletter_campaigns') }}
          </q-card-section>
        </q-card>
        <q-card>
          <q-card-section>
            <q-icon color="primary" name="subscriptions" />
          </q-card-section>
          <q-card-section>
            15
          </q-card-section>
          <q-card-section>
            {{ t('admin.home.statistic_newsletter_subscribers') }}
          </q-card-section>
        </q-card>
        <q-card>
          <q-card-section>
            <q-icon color="primary" name="reviews" />
          </q-card-section>
          <q-card-section>
            65
          </q-card-section>
          <q-card-section>
            {{ t('admin.home.statistic_reviews') }}
          </q-card-section>
        </q-card>
      </div>
      <div class="admin-section__statistics-management">
        <q-card>
          <q-card-section>
            <q-icon color="primary" name="visibility" />
          </q-card-section>
          <q-card-section>
            5
          </q-card-section>
          <q-card-section>
            {{ t('admin.home.statistic_articles') }}
          </q-card-section>
        </q-card>
        <q-card>
          <q-card-section>
            <q-icon color="primary" name="storage" />
          </q-card-section>
          <q-card-section>
            15 GB free of 25 GB
          </q-card-section>
          <q-card-section>
            {{ t('admin.home.statistic_storage') }}
          </q-card-section>
        </q-card>
        <q-card>
          <q-card-section>
            <q-icon color="primary" name="star" />
          </q-card-section>
          <q-card-section>
            365 — 25 — 4.5
          </q-card-section>
          <q-card-section>
            {{ t('admin.home.statistic_appreciations') }}
          </q-card-section>
        </q-card>
        <q-card>
          <q-card-section>
            <q-icon color="primary" name="comment" />
          </q-card-section>
          <q-card-section>
            65
          </q-card-section>
          <q-card-section>
            {{ t('admin.home.statistic_comments') }}
          </q-card-section>
        </q-card>
      </div>

      <!-- <div id="chart"></div> -->
    </div>

  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';

// Import library utilities, interfaces and components
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';
// import ApexCharts from 'apexcharts';
// import { onMounted } from 'vue';

// Import Pinia's related utilities

// Defined the translation variable
const { t } = useI18n({});

// Instantiate the pinia store

// onMounted(() => {
//   var options = {
//     chart: {
//       type: 'bar'
//     },
//     series: [{
//       name: 'sales',
//       data: [30, 40, 45, 50, 49, 60, 70, 91, 125]
//     }],
//     xaxis: {
//       categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999]
//     }
//   };

//   var chart = new ApexCharts(document.querySelector('#chart'), options);
//   chart.render();
// });
</script>

<style lang="scss" scoped>
.admin-section {
  &__statistics-communication, &__statistics-management {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    @media only screen and (max-width: 1023px) {
      margin-top: 16px;
      margin-bottom: 16px;
    }
    @media only screen and (min-width: 768px) and (max-width: 1023px) {
      margin-left: 64px;
      margin-right: 64px;
    }
    @media only screen and (min-width: 475px) and (max-width: 767px) {
      margin-left: 48px;
      margin-right: 48px;
    }
    @media only screen and (min-width: 375px) and (max-width: 474px) {
      margin-left: 32px;
      margin-right: 32px;
    }
    @media only screen and (max-width: 374px) {
      margin-left: 16px;
      margin-right: 16px;
    }
    & .q-card {
      border-radius: 0;
      width: 18%;
      @media only screen and (min-width: 600px) and (max-width: 1023px) {
        width: 50%;
      }
      @media only screen and (min-width: 475px) and (max-width: 599px) {
        width: 75%;
      }
      @media only screen and (min-width: 375px) and (max-width: 474px) {
        width: 85%;
      }
      @media only screen and (max-width: 374px) {
        width: 100%;
      }
      &__section {
        padding: 8px;
        text-align: center;
      }
      &__section:first-child {
        font-size: 30px;
      }
      &__section:not(:first-child) {
        font-size: 16px;
        font-weight: 700;
      }
    }
  }
}
</style>
