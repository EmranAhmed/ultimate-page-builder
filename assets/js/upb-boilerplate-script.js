"use strict";

jQuery(function ($) {

    $(window).on('beforeunload', function () {
        if (_upb_status.dirty) {
            return "Not Saved";
        }
    });
});
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInVwYi1ib2lsZXJwbGF0ZS1zY3JpcHQuanMiXSwibmFtZXMiOlsialF1ZXJ5IiwiJCIsIndpbmRvdyIsIm9uIiwiX3VwYl9zdGF0dXMiLCJkaXJ0eSJdLCJtYXBwaW5ncyI6Ijs7QUFBQUEsT0FBTyxhQUFLOztBQUVSQyxNQUFFQyxNQUFGLEVBQVVDLEVBQVYsQ0FBYSxjQUFiLEVBQTZCLFlBQU07QUFDL0IsWUFBSUMsWUFBWUMsS0FBaEIsRUFBdUI7QUFDbkIsbUJBQU8sV0FBUDtBQUNIO0FBQ0osS0FKRDtBQU1ILENBUkQiLCJmaWxlIjoidXBiLWJvaWxlcnBsYXRlLXNjcmlwdC5qcyJ9
