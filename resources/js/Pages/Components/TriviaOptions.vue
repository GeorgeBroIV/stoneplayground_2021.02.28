<template>
  <div>
    <div>
      Trivia Category
    </div>
    <select v-model="selectedCategory" class="mb-3">
      <option
          v-for="(category, index) in this.triviaCategories"
          :value="index">
        {{ category }}
      </option>
    </select>

    <div>
      <div>
        Difficulty
      </div>
      <select v-model="selectedDifficulty" class="mb-3">
        <option
            v-for="(difficulty, index) in this.triviaDifficulties"
            :value="index">
          {{ difficulty }}
        </option>
      </select>
    </div>

    <div>
      <div>
        Answer Type
      </div>
      <select v-model="selectedType" class="mb-3">
        <option
            v-for="(type, index) in this.triviaTypes"
            :value="index">
          {{ type }}
        </option>
      </select>
    </div>

    <div>
      <div>
        Questions
      </div>
      <b-select v-model="selectedAmount" class="mb-3">
        <option v-for="amount in this.amtMax">
          {{ amount }}
        </option>
      </b-select>
    </div>

    <div class="mt-6">
      <b-button @click="startSurvey" variant="primary">
        Start Trivia
      </b-button>
    </div>
  </div>
</template>
<script>

	import Inertia from '@inertiajs/inertia';

	export default {
		components: {
			Inertia
		},
		props: {
			triviaCategories: Object,
			triviaDifficulties: Object,
			triviaTypes: Object,
			numTotalQuestions: Number,
			questions: Array,
//			triviaActive: Boolean,
//			loading: Boolean,
		},
		data() {
			return {
				selectedCategory: 0,
				selectedDifficulty: "any",
				selectedType: "any",
				selectedAmount: 10,
				amtMax: 50,
			}
		},
		methods: {
			newTrivia() {
				this.selectedCategory = 0;
				this.selectedDifficulty = "any";
				this.selectedType = "any";
				this.selectedAmount = 10;
				this.numTotalQuestions = 0;
				this.startSurvey();
			},
			startSurvey() {
				let urlCategory = this.selectedCategory === '0' ? '' : '&category=' + this.selectedCategory;
				let urlDifficulty = this.selectedDifficulty === 'any' ? '' : '&difficulty=' + this.selectedDifficulty;
				let urlType = this.selectedType === 'any' ? '' : '&type=' + this.selectedType;
				let urlTrivia = 'https://opentdb.com/api.php?amount=' + this.selectedAmount + urlCategory + urlDifficulty + urlType;
//				this.loading = true;
				this.$inertia.get(urlTrivia)
					.then(response => {
						return response.json()
					})
					.then(jsonData => {
						this.questions = jsonData.results
						this.numTotalQuestions = jsonData.results.length
//						this.loading = false
					});
				//    let loaded=this.callFetch(urlTrivia);
//				this.triviaActive = !this.triviaActive
			},
//			    async callFetch(urlTrivia) {
//			      let response = await Promise.resolve(fetch(urlTrivia, {method: 'get'}))
//			      .then(response => {return response.json()})
//			      .then(jsonData => {
//			        this.questions = jsonData.results
//			        this.numTotalQuestions = jsonData.results.length
//			      })
//			    }
		}
	}
</script>