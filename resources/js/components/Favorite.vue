<template>
    <div class="root"><a
        title='Click to mark as favorite (click again to undo)' :class='classes'
        @click.prevent= 'favorite' >
            <i class='fas fa-star fa-2x'></i>
        </a>
        <span class='favorites-count'>{{count}}</span>

    </div>

</template>
<script>

    export default{
        /** Prosp; Array that contains just 'main' properties, passed as Html tags */
        props: ['question'],
        /** Data; here it returns and object with props's derived properties and needed boolean */
        data() {
            return {
                count: this.question.isFavoritedCount,
                beenFavorited: this.question.beenFavorited,
                id: this.question.id,
            }
        },
        /** Computed; returns object with functions for variables that require any complex logic. */
        computed: {

            classes(){
                return [ 'favorite', 'mt-2',
                        ! this.signedIn ? 'off' : (this.beenFavorited ? 'favorited' : "")
                ]
            },

            endpoint(){
                return `/question/${this.id}/favorite`;
            },

            signedIn(){
                return window.Auth.signedIn;
            }

        },
        /** Methods and http requests */
        methods: {

            favorite () {

                if (!this.signedIn){

                    this.$toast.warning('Please log in to favorite this question', 'Warning', {
                        timeout:3500,
                        position:'bottomLeft'
                    });
                    return;

                }

                axios.post(`/question/${this.id}/favorite`)
                .then(res => {
                    console.log(res);

                    if(res.data.favorit===0){
                        this.count--;
                        this.beenFavorited=false;
                    } else {
                        this.count++;
                        this.beenFavorited=true;
                    }

                })


            }

        }



    }

</script>

