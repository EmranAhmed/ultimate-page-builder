'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

(function (api, wp, $) {
    var UltimatePageBuilder = function () {
        function UltimatePageBuilder(data) {
            _classCallCheck(this, UltimatePageBuilder);

            this.data = {};
            $.extend(this.data, data);
        }

        _createClass(UltimatePageBuilder, [{
            key: 'getData',
            value: function getData() {
                console.log(this.data);
            }
        }]);

        return UltimatePageBuilder;
    }();

    api.bind('ready', function () {
        api.previewer.bind('_upb_page_data', function (data) {
            api.UltimatePageBuilder = new UltimatePageBuilder(data);

            api.UltimatePageBuilder.getData();
        });
    });

    ///api.Menus.NewMenuControl = api.Control.extend({});
})(wp.customize, wp, jQuery);