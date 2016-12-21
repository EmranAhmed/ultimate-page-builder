import common from './common'
import store from '../../store'
import extend from 'extend'

export default {
    name   : 'upb-input-contents',
    props  : ['index', 'target', 'model', 'attributes', 'item'], // model[target]
    mixins : [common],
    data(){
        return {
            l10n   : store.l10n,
            markup : ''
        }
    },

    beforeDestroy(){

        // Reset data
        tinymce.EditorManager.execCommand('mceRemoveEditor', true, this.attributes._id);

        delete QTags.instances[this.attributes._id];
        delete tinyMCEPreInit.mceInit[this.attributes._id];
        delete tinyMCEPreInit.qtInit[this.attributes._id];
        this.$el.querySelector(`#wrapper-${this.attributes._id}`).innerHTML = '';
    },

    created(){

        tinyMCEPreInit.mceInit[this.attributes._id]          = extend(true, {}, tinyMCEPreInit.mceInit['upb-editor-template']);
        tinyMCEPreInit.mceInit[this.attributes._id].id       = this.attributes._id;
        tinyMCEPreInit.mceInit[this.attributes._id].selector = '#' + this.attributes._id;
        tinyMCEPreInit.qtInit[this.attributes._id]           = extend(true, {}, tinyMCEPreInit.qtInit['upb-editor-template']);
        tinyMCEPreInit.qtInit[this.attributes._id].id        = this.attributes._id;
        tinyMCEPreInit.mceInit[this.attributes._id].setup    = (editor) => {
            editor.on('input change NodeChange', (e) => {
                editor.save();
                this.saveValue(tinymce.editors[this.attributes._id].getContent())
            });
        };

        this.markup = this.l10n.editorTemplate.replace(new RegExp('upb-editor-template', 'g'), this.attributes._id).replace(new RegExp('%%UPB_EDITOR_CONTENTS%%', 'g'), this.input);
    },

    mounted(){

        this.$el.querySelector(`#wrapper-${this.attributes._id}`).innerHTML = this.markup;

        this.$el.querySelectorAll('.button.insert-media.add_media').forEach(function (el) {
            el.innerHTML = '<span class="wp-media-buttons-icon"></span>';
        });

        let UPBQuickTag = quicktags(tinyMCEPreInit.qtInit[this.attributes._id]);

        UPBQuickTag.canvas.addEventListener('input', (event) => {
            this.saveValue(UPBQuickTag.canvas.value)
        })

        UPBQuickTag.toolbar.addEventListener('click', (event) => {
            this.saveValue(UPBQuickTag.canvas.value)
        })

        window.addEventListener('load', _=> {
            window.switchEditors.go(this.attributes._id, 'html'); // tmce | html
            window.wpActiveEditor = this.attributes._id;
        });

        delete QTags.instances[0];
    },

    watch : {
        input(value){
            this.item.contents = value
        }
    },

    methods : {
        saveValue(data){
            this.input = store.wpKsesPost(data)
        }
    }
}