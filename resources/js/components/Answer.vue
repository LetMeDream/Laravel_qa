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
                                            <a v-if='authorize("modify", answer)' v-on:click.prevent='edit'  class='btn btn-sm btn-outline-info'>Edit</a>
                                        <!-- Ajaxifying delete functionality -->
                                            <button v-if='authorize("delete", answer)' v-on:click.prevent=" destroy " class='btn btn-outline-danger btn-sm' >Delete</button>
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
export default {
    props: ['answer'],

    data (){
        return {
            editing: false,
            body: this.answer.body,
            body_html: this.answer.body_html,
            id: this.answer.id,
            questionId: this.answer.question_id,
            /** Holding answer body before editing */
            body_cache: null,

        }
    },

    methods:{
        edit(){
            this.editing = true;
            this.body_cache = this.body;
        },
        cancel(){

            this.editing = false;
            this.body = this.body_cache;

        },
        update () {

            /** Ajax request using AXIOS */
            axios.put(this.endpoint,{
                body: this.body
            })
            .then(res => { /** Promise */
                console.log(res);
                this.editing = false;
                this.body_html = res.data.body_html;
                /** Alerting using iziToast */
                this.$toast.success(res.data.message, { timeout: 3000 });
            })
            .catch(err => {
                /** Alerting using iziToast */
                this.$toast.success('Answer updated', 'Success', { timeout: 3000 });
            })

        },

        destroy()
        {
            this.$toast.question('Are you sure about that?', 'Confirm',{
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
                        $(this.$el).fadeOut(550, () => {
                                /** Alerting using iziToast */
                                this.$toast.success(res.data.message, { timeout: 3000 });
                        })

                });


                $(this.$el).fadeOut(550, () => {
                                /** Alerting using iziToast */
                                this.$toast.success('Answer deleted', 'Success', { timeout: 3000 });
                });

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                }, true],
                ['<button>NO</button>', function (instance, toast) {

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                }],
            ],

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

