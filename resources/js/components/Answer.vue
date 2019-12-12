<template>

    <div class="media post mt-2">
                <!-- Vote controls -->
                    <vote name='answer' :model='answer' ></vote>
                <!-- Vote controls -->
                <div class="media-body">
                    <form v-if='editing' @submit.prevent = " update " >

                        <div class="form-group">
                            <textarea required rows="10" v-model='body' class='form-control'></textarea>
                        </div>
                        <button type='submit' :disabled='isInvalid'  class='btn btn-outline-primary'>Update</button>
                        <button v-on:click.prevent=' cancel '    class='btn btn-outline-secondary'>Cancel</button>

                    </form>

                    <div v-else>
                        <div v-html='body_html'></div>

                        <div class="row">
                            <div class="col-4">
                                <!-- Delete and updte stuff -->
                                <div class='float-left'>
                                            <a v-if='authorize("modify", answer)' @click.prevent='edit'  class='btn btn-sm btn-outline-info'>Edit</a>
                                        <!-- Ajaxifying delete functionality -->
                                            <button v-if='authorize("delete", answer)' @click.prevent=" destroy " class='btn btn-outline-danger btn-sm' >Delete</button>
                                </div>
                                <!-- Delete and updte stuff -->
                            </div>
                            <div class="col-5"></div>
                            <div class="col-3">
                                <user-info :model='answer' label='Answered'></user-info>
                            </div>
                        </div>
                    </div>

                </div>
        </div>

</template>

<script>
import Vote from './Vote';
import UserInfo from './UserInfo';
/** Mixin */
import mixinQA from '../mixins/mixinQA';


export default {
    props: ['answer'],

    mixins: [mixinQA],

    components: { Vote, UserInfo },

    data (){
        return {
            /** Editing defined in mixin */
            body: this.answer.body,
            body_html: this.answer.body_html,
            id: this.answer.id,
            questionId: this.answer.question_id,
            /** Holding answer body before editing */
            body_cache: null,

        }
    },

    methods:{
        setEditCache(){
            this.body_cache = this.body;
        },
        restoreFromCache(){
            this.body = this.body_cache;
        },
        payload(){
            return {
                body: this.body
            }
        },

        delete(){
            return axios.delete(this.endpoint,{})
                        .then(res => {
                            /** Here we will use a custom event; that's because Custom events can be called from child components (Answer.vue) and
                             *  listened to by parent components (Answers.vue). */
                            this.$emit('deleted');
                            this.$toast.success('Answer successfully deleted', 'Success',{
                                timeout: 2000
                            });
                    });
        }
    },

    computed: {

        isInvalid(){
            return this.body.length < 10;
        },

        endpoint(){
            return `/questions/${this.questionId}/answers/${this.id}`
        }

    }

}
</script>

