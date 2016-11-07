"use strict";

jQuery(function ($) {
    $(window).on('beforeunload', function () {
        if (_upb_status.dirty) {
            return "Not Saved";
        }
    });
});
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInVwYi1ib2lsZXJwbGF0ZS1zY3JpcHQuanMiXSwibmFtZXMiOlsialF1ZXJ5IiwiJCIsIndpbmRvdyIsIm9uIiwiX3VwYl9zdGF0dXMiLCJkaXJ0eSJdLCJtYXBwaW5ncyI6Ijs7QUFBQUEsT0FBTyxhQUFLO0FBQ1JDLE1BQUVDLE1BQUYsRUFBVUMsRUFBVixDQUFhLGNBQWIsRUFBNkIsWUFBTTtBQUMvQixZQUFJQyxZQUFZQyxLQUFoQixFQUF1QjtBQUNuQixtQkFBTyxXQUFQO0FBQ0g7QUFDSixLQUpEO0FBS0gsQ0FORCIsImZpbGUiOiJ1cGItYm9pbGVycGxhdGUtc2NyaXB0LmpzIn0=
