<template>

    <div>

            <a v-if="canAccept" title='Mark this as best answer'
                @click.prevent = 'create'
                :class='classes'>
                <i class='fas fa-check fa-2x'></i>
            </a>


            <!-- <a v-if='accepted' title='The question owner accepted this answer as the BEST'
                :class='classes'>
                <i class='fas fa-check fa-2x'></i>
            </a> -->



    </div>

</template>

<script>
import eventBus from '../event-bus';
export default {


    props: ['answer'],

    data (){
        return {
            isBest: this.answer.is_best,
            id: this.answer.id,
            bestAnswerId : this.answer.question.best_answer_id
        }
    },

    computed: {

        /** hardcoding, for now, the authorization logic */
        canAccept() {
            return this.authorize('accept', this.answer);
        },

        accepted() {
            return !this.canAccept && this.isBest;
        },

        classes() {

            return ['mt-2',
                this.isBest ? 'vote-accepted' : 'vote-accept'
            ]

        }

    },

    created(){

        eventBus.$on('accepted', id =>{

            this.isBest = (id === this.id);

        }),
        eventBus.$on('unaccepted', id =>{

            this.isBest = false;

        })

    },

    methods: {

        create() {

            axios.post(`/answers/${this.id}/accept`)
            .then(res => {
                console.log(res);
                this.$toast.success(res.data.message, "Success", {
                    timeout:3500,
                    position: 'bottomLeft'
                });
                this.isBest = !this.isBest;


                /** Lets emit an events using event bus  */
                if(res.data.favorite){
                    eventBus.$emit('accepted', this.id);
                }else{
                    eventBus.$emit('unaccepted', this.id);
                }


            })
            .catch(err => {
                console.error(err);
            })

        }

    }
}
</script>