import common from './common'
import store from '../../store'
import extend from 'extend'
import userInputMixin from './user-mixins'

export default {
    name   : 'upb-input-editor',
    mixins : [common, userInputMixin('editor')],
    data(){
        return {
            l10n : store.l10n
        }
    },

    computed : {
        wrapperId(){
            return `wrapper-${this.attributes._id}`
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
        tinyMCEPreInit.mceInit[this.attributes._id].setup    = (editor) => {
            editor.on('input change NodeChange', (e) => {
                editor.save();
                this.saveValue(tinymce.editors[this.attributes._id].getContent())
            });
        };

        tinyMCEPreInit.qtInit[this.attributes._id]    = extend(true, {}, tinyMCEPreInit.qtInit['upb-editor-template']);
        tinyMCEPreInit.qtInit[this.attributes._id].id = this.attributes._id;
    },

    mounted(){

        this.$el.querySelector(`#wrapper-${this.attributes._id}`).innerHTML = this.editorTemplate();

        // [...this.$el.querySelectorAll('.button.insert-media.add_media')].map()
        Array.from(this.$el.querySelectorAll('.button.insert-media.add_media'), el => {
            el.innerHTML = '<span class="wp-media-buttons-icon"></span>';
        });

        tinymce.init(tinyMCEPreInit.qtInit[this.attributes._id]);

        let UPBQuickTag = quicktags(tinyMCEPreInit.qtInit[this.attributes._id]);
        UPBQuickTag.canvas.addEventListener('input', (event) => {
            this.saveValue(UPBQuickTag.canvas.value)
        });

        UPBQuickTag.toolbar.addEventListener('click', (event) => {
            this.saveValue(UPBQuickTag.canvas.value)
        });

        QTags._buttonsInit();

        // run this code in the next run loop
        _.defer(_=> {
            window.switchEditors.go(this.attributes._id, 'tmce'); // tmce | html
            window.wpActiveEditor = this.attributes._id;
            // tinymce.EditorManager.execCommand( 'mceAddEditor', true, this.attributes._id );
            delete QTags.instances[0];
        }, this);
    },

    methods : {
        editorTemplate(){
            return this.l10n.editorTemplate.replace(new RegExp('upb-editor-template', 'g'), this.attributes._id).replace(new RegExp('%%UPB_EDITOR_CONTENTS%%', 'g'), this.input);
        },
        saveValue(data){
            this.input = store.wpKsesPost(data)
        }
    }
}