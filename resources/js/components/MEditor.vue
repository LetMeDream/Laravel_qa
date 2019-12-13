<template>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle='tab' href="#write">Write</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle='tab' href="#preview">Preview</a>
                </li>
            </ul>
        </div>
        <div class="card-body tab-content">
            <!-- Slot is a VueJs special tag that serves as placeholder for a value passed from a parent component  -->
            <div class="tab-pane active" id='write'>
                <slot></slot>
            </div>
            <div class="tab-pane" id='preview' v-html='preview'>
                <div></div>
            </div>



        </div>
    </div>
</template>

<script>
/** Importing markdown-it package */
import MarkdownIt from 'markdown-it';
/** Then define a variable to hold the markdown-it instance */
const md = new MarkdownIt();

export default {

    props: ['body'],

    computed:{

        preview(){
            return md.render(this.body);
        }

    }

}
</script>

<style>

    .nav-link.active{
        background-color: white !important;
    }

</style>

