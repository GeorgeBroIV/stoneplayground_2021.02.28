<template>
    <div class="font-sans text-gray-900 antialiased">
        <div class="py-5 bg-gray-100">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
              <!-- Logo -->
              <div class="flex-shrink-0 flex items-center">
                <inertia-link :href="route('home')">
                  <jet-application-logo class="block h-9 w-auto" />
                </inertia-link>
              </div>
	          <!-- Body -->
              <div v-html="terms" class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
              </div>
            </div>
        </div>
    </div>
</template>

<script>

import JetApplicationLogo from '@/Jetstream/ApplicationLogo';

export default {
    props: ['terms'],

    components: {
        JetApplicationLogo,
    },
}
</script>