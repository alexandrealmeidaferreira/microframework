/**
 * Created by alexandre on 13/12/15.
 */
$(document).ready(function () {

    /**
     * Transform the action into route
     */
    $('form[method!=post], form[method!=POST]').submit(function () {
        var action = $(this).attr('action');
        var params = $(this).serialize();
        $(this).children().removeAttr('name');
        $(this).attr('action', action + params.replace('=', '/').replace('&', '/').replace('&amp;', '/'));
        return true;
    });
});