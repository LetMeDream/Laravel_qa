<template>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle='tab' :href="tabId('write','#' )">Write</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle='tab' :href="tabId('preview', '#')">Preview</a>
                </li>
            </ul>
        </div>
        <div class="card-body tab-content">
            <!-- Slot is a VueJs special tag that serves as placeholder for a value passed from a parent component  -->
            <div class="tab-pane active" :id="tabId('write')">
                <slot></slot>
            </div>
            <div class="tab-pane" :id="tabId('preview')" v-html='preview'>
                <div></div>
            </div>



        </div>
    </div>
</template>

<script>
/** Importing markdown-it package and prism package */
import MarkdownIt from 'markdown-it';
import prism from 'markdown-it-prism';
/** And autosize package */
import autosize from 'autosize';
/** Then define a variable to hold the markdown-it instance */
const md = new MarkdownIt();
/** integrating prism with markdown-it */
/* md.use(prism); */

export default {

    props: ['body', 'name'],

    methods:{

        tabId(tabName, hash=''){

            return `${hash}${tabName}${this.name}`

        }

    },

    computed:{

        preview(){
            return md.render(this.body);
        }

    },

    /** Lifecycle hook */
    mounted(){

        autosize(this.$el.querySelector('textarea'));

    }

}
</script>

<style>

    .nav-link.active{
        background-color: white !important;
    }

</style>

