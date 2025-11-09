<script setup lang="ts">
import { VForm } from 'vuetify/components/VForm'

const userData = useCookie<any>('userData')
const isLoading = ref(false)
const isEditing = ref(false)
const refVForm = ref<VForm>()

const profileData = ref({
  name: '',
  email: '',
  role: '',
})

const errors = ref<Record<string, string | undefined>>({
  name: undefined,
  email: undefined,
  password: undefined,
})

// Load profile data
const loadProfile = async () => {
  try {
    isLoading.value = true
    const res = await $api('/profile', {
      method: 'GET',
    })
    
    if (res.userData) {
      profileData.value = {
        name: res.userData.name || '',
        email: res.userData.email || '',
        role: res.userData.role || '',
      }
      // Update cookie
      userData.value = res.userData
    }
  }
  catch (err: any) {
    console.error('Error loading profile:', err)
  }
  finally {
    isLoading.value = false
  }
}

// Update profile
const updateProfile = async () => {
  const isValid = await refVForm.value?.validate()
  
  if (!isValid?.valid)
    return

  try {
    isLoading.value = true
    errors.value = {
      name: undefined,
      email: undefined,
      password: undefined,
    }

    const updateData: any = {}
    if (profileData.value.name !== userData.value?.name)
      updateData.name = profileData.value.name
    if (profileData.value.email !== userData.value?.email)
      updateData.email = profileData.value.email

    const res = await $api('/profile', {
      method: 'PATCH',
      body: updateData,
    })

    if (res.userData) {
      userData.value = res.userData
      profileData.value.role = res.userData.role
      isEditing.value = false
    }
  }
  catch (err: any) {
    console.error('Error updating profile:', err)
    
    // Handle validation errors
    if (err.data?.errors)
      errors.value = err.data.errors
    else if (err.data?.message) {
      errors.value = {
        email: err.data.message,
        name: undefined,
        password: undefined,
      }
    }
  }
  finally {
    isLoading.value = false
  }
}

// Initialize
onMounted(() => {
  if (userData.value) {
    profileData.value = {
      name: userData.value.name || '',
      email: userData.value.email || '',
      role: userData.value.role || '',
    }
  }
  loadProfile()
})
</script>

<template>
  <VRow>
    <VCol
      cols="12"
      md="8"
      offset-md="2"
    >
      <VCard>
        <VCardTitle class="d-flex align-center justify-space-between">
          <span>Профиль пользователя</span>
          <VBtn
            v-if="!isEditing"
            variant="outlined"
            @click="isEditing = true"
          >
            Редактировать
          </VBtn>
          <div
            v-else
            class="d-flex gap-2"
          >
            <VBtn
              variant="outlined"
              @click="isEditing = false; loadProfile()"
            >
              Отмена
            </VBtn>
            <VBtn
              :loading="isLoading"
              @click="updateProfile"
            >
              Сохранить
            </VBtn>
          </div>
        </VCardTitle>

        <VDivider />

        <VCardText>
          <VForm
            ref="refVForm"
            v-if="!isLoading"
          >
            <VRow>
              <VCol cols="12">
                <VTextField
                  v-model="profileData.name"
                  label="Имя"
                  :disabled="!isEditing"
                  :error-messages="errors.name"
                  :rules="[requiredValidator]"
                />
              </VCol>

              <VCol cols="12">
                <VTextField
                  v-model="profileData.email"
                  label="Email"
                  type="email"
                  :disabled="!isEditing"
                  :error-messages="errors.email"
                  :rules="[requiredValidator, emailValidator]"
                />
              </VCol>

              <VCol cols="12">
                <VTextField
                  v-model="profileData.role"
                  label="Роль"
                  disabled
                  hint="Роль нельзя изменить через интерфейс"
                  persistent-hint
                />
              </VCol>
            </VRow>
          </VForm>

          <div
            v-else
            class="d-flex justify-center py-8"
          >
            <VProgressCircular
              indeterminate
              color="primary"
            />
          </div>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
