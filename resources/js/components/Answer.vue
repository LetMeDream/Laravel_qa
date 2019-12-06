
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
                alert(res.data.message);
            })
            .catch(err => {
                /* console.error(err); */
                alert(err.response.data.message);
            })

        },

        destroy()
        {
            if(confirm('Do you really want to do this?') ){

                axios.delete(this.endpoint,{

                })
                .then(res => {
                        $(this.$el).fadeOut(550, () => {
                                alert(res.data.message)
                        })

                })


                $(this.$el).fadeOut(550, () => {
                                alert('Your answer has been deleted');
                })

            }
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

