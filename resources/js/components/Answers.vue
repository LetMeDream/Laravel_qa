<template>

    <div class="">

        <div class="row mt-4">

            <div class="col-md-12">

                <div class="card" v-cloak v-if='count > 0' >

                        <div class="card-header"> <!-- v-cloak is for this instance to wait until other have loaded completely. -->

                            <div class="card-title">
                                <h2> {{title}} </h2>
                            </div>

                        </div>

                        <div class="card-body">

                            <answer @deleted='remove(index)' v-for="(answer, index) in answers" :answer='answer' :key='answer.id'></answer>

                            <div v-if='nextUrl' v-on:click='fetch(nextUrl)'
                            class='text-center mt-3'>

                                <button class='btn btn-outline-secondary'>Load More Answers</button>

                            </div>

                        </div>



                </div>

            </div>

        </div>

        <newAnswer @created='add' :question='question'></newAnswer>

    </div>

</template>

<script>
/** Importing components that are always gonna be ONLY inside this component */
import answer from './Answer.vue';
import newAnswer from './NewAnswer';
/** Event bus */
import eventBus from '../event-bus';

export default {

    props: ['question'],

    data(){
        return{
            questionId: this.question.id,
            count: this.question.answers_count,
            answers: [],
            nextUrl: null
        }
    },

    /** This method is automatically self-called by VUE whenever a new component is instanciated
     *  This is generally used for fetching data from a backend API.
    */
    created(){
        this.fetch(`/questions/${this.questionId}/answers`);

    },

    methods:{
        fetch(endpoint){
            axios.get(endpoint)
            .then(({data}) => { /** This is called object distructing operator, or so it seems. */
                this.answers.push(...data.data); /** The '... operator ' is called Rest or Spread operator (Spread, for this case) */
                console.log(data.next_page_rul)
                this.nextUrl = data.next_page_url;
            })
            .catch(err => {
                console.error(err);
            })
        },

        remove(index){

            this.answers.splice(index,1);
            this.count--;

        },

        add(answer){

            this.answers.push(answer);
            this.count++;

        }
    },



    computed: {

        title(){
            return this.count + ' ' + (this.count === 0 || this.count > 1 ? 'answers' : 'answer');
        }

    },

    /** Since we are importing other Components, (instead of registering them at app.js),
     * we must call them in 'components' property.
     */
    components: {answer, newAnswer}

}
</script>
