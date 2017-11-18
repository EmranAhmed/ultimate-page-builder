/* global tinymce, switchEditors */
import common from './common'
import store from '../../store'
import extend from 'extend'
import userInputMixin from './user-mixins'

export default {
    name   : 'upb-input-editor',
    mixins : [common, userInputMixin('editor')],
    data() {
        return {
            l10n : store.l10n
        }
    },

    computed : {
        id() {
            return `wp-editor-${this.attributes._id}`
        }
    },

    beforeDestroy() {
        this.destroyEditor(this.id)
    },

    mounted() {
        this.buildEditor(this.id)
        // [...this.$el.querySelectorAll('.button.insert-media.add_media')].map()
        Array.from(this.$el.querySelectorAll('.button.insert-media.add_media'), el => {
            el.innerHTML = '<span class="wp-media-buttons-icon"></span>';
        });
    },

    methods : {

        saveValue(data) {
            this.input = store.wpKsesPost(data)
        },

        destroyEditor(id) {
            if (window.tinymce.get(id)) {
                wp.editor.remove(id);
            }
        },

        buildEditor(id) {
            let editor;

            // Abort building if the textarea is gone, likely due to the widget having been deleted entirely.
            if (!document.getElementById(id)) {
                return;
            }

            // Add or enable the `wpview` plugin.
            jQuery(document).one('wp-before-tinymce-init.upb-editor', function (event, init) {
                // If somebody has removed all plugins, they must have a good reason.
                // Keep it that way.
                if (!init.plugins) {
                    return;
                }
                else if (!/\bwpview\b/.test(init.plugins)) {
                    init.plugins += ',wpview';
                }
            });

            wp.editor.initialize(id, this.l10n.editorSettings);

            editor = window.tinymce.get(id);

            if (!editor) {
                throw new Error('Failed to initialize editor');
            }

            editor.on('input change NodeChange paste blur hide', (e) => {
                editor.save();
                this.saveValue(editor.getContent())
            });
        }
    }
}