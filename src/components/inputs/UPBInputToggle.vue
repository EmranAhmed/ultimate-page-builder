<template>
    <li :class="typeClass()">
        <div class="form-group toggle">
            <span class="title" v-text="attrs.title"></span>
            <label class="switch">
                <input type="checkbox" :id="attrs.id" v-model="model[attrs._id]">
                <div class="slider round"></div>
            </label>
            <p class="description" v-if="attrs.desc" v-html="attrs.desc"></p>
        </div>
    </li>
</template>
<style lang="scss">

    @import "../../../assets/scss/variables";

    /* The switch - the box around the slider */
    .switch {
        position : relative;
        display  : inline-block;
        width    : 60px;
        height   : 34px;
        }

    /* Hide default HTML checkbox */
    .switch input {
        display : none;
        }

    /* The slider */
    .slider {
        position         : absolute;
        cursor           : pointer;
        top              : 0;
        left             : 0;
        right            : 0;
        bottom           : 0;
        background-color : #CCCCCC;
        transition       : .2s;
        }

    .slider:before {
        position         : absolute;
        content          : "";
        height           : 26px;
        width            : 26px;
        left             : 4px;
        bottom           : 4px;
        background-color : white;
        transition       : .2s;
        }

    input:checked + .slider {
        background-color : $upb-sidebar-tab-active-background-color;
        }

    input:focus + .slider {
        box-shadow : 0 0 1px $upb-sidebar-tab-active-background-color;
        }

    input:checked + .slider:before {
        transform         : translateX(26px);
        }

    /* Rounded sliders */
    .slider.round {
        border-radius : 34px;
        }

    .slider.round:before {
        border-radius : 50%;
        }
</style>
<script>
    export default {
        name    : 'upb-input-toggle',
        props   : ['index', 'attrs', 'model'],
        methods : {
            typeClass(){
                return `${this.attrs.type}-field-wrapper form-field-wrapper`;
            }
        }
    }
</script>