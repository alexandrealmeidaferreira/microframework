/**
 * Created by alexandre on 13/12/15.
 */
$(document).ready(function () {

    /**
     * Transform the action into route
     */
    $('form[method!=post]').submit(function () {
        var action = $(this).attr('action');
        var params = $(this).serialize();
        $(this).children().removeAttr('name');
        $(this).attr('action', action + params.replace('=', '/').replace('&', '/').replace('&amp;', '/'));
        return true;
    });

    /**
     * Auto dismiss alerts
     */
    $('.alert').each(function () {
        var self = $(this);
        var timeout = self.data('dismiss-timeout');
        if (timeout != undefined) {
            window.setTimeout(function () {
                self.alert('close');
            }, timeout * 1000);
        }
    });
});