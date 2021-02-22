<template>
	<!-- Trivia Options -->
	<div id="triviaOptions">

		<div id="divTriviaGameOptionsHeader" class="text-2xl mb-3">
			Trivia Game Options
		</div>

		<div class="bg-gray-100 -ml-5 mr-5 pl-4 rounded-2xl shadow-xl">
			<div class="pt-3 pl-1">
				Trivia Category
			</div>

			<select v-model="this.iSelectedCategory" class="mb-3">
				<option
					v-for="(category, index) in this.oTriviaCategories"
					:value="index">
					{{ category }}
				</option>
			</select>

			<div>
				<div class="pl-1">
					Criteria: Difficulty
				</div>
				<select v-model="this.sSelectedDifficulty" class="mb-3">
					<option
						v-for="(difficulty, index) in this.oTriviaDifficulties"
						:value="index">
						{{ difficulty }}
					</option>
				</select>
			</div>

			<div>
				<div class="pl-1">
					Criteria: Answer Type
				</div>
				<select v-model="this.sSelectedType" class="mb-3">
					<option
						v-for="(type, index) in this.oTriviaTypes"
						:value="index">
						{{ type }}
					</option>
				</select>
			</div>

			<div>
				<div class="pl-1">
					Criteria: Questions
				</div>
				<b-select v-model="this.iSelectedAmount" class="mb-3 w-auto">
					<option v-for="amount in this.iAmtMax">
						{{ amount }}
					</option>
				</b-select>
			</div>

			<div align="center" v-if="this.bLoading" class="mt-0 mb-3 py-2 text-gray-700 bg-blue-100 w-auto">
				<div class="mb-2 h5">
					Loading...
				</div>

			</div>

			<div v-if="this.bLoadFail">
				<div align="center"class="mt-0 mb-3 py-2 text-gray-700 bg-blue-100 w-auto">
					<div class="mb-2 h5">
						Sorry, unable to load your selection.
					</div>
					<div>
						Try adjusting the Criteria (e.g. less Questions)
					</div>
				</div>
				<div class="mt-3">
					<b-button @click="this.mResetVars" variant="primary">
						Reset Criteria
					</b-button>
				</div>
			</div>

			<div v-if="this.bError">
				<div align="center"class="mt-0 mb-3 py-2 text-gray-700 bg-blue-100 w-auto">
					<div class="mb-2 h5">
						Sorry, an error occurred.
					</div>
					<div>
						Please reset and try again.
					</div>
				</div>
				<div class="mt-3">
					<b-button @click="this.mResetVars" variant="primary">
						Reset Criteria
					</b-button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'TriviaOptions',
	props: {
		bError: Boolean,
		bLoadFail: Boolean,
		bLoading: Boolean,
		iAmtMax: Number,
		iSelectedAmount: Number,
		iSelectedCategory: Number,
		mResetVars: Function,
		oTriviaCategories: Object,
		oTriviaDifficulties: Object,
		oTriviaTypes: Object,
		sSelectedDifficulty: String,
		sSelectedType: String,
	},
}
</script>

<style scoped>

</style>