<template>
    <div>
        <jet-banner />

        <div class="min-h-screen bg-gray-100">
          <div class="sticky">
            <Nav />

            <!-- Page Heading -->
            <div class="bg-blue-50 shadow py-1"></div>
          </div>

            <!-- Page Content -->
            <main>
	            <div class="max-w-7xl mx-auto pt-3 sm:px-6 lg:px-8">
		            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <slot></slot>
		            </div>
	            </div>
            </main>

          <!-- Page Footer -->
          <Footer />
            <!-- Modal Portal -->
            <portal-target name="modal" multiple>
            </portal-target>
        </div>
    </div>
</template>

<script>
    import JetBanner from '@/Jetstream/Banner'
    import Nav from '@/Components/Nav'
    import Footer from '@/Components/Footer'

    export default {
        components: {
            JetBanner,
	          Nav,
	          Footer,
        }
    }
</script>