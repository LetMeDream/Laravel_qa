
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

