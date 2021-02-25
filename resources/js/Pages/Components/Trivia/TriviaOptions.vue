<template>
	<!-- Trivia Options -->
	<div id="triviaOptions" :style="{ visibility: this.setVisibility }">

		<div id="divTriviaGameOptionsHeader" class="text-2xl mb-3">
			Trivia Game Options
		</div>

		<div class="bg-gray-100 -ml-5 mr-5 pl-4 rounded-2xl shadow-xl">
			<div class="pt-3 pl-1">
				Trivia Category
			</div>

			<select
				id="category"
				v-model="iCategory"
				@change="$emit('eSelectedValue', $event.target)"
				class="mb-3">
				<option
					v-for="category in this.aTriviaCategories"
					:value="category.id">
					{{ category.name }}
				</option>
			</select>

			<div>
				<div class="pl-1">
					Criteria: Difficulty
				</div>
				<select
					id="difficulty"
					v-model="sDifficulty"
					@change="$emit('eSelectedValue', $event.target)"
					class="mb-3">
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
				<select
					id="type"
					v-model="sType"
					@change="$emit('eSelectedValue', $event.target)"
					class="mb-3">
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
				<select
					id="amount"
					v-model="iAmount"
					@change="$emit('eSelectedValue', $event.target)"
					class="mb-3 w-auto">
					<option
						v-for="amount in this.iAmtMax"
						:value="amount">
						{{ amount }}
					</option>
				</select>
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
	data() {
		return {
			iAmount: this.iSelectedAmount,
			iCategory: this.iSelectedCategory,
			sDifficulty: this.sSelectedDifficulty,
			sType: this.sSelectedType,
			setVisibility: 'hidden',
		}
	},
	methods: {
		mResetVars() {
			this.$emit('eResetVars');
			this.iAmount = 0;
			this.iCategory = 0;
			this.sDifficulty = '';
			this.sType = '';
		}
	},
	props: {
		aTriviaCategories: Array,
		bError: Boolean,
		bLoadFail: Boolean,
		bLoading: Boolean,
		iAmtMax: Number,
		iSelectedCategory: Number,
		iSelectedAmount: Number,
		oTriviaDifficulties: Object,
		oTriviaTypes: Object,
		sSelectedDifficulty: String,
		sSelectedType: String,
	},
	setVisibility: {
		immediate: true,
		handler() {
			this.setVisibility = this.setVisibility;
		}
	},
	watch: {
		iAmount: {
			immediate: true,
			handler() {
				this.iAmount = this.iSelectedAmount;
			}
		},
		iCategory: {
			immediate: true,
			handler() {
				this.iCategory = this.iSelectedCategory;
			}
		},
		sDifficulty: {
			immediate: true,
			handler() {
				this.sDifficulty = this.sSelectedDifficulty;
			}
		},
		sType: {
			immediate: true,
			handler() {
				this.sType = this.sSelectedType;
			}
		},
	},
	mounted () {
		this.setVisibility = 'visible'
	},
	emits: [
		'eSelectedValue',
		'eResetVars',
	],
}
</script>