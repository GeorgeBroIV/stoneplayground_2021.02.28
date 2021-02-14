<template>
	<app-layout>
		<div>
			<!-- Body -->
			<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
				<div align="center">
					<jet-application-logo class="inline-flex" />
				</div>
				<div align="center" class="mt-4 text-2xl middle">
					Welcome to Stone Playground!
				</div>
				<div align="center" class="mt-6 text-gray-500 text-xl">
					This website is not yet optmimized for mobile and smaller devices, and is best viewed on a computer.
				</div>
				<div class="mt-6 text-gray-800">
					Once complete this web application will host a fully functioning online multi-player canasta card
					game that is similar in feel to Yahoo's (now decommissioned) Canasta game site.
					<br><br>
					We will first develop a chatroom and message board for friends and new players to chat and post
					messages.&nbsp; Next we will develop the game lobbies which will have their own chat section and
					show the card tables.  Later we will develop the actual game tables for 2 and 4 player canasta
					games, similar in style the Yahoo Canasta card tables that we grew to know and love.
					<br><br>
					Future developments may include rated and non-rated games, multiple id's with id-specific
					avatars and ratings, table kibitzing, the ability to go invisibile, ability to block chat
					messages from bothersome players, ability to create public or private tables, game leagues, etc
					.&nbsp; Once this is complete and operational, other card games may follow depending on player
					interest.
					<br><br>
					A lot of functionality will come from ideas and suggestions from people like you!&nbsp;
					So if you have any thoughts please post a message on the 'Features Wish List' message board once
					this is available.
				</div>
			</div>

			<!-- Laravel Content -->
			<Welcome />

		</div>
	</app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo'
    import Welcome from '@/Jetstream/Welcome'

    export default {
      components: {
	      AppLayout,
	      JetApplicationLogo,
	      Welcome,
      }
    }
</script>
