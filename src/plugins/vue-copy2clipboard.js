import { util } from 'vue';

($ => {
    class Copy2Clipboard {

        constructor() {
            this.name = 'copy2clipboard';
        }

        install(Vue, options) {
            Vue.directive(this.name, this.register());
        }

        register() {
            return {

                bind (el, binding, vnode) {

                },

                update (el, binding, vnode) {
                },

                unbind (el, binding, vnode) {
                    $(el).find('input').remove();
                },

                componentUpdated (el, binding, vnode) {

                },

                inserted (el, binding, vnode) {

                    $(el).append(`<input style="position: absolute; opacity: 0; z-index: -1" readonly type="text">`);

                    // console.log(binding.value);

                    $(el).find('input').val(binding.value.json);

                    $(el).on('click', function (e) {

                        e.preventDefault();
                        this.querySelector("input").select();

                        try {
                            let successful = document.execCommand('copy');

                            if (successful) {
                                if (!vnode.context.copiedToClipboard) {
                                    util.warn('You need to implement the `copiedToClipboard` method', vnode.context);
                                }

                                vnode.context.copiedToClipboard(binding.value.title);
                            }

                        } catch (err) {
                            console.log('Could Not Copy', err);
                        }

                    });

                    // console.log(binding.value)
                }
            }
        }
    }

    if (typeof exports == "object") {
        module.exports = new Copy2Clipboard()
    }
    else if (typeof define == "function" && define.amd) {
        define([], function () {
            return new Copy2Clipboard()
        })
    }
    else if (window.Vue) {
        window.Copy2Clipboard = new Copy2Clipboard()
        Vue.use(Copy2Clipboard)
    }

})(window.jQuery);