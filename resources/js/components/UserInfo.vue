<template>

    <div class="">

        <span class='text-muted'>{{ postDate }}</span>
        <div class="media mt-1">
            <a :href='user.url' class='pr-2' >
                <img :src='user.avatar '>
            </a>
            <div class="media-body mt-1">
                <a :href='user.url' class='pr-2' >

                        {{ user.name }}
                </a>
            </div>

        </div>


    </div>

</template>

<script>
    export default {
        /** 1) We need a props */
        props: ['model', 'label'],
        /** 2) Here we will need some computed data */
        computed: {
            postDate(){
                return this.label + ' ' + this.model.created_date
            }
        },
        /** 3) Components states; stored in data method */
        data () {
            return {

                user: this.model.user,

            }
        }

    }
    console.log("I'm been read");
</script>

