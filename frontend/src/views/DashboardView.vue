<template>
  <DashboardHeader />
  <DashboardAsides />
  <DashboardMain />
</template>

<script>
// @ is an alias to /src
import DashboardHeader from '@/components/DashboardHeader.vue'
import DashboardAsides from '@/components/DashboardAside.vue'
import DashboardMain from '@/components/DashboardMain.vue'

export default {
  name: 'DashboardView',
  components: {
    DashboardHeader,
    DashboardAsides,
    DashboardMain
  }
}
</script>