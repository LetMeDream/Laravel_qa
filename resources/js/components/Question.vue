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
                                <textarea required rows="10" v-model='body' class='form-control'></textarea>
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
                                <div v-html='bodyHtml'></div>
                            </div>
                            <div class="row">
                                    <div class="col-4">
                                        <!-- Delete and updte stuff -->
                                        <div class='float-left'>
                                            <button v-if='authorize("modify", question)' @click.prevent='edit'  class='btn btn-sm btn-outline-info'>Edit</button>
                                        <!-- Ajaxifying delete functionality -->
                                            <button v-if='authorize("modify", question)' @click.prevent=" destroy " class='btn btn-outline-danger btn-sm' >Delete</button>
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

                                <!-- <div class="votes">
                                    <strong>
                                        {{ $question->real_votes }}
                                    </strong>
                                    {{ Str::plural('vote', $question->real_votes) }}
                                </div>
                                <div class="status {{ $question->status }} ">
                                        <strong>
                                            {{ $question->answers_count }}
                                        </strong>
                                        {{ Str::plural('answer', $question->answers_count) }}
                                </div>
                                <div class="views">

                                    {{ $question->views . ' ' . Str::plural('view', $question->views) }}
                                </div> -->
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {

    props:['question'],

    data(){
        return{
            title: this.question.title,
            body: this.question.body,
            bodyHtml: this.question.body_html,
            editing: false,
            id: this.question.id,
            beforeEditCache: {}
        }
    },

    computed: {

        isInvalid(){

            return this.body.length < 10 || this.title.length < 10;

        },

        endpoint(){

            return `/questions/${this.id}`;

        }

    },

    methods:{

        edit(){
            this.beforeEditCache = {
                body : this.body,
                title: this.title,
            }

            this.editing = true;

        },

        cancel() {
            this.body = this.beforeEditCache.body;
            this.title = this.beforeEditCache.title;

            this.editing = false;
        },

        update(){

            axios.put(this.endpoint,{
                body : this.body,
                title : this.title
            })
            .then(res => {
                console.log(res);
                this.$toast.success(data.message, "Success", {
                    timeout: 3000
                })
                this.editing = false;
            })
            .catch(err => {
                console.error(err);
            })

        },

        destroy(){

            this.$toast.question('Are you sure about deleting this question?', 'Confirm',{
            timeout: 20000,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 999,
            title: 'Hey',
            message: 'Are you sure about that?',
            position: 'center',
            buttons: [
                        ['<button><b>YES</b></button>', (instance, toast) => {

                        axios.delete(this.endpoint,{

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

                        /* $(this.$el).fadeOut(550, () => {
                                        this.$toast.success('Answer deleted', 'Success', { timeout: 3000 });
                        }); */

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ],

            });

        }


    }

}
</script>
