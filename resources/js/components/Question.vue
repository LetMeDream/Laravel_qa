<template>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">

                            <div>
                                    <h1>{{ title }}</h1>
                            </div>
                            <div class="ml-auto">

                                <a href='/questions' class='btn btn-outline-secondary'>Back to all questions</a>

                            </div>

                    </div>


                </div>
                <!-- Editing -->
                <form v-if='editing' @submit.prevent='update' class="card-body">

                    <div class="card-title">

                        <input type="text" class='form-control form-control-lg' v-model='title'>

                    </div>

                    <div class="media">

                        <div class="media-body">
                            <div class="form-group">
                                <m-editor :body='body' >
                                    <textarea required rows="10" v-model='body' class='form-control'></textarea>
                                </m-editor>
                            </div>
                            <button type='submit' :disabled='isInvalid'  class='btn btn-outline-primary'>Update</button>
                            <button @click.prevent=' cancel '    class='btn btn-outline-secondary'>Cancel</button>
                        </div>

                    </div>

                </form>
                <!-- Editing -->

                <div v-else  class="card-body">

                    <div class='media'>
                        <!-- Vote controls -->

                            <vote name="question" :model='question'></vote>


                        <!-- Vote controls -->


                        <div class="media-body">
                            <div>
                                <div v-html='body_html'></div>
                            </div>
                            <div class="row">
                                    <div class="col-4">
                                        <!-- Delete and updte stuff -->
                                        <div class='float-left'>
                                            <button v-if='authorize("modify", question)' @click.prevent='edit'  class='btn btn-sm btn-outline-info'>Edit</button>
                                        <!-- Ajaxifying delete functionality -->
                                            <button v-if='authorize("deleteQuestion", question)' @click.prevent=" destroy " class='btn btn-outline-danger btn-sm' >Delete</button>
                                        </div>
                                        <!-- Delete and updte stuff -->
                                    </div>
                                    <div class="col-5"></div>
                                    <div class="col-3">
                                        <user-info :model='question' label='Asked'></user-info>
                                    </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column counters media-right">

                                <div class="votes">
                                    <strong>
                                        {{ votes }}
                                    </strong>
                                    {{ votes_count }}
                                </div>
                                <div :class='classes'>
                                        <strong>
                                            {{ answers }}
                                        </strong>
                                            {{ answers_count }}
                                </div>
                                <div class="views">

                                   <!--  {{ question.views }} -->
                                </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
import Vote from './Vote';
import UserInfo from './UserInfo';
import MEditor from './MEditor';
/** Mixin */
import mixinQA from '../mixins/mixinQA';
/** Event bus */
import eventBus from '../event-bus';

export default {

    props:['question'],

    mixins:[mixinQA],

    components: { Vote, UserInfo, MEditor },

    data(){
        return{
            /** Editing ain't here cause it comes from our Mixin */
            title: this.question.title,
            body: this.question.body,
            body_html: this.question.body_html,
            id: this.question.id,
            beforeEditCache: {},
            votes: this.question.real_votes,
            answers: this.question.answers_count,
            accepted: null

        }
    },

    computed: {
        classes(){

            return ['status',
                this.question.best_answer_id ? 'answered-accepted' : 'answered',
                this.accepted ? 'answered-accepted' : '',
            ]

        },

        answers_count(){

            return (this.answers > 1 || this.answers === 0) ? 'answers' : 'answer';

        },

        votes_count(){

            return (this.votes > 1 || this.votes === 0) ? 'votes' : 'vote';

        },

        isInvalid(){

            return this.body.length < 10 || this.title.length < 10;

        },

        endpoint(){

            return `/questions/${this.id}`;

        }

    },

    created(){

        eventBus.$on('accepted', () =>{
            this.accepted = 1;
        });
        eventBus.$on('unaccepted', () =>{
            this.accepted = null;
        });

    },


    methods:{

        setEditCache(){
            this.beforeEditCache = {
                body : this.body,
                title: this.title,
            }
        },

        restoreFromCache() {
            this.body = this.beforeEditCache.body;
            this.title = this.beforeEditCache.title;

        },

        payload(){

            return {
                body : this.body,
                title : this.title
            }

        },

        delete(){

            return axios.delete(this.endpoint,{

                        })
                        .then(res => {
                            this.$toast.success('Questions successfully deleted', 'Success',{
                                timeout: 2000
                            });
                            setTimeout(()=>{
                                window.location.href = '/questions'
                                },3000)


                        })
                        .catch(err=>{
                            alert(err.message);
                        });

        }


    }

}
</script>
