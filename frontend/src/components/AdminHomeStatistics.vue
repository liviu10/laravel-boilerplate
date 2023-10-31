<template>
  <div class="admin-section admin-section--statistics">
    <div class="admin-section__statistics-card">
      <q-card class="">
        <q-card-section>
          <p>Communication</p>
        </q-card-section>
        <q-card-section>
          <q-list bordered separator>
            <q-item clickable v-ripple>
              <q-item-section>
                <q-item-label>
                  <p>Contact</p>
                </q-item-label>
                <q-item-label caption>
                  <p>
                    # of unread messages:
                    <strong>15</strong>
                  </p>
                  <q-icon name="arrow_downward" />
                </q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable v-ripple>
              <q-item-section>
                <q-item-label>
                  <p>Newsletter</p>
                </q-item-label>
                <q-item-label caption>
                  <p>
                    # of subscribers:
                    <strong>100</strong>
                  </p>
                  <q-icon name="arrow_upward" />
                </q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable v-ripple>
              <q-item-section>
                <q-item-label>
                  <p>Reviews</p>
                </q-item-label>
                <q-item-label caption>
                  <p>
                    Average review rating:
                    <strong>4.5</strong>
                  </p>
                  <q-icon name="star" />
                </q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-card-section>
        <q-card-section>
          <q-btn color="primary" dense label="View more" />
        </q-card-section>
      </q-card>
      <q-card class="">
        <q-card-section>
          <p>Management</p>
        </q-card-section>
        <q-card-section>
          <q-list bordered separator>
            <q-item clickable v-ripple>
              <q-item-section>
                <q-item-label>
                  <p>Content</p>
                </q-item-label>
                <q-item-label caption>
                  <p>
                    Total views:
                    <strong>15</strong>
                  </p>
                  <q-icon name="arrow_downward" />
                </q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable v-ripple>
              <q-item-section>
                <q-item-label>
                  <p>Tags</p>
                </q-item-label>
                <q-item-label caption>
                  <p>
                    Tag popularity:
                    <strong>100</strong>
                  </p>
                  <q-icon name="arrow_upward" />
                </q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable v-ripple>
              <q-item-section>
                <q-item-label>
                  <p>Media</p>
                </q-item-label>
                <q-item-label caption>
                  <p>
                    Media uploads today:
                    <strong>4.5</strong>
                  </p>
                  <q-icon name="star" />
                </q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable v-ripple>
              <q-item-section>
                <q-item-label>
                  <p>Comment</p>
                </q-item-label>
                <q-item-label caption>
                  <p>
                    Recent comment:
                    <strong>4.5</strong>
                  </p>
                  <q-icon name="star" />
                </q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable v-ripple>
              <q-item-section>
                <q-item-label>
                  <p>Appreciations</p>
                </q-item-label>
                <q-item-label caption>
                  <p>
                    Total appreciations received:
                    <strong>4.5</strong>
                  </p>
                  <q-icon name="star" />
                </q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-card-section>
        <q-card-section>
          <q-btn color="primary" dense label="View more" />
        </q-card-section>
      </q-card>
      <q-card class="">
        <q-card-section>
          <p>Settings</p>
        </q-card-section>
        <q-card-section>
          <q-list bordered separator>
            <q-item clickable v-ripple>
              <q-item-section>
                <q-item-label>
                  <p>Notifications</p>
                </q-item-label>
                <q-item-label caption>
                  <p>
                    Template utilization rate:
                    <strong>15</strong>
                  </p>
                  <q-icon name="arrow_downward" />
                </q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable v-ripple>
              <q-item-section>
                <q-item-label>
                  <p>General</p>
                </q-item-label>
                <q-item-label caption>
                  <p>
                    Application settings changes:
                    <strong>100</strong>
                  </p>
                  <q-icon name="arrow_upward" />
                </q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable v-ripple>
              <q-item-section>
                <q-item-label>
                  <p>Users</p>
                </q-item-label>
                <q-item-label caption>
                  <p>
                    New user registrations today:
                    <strong>4.5</strong>
                  </p>
                  <q-icon name="star" />
                </q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-card-section>
        <q-card-section>
          <q-btn color="primary" dense label="View more" />
        </q-card-section>
      </q-card>
    </div>
  </div>
</template>

<script setup lang="ts">
// Import vue related utilities

// Import library utilities, interfaces and components

// Import Pinia's related utilities

// Defined the translation variable

// Instantiate the pinia store
</script>

<style lang="scss" scoped>
.admin-section {
  &--statistics {
    margin: 16px 0;
  }
  &__statistics-card {
    & .q-card {
      margin: 0 20px;
      border-radius: 0;
      &__section {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        & p {
          margin-bottom: 0;
        }
        & .q-list {
          width: 100%;
          & .q-item {
            padding: 8px;
            &__label--caption {
              display: flex;
              align-items: center;
              justify-content: space-between;
            }
          }
        }
        & .q-btn {
          border-radius: 0;
        }
      }
      &__section:first-child {
        & p {
          font-size: 20px;
          font-weight: 700;
        }
      }
    }
  }
}
</style>
