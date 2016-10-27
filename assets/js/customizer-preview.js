wp.customize.UltimatePageBuilder_Preview = function ($, _, wp, api) {

    api.bind('preview-ready', data => {
        if (api.settings.activePanels['upb-panel']) {
            api.preview.bind('active', () => {
                api.preview.send('_upb_page_data', _UPB_Page_Data);
            });
        }
    });

    return self;
}(jQuery, _, wp, wp.customize);
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImN1c3RvbWl6ZXItcHJldmlldy5qcyJdLCJuYW1lcyI6WyJ3cCIsImN1c3RvbWl6ZSIsIlVsdGltYXRlUGFnZUJ1aWxkZXJfUHJldmlldyIsIiQiLCJfIiwiYXBpIiwiYmluZCIsImRhdGEiLCJzZXR0aW5ncyIsImFjdGl2ZVBhbmVscyIsInByZXZpZXciLCJzZW5kIiwiX1VQQl9QYWdlX0RhdGEiLCJzZWxmIiwialF1ZXJ5Il0sIm1hcHBpbmdzIjoiQUFBQUEsR0FBR0MsU0FBSCxDQUFhQywyQkFBYixHQUE2QyxVQUFVQyxDQUFWLEVBQWFDLENBQWIsRUFBZ0JKLEVBQWhCLEVBQW9CSyxHQUFwQixFQUF5Qjs7QUFFbEVBLFFBQUlDLElBQUosQ0FBUyxlQUFULEVBQTJCQyxJQUFELElBQVU7QUFDaEMsWUFBSUYsSUFBSUcsUUFBSixDQUFhQyxZQUFiLENBQTBCLFdBQTFCLENBQUosRUFBNEM7QUFDeENKLGdCQUFJSyxPQUFKLENBQVlKLElBQVosQ0FBaUIsUUFBakIsRUFBMkIsTUFBTTtBQUM3QkQsb0JBQUlLLE9BQUosQ0FBWUMsSUFBWixDQUFpQixnQkFBakIsRUFBbUNDLGNBQW5DO0FBQ0gsYUFGRDtBQUdIO0FBQ0osS0FORDs7QUFRQSxXQUFPQyxJQUFQO0FBRUgsQ0FaNEMsQ0FZM0NDLE1BWjJDLEVBWW5DVixDQVptQyxFQVloQ0osRUFaZ0MsRUFZNUJBLEdBQUdDLFNBWnlCLENBQTdDIiwiZmlsZSI6ImN1c3RvbWl6ZXItcHJldmlldy5qcyJ9
