<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <welcome />
                </div>
            </div>
        </div>
      <template #footer>
        <div class="flex">
          <div class="text-gray-400 ml-7">
            &copy; 2021 StonePlayground.com | All rights reserved
          </div>
          <div class="text-gray-400 ml-7">
            <inertia-link :href="'/terms-of-service'">
              Terms of Service
            </inertia-link>
          </div>
          <div class="text-gray-400 ml-7">
            <inertia-link :href="'/privacy-policy'">
              Privacy Policy
            </inertia-link>
          </div>
        </div>
      </template>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'

    export default {
        components: {
            AppLayout,
            Welcome,
        },
    }
</script>
