import type { VerticalNavItems } from '@layouts/types'

export default [
  {
    title: 'Главная',
    icon: { icon: 'tabler-smart-home' },
    to: 'dashboards-crm',
  },
  {
    title: 'Профиль',
    icon: { icon: 'tabler-user' },
    to: { name: 'pages-user-profile-tab', params: { tab: 'profile' } },
  },
  {
    title: 'Настройки',
    icon: { icon: 'tabler-settings' },
    to: { name: 'pages-account-settings-tab', params: { tab: 'account' } },
  },
] as VerticalNavItems
