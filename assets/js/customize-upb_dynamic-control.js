(function (api, $) {
    'use strict';

    /**
     * A dynamic control.
     *
     * @class
     * @augments wp.customize.Control
     * @augments wp.customize.Class
     */

    api.UPBControl = api.Control.extend({

        initialize: function (id, options) {
            var control = this,
                args;

            args = options || {};
            args.params = args.params || {};
            if (!args.params.type) {
                args.params.type = 'upb-control';
            }
            if (!args.params.content) {
                args.params.content = $('<li></li>');
                args.params.content.attr('id', 'customize-control-' + id.replace(/]/g, '').replace(/\[/g, '-'));
                args.params.content.attr('class', 'customize-control customize-control-' + args.params.type);
            }

            control.propertyElements = [];
            api.Control.prototype.initialize.call(control, id, args);
        },

        /**
         * Add bidirectional data binding links between inputs and the setting(s).
         *
         * This is copied from wp.customize.Control.prototype.initialize(). It
         * should be changed in Core to be applied once the control is embedded.
         *
         * @private
         * @returns {void}
         */
        _setUpSettingRootLinks: function () {
            var control, nodes, radios;
            control = this;
            nodes = control.container.find('[data-customize-setting-link]');
            radios = {};

            nodes.each(function () {
                var node = $(this),
                    name;

                if (node.is(':radio')) {
                    name = node.prop('name');
                    if (radios[name]) {
                        return;
                    }

                    radios[name] = true;
                    node = nodes.filter('[name="' + name + '"]');
                }

                api(node.data('customizeSettingLink'), function (setting) {
                    var element = new api.Element(node);
                    control.elements.push(element);
                    element.sync(setting);
                    element.set(setting());
                });
            });
        },

        /**
         * Add bidirectional data binding links between inputs and the setting properties.
         *
         * @private
         * @returns {void}
         */
        _setUpSettingPropertyLinks: function () {
            var control = this,
                nodes,
                radios;
            if (!control.setting) {
                return;
            }

            nodes = control.container.find('[data-customize-setting-property-link]');
            radios = {};

            nodes.each(function () {
                var node = $(this),
                    name,
                    element,
                    propertyName = node.data('customizeSettingPropertyLink');

                if (node.is(':radio')) {
                    name = node.prop('name');
                    if (radios[name]) {
                        return;
                    }
                    radios[name] = true;
                    node = nodes.filter('[name="' + name + '"]');
                }

                element = new api.Element(node);
                control.propertyElements.push(element);
                element.set(control.setting()[propertyName]);

                element.bind(function (newPropertyValue) {
                    var newSetting = control.setting();
                    if (newPropertyValue === newSetting[propertyName]) {
                        return;
                    }
                    newSetting = _.clone(newSetting);
                    newSetting[propertyName] = newPropertyValue;
                    control.setting.set(newSetting);
                });
                control.setting.bind(function (newValue) {
                    if (newValue[propertyName] !== element.get()) {
                        element.set(newValue[propertyName]);
                    }
                });
            });
        },

        /**
         * @inheritdoc
         */
        ready: function () {
            var control = this;

            control._setUpSettingRootLinks();
            control._setUpSettingPropertyLinks();

            api.Control.prototype.ready.call(control);

            // @todo build out the controls for the post when Control is expanded.
            // @todo Let the Control title include the post title.
            control.deferred.embedded.done(function () {});
        },

        /**
         * Embed the control in the document.
         *
         * Override the embed() method to do nothing,
         * so that the control isn't embedded on load,
         * unless the containing section is already expanded.
         *
         * @returns {void}
         */
        embed: function () {
            var control = this,
                sectionId = control.section();
            if (!sectionId) {
                return;
            }
            api.section(sectionId, function (section) {
                if (section.expanded() || api.settings.autofocus.control === control.id) {
                    control.actuallyEmbed();
                } else {
                    section.expanded.bind(function (expanded) {
                        if (expanded) {
                            control.actuallyEmbed();
                        }
                    });
                }
            });
        },

        /**
         * Deferred embedding of control when actually
         *
         * This function is called in Section.onChangeExpanded() so the control
         * will only get embedded when the Section is first expanded.
         *
         * @returns {void}
         */
        actuallyEmbed: function () {
            var control = this;
            if ('resolved' === control.deferred.embedded.state()) {
                return;
            }
            control.renderContent();
            control.deferred.embedded.resolve(); // This triggers control.ready().
        },

        /**
         * This is not working with autofocus.
         *
         * @param {object} [args] Args.
         * @returns {void}
         */
        focus: function (args) {
            var control = this;
            control.actuallyEmbed();
            api.Control.prototype.focus.call(control, args);
        }
    });

    api.controlConstructor['upb-control'] = api.UPBControl;
})(wp.customize, jQuery);
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImN1c3RvbWl6ZS11cGJfZHluYW1pYy1jb250cm9sLmpzIl0sIm5hbWVzIjpbImFwaSIsIiQiLCJVUEJDb250cm9sIiwiQ29udHJvbCIsImV4dGVuZCIsImluaXRpYWxpemUiLCJpZCIsIm9wdGlvbnMiLCJjb250cm9sIiwiYXJncyIsInBhcmFtcyIsInR5cGUiLCJjb250ZW50IiwiYXR0ciIsInJlcGxhY2UiLCJwcm9wZXJ0eUVsZW1lbnRzIiwicHJvdG90eXBlIiwiY2FsbCIsIl9zZXRVcFNldHRpbmdSb290TGlua3MiLCJub2RlcyIsInJhZGlvcyIsImNvbnRhaW5lciIsImZpbmQiLCJlYWNoIiwibm9kZSIsIm5hbWUiLCJpcyIsInByb3AiLCJmaWx0ZXIiLCJkYXRhIiwic2V0dGluZyIsImVsZW1lbnQiLCJFbGVtZW50IiwiZWxlbWVudHMiLCJwdXNoIiwic3luYyIsInNldCIsIl9zZXRVcFNldHRpbmdQcm9wZXJ0eUxpbmtzIiwicHJvcGVydHlOYW1lIiwiYmluZCIsIm5ld1Byb3BlcnR5VmFsdWUiLCJuZXdTZXR0aW5nIiwiXyIsImNsb25lIiwibmV3VmFsdWUiLCJnZXQiLCJyZWFkeSIsImRlZmVycmVkIiwiZW1iZWRkZWQiLCJkb25lIiwiZW1iZWQiLCJzZWN0aW9uSWQiLCJzZWN0aW9uIiwiZXhwYW5kZWQiLCJzZXR0aW5ncyIsImF1dG9mb2N1cyIsImFjdHVhbGx5RW1iZWQiLCJzdGF0ZSIsInJlbmRlckNvbnRlbnQiLCJyZXNvbHZlIiwiZm9jdXMiLCJjb250cm9sQ29uc3RydWN0b3IiLCJ3cCIsImN1c3RvbWl6ZSIsImpRdWVyeSJdLCJtYXBwaW5ncyI6IkFBQUEsQ0FBQyxVQUFVQSxHQUFWLEVBQWVDLENBQWYsRUFBa0I7QUFDZjs7QUFFQTs7Ozs7Ozs7QUFRQUQsUUFBSUUsVUFBSixHQUFpQkYsSUFBSUcsT0FBSixDQUFZQyxNQUFaLENBQW1COztBQUVoQ0Msb0JBQWEsVUFBVUMsRUFBVixFQUFjQyxPQUFkLEVBQXVCO0FBQ2hDLGdCQUFJ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U0FBWixDQUFzQjhCLEtBQXRCLENBQTRCN0IsSUFBNUIsQ0FBaUNULE9BQWpDOztBQUVBO0FBQ0E7QUFDQUEsb0JBQVF1QyxRQUFSLENBQWlCQyxRQUFqQixDQUEwQkMsSUFBMUIsQ0FBK0IsWUFBWSxDQUFFLENBQTdDO0FBQ0gsU0E1SCtCOztBQThIaEM7Ozs7Ozs7OztBQVNBQyxlQUFRLFlBQVk7QUFDaEIsZ0JBQUkxQyxVQUFZLElBQWhCO0FBQUEsZ0JBQ0kyQyxZQUFZM0MsUUFBUTRDLE9BQVIsRUFEaEI7QUFFQSxnQkFBSSxDQUFDRCxTQUFMLEVBQWdCO0FBQ1o7QUFDSDtBQUNEbkQsZ0JBQUlvRCxPQUFKLENBQVlELFNBQVosRUFBdUIsVUFBVUMsT0FBVixFQUFtQjtBQUN0QyxvQkFBSUEsUUFBUUMsUUFBUixNQUFzQnJELElBQUlzRCxRQUFKLENBQWFDLFNBQWIsQ0FBdUIvQyxPQUF2QixLQUFtQ0EsUUFBUUYsRUFBckUsRUFBeUU7QUFDckVFLDRCQUFRZ0QsYUFBUjtBQUNILGlCQUZELE1BR0s7QUFDREosNEJBQVFDLFFBQVIsQ0FBaUJkLElBQWpCLENBQXNCLFVBQVVjLFFBQVYsRUFBb0I7QUFDdEMsNEJBQUlBLFFBQUosRUFBYztBQUNWN0Msb0NBQVFnRCxhQUFSO0FBQ0g7QUFDSixxQkFKRDtBQUtIO0FBQ0osYUFYRDtBQVlILFNBekorQjs7QUEySmhDOzs7Ozs7OztBQVFBQSx1QkFBZ0IsWUFBWTtBQUN4QixnQkFBSWhELFVBQVUsSUFBZDtBQUNBLGdCQUFJLGVBQWVBLFFBQVF1QyxRQUFSLENBQWlCQyxRQUFqQixDQUEwQlMsS0FBMUIsRUFBbkIsRUFBc0Q7QUFDbEQ7QUFDSDtBQUNEakQsb0JBQVFrRCxhQUFSO0FBQ0FsRCxvQkFBUXVDLFFBQVIsQ0FBaUJDLFFBQWpCLENBQTBCVyxPQUExQixHQU53QixDQU1hO0FBQ3hDLFNBMUsrQjs7QUE0S2hDOzs7Ozs7QUFNQUMsZUFBUSxVQUFVbkQsSUFBVixFQUFnQjtBQUNwQixnQkFBSUQsVUFBVSxJQUFkO0FBQ0FBLG9CQUFRZ0QsYUFBUjtBQUNBeEQsZ0JBQUlHLE9BQUosQ0FBWWEsU0FBWixDQUFzQjRDLEtBQXRCLENBQTRCM0MsSUFBNUIsQ0FBaUNULE9BQWpDLEVBQTBDQyxJQUExQztBQUNIO0FBdEwrQixLQUFuQixDQUFqQjs7QUF5TEFULFFBQUk2RCxrQkFBSixDQUF1QixhQUF2QixJQUF3QzdELElBQUlFLFVBQTVDO0FBRUgsQ0F0TUQsRUFzTUc0RCxHQUFHQyxTQXRNTixFQXNNaUJDLE1BdE1qQiIsImZpbGUiOiJjdXN0b21pemUtdXBiX2R5bmFtaWMtY29udHJvbC5qcyJ9
