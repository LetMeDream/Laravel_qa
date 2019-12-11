<template>

    <div class="row mt-4">

        <div class="col-md-12">

            <div class="card">

                <div class="card-header">

                    <div class="card-title">
                        <h3>Your answer</h3>
                    </div>

                </div>

                <div class="card-body">

                    <form @submit.prevent='create'>
                        <div class="form-group">

                            <textarea name='body' rows='7' class='form-control' v-model='body'></textarea>

                        </div>
                        <div class="form-group">

                            <button :disabled='isInvalid' class='btn btn-lg btn-outline-secondary' type='submit' >Submit</button>

                        </div>

                    </form>

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
                body: '',
                questionId: this.question.id
            }
        },

        computed: {

            isInvalid(){
                if(!this.signedIn || this.body.length < 10 ){
                    return true;
                } else {
                    return false;
                }
            }

        },

        methods:{

            create(){

                axios.post(`/questions/${this.questionId}/answers`,{
                    body: this.body
                })
                .catch(err => {
                    this.$toast.error(error.response.data.message, 'Error');
                })
                .then( ({data} ) => {
                    this.$toast.success(data.message, 'Success');

                    this.body = '';
                    /** In order for this answer to be added, we will need to pass it to its parent component (Answers). 
                     * We will do that with a custom event. */
                    this.$emit('created', data.answer);

                })

            }

        },

    }

</script>