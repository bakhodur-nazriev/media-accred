<script lang="ts" setup>
const userData = useCookie<any>('userData')

const roleLabels: Record<string, string> = {
  admin: 'Администратор',
  moderator: 'Модератор',
}

const roleLabel = computed(() => {
  if (userData.value?.role)
    return roleLabels[userData.value.role] || userData.value.role
  return ''
})
</script>

<template>
  <VCard v-if="userData">
    <VCardText class="d-flex align-bottom flex-sm-row flex-column justify-center gap-x-5">
      <div class="d-flex h-0">
        <VAvatar
          rounded
          size="120"
          class="user-profile-avatar mx-auto"
        >
          <VIcon
            size="60"
            icon="tabler-user"
          />
        </VAvatar>
      </div>

      <div class="user-profile-info w-100 mt-16 pt-6 pt-sm-0 mt-sm-0">
        <h5 class="text-h5 text-center text-sm-start font-weight-medium mb-3">
          {{ userData.name || 'Пользователь' }}
        </h5>

        <div class="d-flex align-center justify-center justify-sm-space-between flex-wrap gap-4">
          <div class="d-flex flex-wrap justify-center justify-sm-start flex-grow-1 gap-4">
            <span class="d-flex">
              <VIcon
                size="20"
                icon="tabler-user-circle"
                class="me-1"
              />
              <span class="text-body-1">
                {{ roleLabel }}
              </span>
            </span>

            <span class="d-flex">
              <VIcon
                size="20"
                icon="tabler-mail"
                class="me-1"
              />
              <span class="text-body-1">
                {{ userData.email }}
              </span>
            </span>
          </div>
        </div>
      </div>
    </VCardText>
  </VCard>
</template>

<style lang="scss">
.user-profile-avatar {
  border: 5px solid rgb(var(--v-theme-surface));
  background-color: rgb(var(--v-theme-surface)) !important;
  inset-block-start: -3rem;

  .v-img__img {
    border-radius: 0.125rem;
  }
}
</style>
