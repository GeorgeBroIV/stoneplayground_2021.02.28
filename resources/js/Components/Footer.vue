<template #footer>
	<div class="max-w-7xl mx-auto my-0 py-3 sm:px-6 lg:px-8">
		<div class="flex py-3 bg-white overflow-hidden shadow-xl sm:rounded-lg">
			<div class="text-gray-400 ml-7">
				&copy; 2021 StonePlayground.com | All rights reserved
			</div>
			<div class="text-gray-400 ml-7">
				<inertia-link :href="route('terms.show')">
					Terms of Service
				</inertia-link>
			</div>
			<div class="text-gray-400 ml-7">
				<inertia-link :href="route('policy.show')">
					Privacy Policy
				</inertia-link>
			</div>
		</div>
	</div>
</template>