<template>

        <!-- Answer && Question;finally together -->
        <div class="d-flex flex-column  media-left vote-controls">

            <a @click.prevent='voteUp'
            :title='title("up")' class='vote-up' :class='classes'>
                <i class='fas fa-caret-up fa-2x'></i>
            </a>

            <span class='votes-count'>{{ realVotes }}</span>

            <a @click.prevent='voteDown'
            :title='title("down")' class='vote-down' :class='classes'>
                <i class='fas fa-caret-down fa-2x'></i>
            </a>

            <accept  v-if="name==='answer'" :answer='model'></accept>
             <favorite v-if="name==='question'" :question='model'></favorite>

        </div>

</template>

<script>
    export default {
        props: ['name', 'model'],

        data(){
            return {
                realVotes: this.model.real_votes,
                id: this.model.id
            }
        },

        computed: {

            classes() {
                return this.signedIn ? '' : 'off';
            }

        },

        methods: {

            title(voteType){
                let titles = {
                    up: `This ${this.name} is useful`,
                    down: `This ${this.name} is USELESS`
                }

                return titles[voteType];
            },

            voteUp(){
                return this._vote(1);
            },
            voteDown(){
                return this._vote(-1);
            },

            _vote(vote){
                if (!this.signedIn){

                    this.$toast.warning(`Please log in to vote this ${this.name}`, 'Warning', {
                        timeout:3500,
                        position:'bottomLeft'
                    });
                    return;

                }

                axios.post(`/${this.name}s/${this.id}/vote`,{
                    vote:vote
                })
                .then(res => {
                    if(res.data.repeated === 0){
                        this.$toast.success(res.data.message, 'Success', {
                        timeout:3000,
                        position: 'bottomLeft'
                        });
                        this.realVotes = res.data.votes;

                    }else{
                        this.$toast.warning(res.data.message, 'Warning', {
                        timeout:3000,
                        position: 'bottomLeft'
                        });
                    }
                })
            }



        }
    }
</script>
