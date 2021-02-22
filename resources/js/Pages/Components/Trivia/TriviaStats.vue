<template>
	<div>
		<div class="text-2xl">
			Trivia Stats
		</div>

		<div id="divCurrentGameStats" v-if="this.bTriviaActive">
			<div class="mt-3 mb-1 font-bold">
				Current Game Stats
			</div>
			<div class="mt-2 text-gray-500">
				Question {{ this.iCurrentQuestionDisplay }} of {{ this.iTotalQuestions }}
			</div>
			<div class="mt-2 text-gray-500">
				Correct Answers: {{ this.iCorrect }}
			</div>
		</div>

		<div id="divOverallGameStats">
			<div class="mt-3 mb-1 font-bold">
				Overall Game Stats
			</div>
			<div class="mt-2 text-gray-500">
				Games Played: {{ this.iGlobalGames }}
			</div>
			<div class="mt-2 text-gray-500">
				Questions Answered: {{ this.iGlobalQuestions }}
			</div>
			<div class="mt-2 text-gray-500">
				Correct Answers: {{ this.iGlobalCorrect }}
			</div>							<!-- Game Stats -->
			<div class="mt-3 mb-1 font-bold">
				Open Trivia Database
			</div>
			<div class="mt-2 text-gray-500">
				Trivia Categories: {{ this.iCategories }}
			</div>
			<div class="mt-2 text-gray-500">
				Verified Questions: {{ this.sTotalVerifiedQuestions }}
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: "TriviaStats",
		data() {
			return {
				iCategories: 0,
				sUrlTriviaAPIStats: 'https://opentdb.com/api_count_global.php',
			}
		},
		mounted() {
			this.mGetData(this.sUrlTriviaAPIStats)
			this.iCategories = Object.keys(this.oTriviaCategories).length
		},
		props: {
			bTriviaActive: Boolean,
			iCorrect: Number,
			iCurrentQuestionDisplay: Number,
			iGlobalCorrect: Number,
			iGlobalGames: Number,
			iGlobalQuestions: Number,
			iTotalQuestions: Number,
			mGetData: Function,
			oTriviaCategories: Object,
			sTotalVerifiedQuestions: String,
		},
	}
</script>