<template>

    <div class="row mt-4">

            <div class="col-md-12">

                <div class="card" v-cloak v-if='count > 0' >

                        <div class="card-header"> <!-- v-cloak is for this instance to wait until other have loaded completely. -->

                            <div class="card-title">
                                <h2> {{title}} </h2>
                            </div>

                        </div>

                        <div class="card-body">

                            <answer v-for="answer in answers" :answer='answer' :key='answer.id'></answer>

                        </div>



                </div>

            </div>

    </div>

</template>

<script>
import answer from './Answer.vue';

export default {

    props: ['answers', 'count'],

    computed: {

        title(){

            return this.count + ' ' + (this.count > 0 ? 'answers' : 'answer');
        }

    },

    components: {answer}

}
</script>
