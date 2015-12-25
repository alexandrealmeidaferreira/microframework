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

    /**
     * Redirect class
     */
    $(document).on('click', '.redirect', function () {
        var url = $(this).data('url');
        if (url != undefined) {
            window.location.href = url;
        }
    });

    /**
     * Confirm for a link
     */
    $(document).on('click', 'a.confirm', function (e) {
        e.preventDefault();
        $('#microframework-modal-confirm').remove();
        var url = $(this).attr('href');
        var title = $(this).data('modal-title');
        var text = $(this).data('modal-text');
        var btnYesText = 'Yes';
        var btnNoText = 'No';
        var tempbuttons = $(this).data('modal-buttons');
        if (tempbuttons != undefined) {
            tempbuttons = tempbuttons.split('|');
            btnYesText = tempbuttons[0];
            btnNoText = tempbuttons[1];
        }
        title = (title == undefined) ? 'Confirm' : title;
        text = (text == undefined) ? 'Are you sure?' : text;

        var modalHtml = '' +
            '<div id="microframework-modal-confirm" class="modal fade" tabindex="-1" role="dialog">' +
            '    <div class="modal-dialog">' +
            '    <div class="modal-content">' +
            '    <div class="modal-header">' +
            '    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
            '<h4 class="modal-title">' + title + '</h4>' +
            '</div>' +
            '<div class="modal-body">' +
            '    <p>' + text + '</p>' +
            '</div>' +
            '<div class="modal-footer">' +
            '    <button type="button" class="btn btn-default" data-dismiss="modal">' + btnNoText + '</button>' +
            '    <button type="button" class="btn btn-primary">' + btnYesText + '</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';

        var modal = $(modalHtml).appendTo('body');
        modal.modal('show');
        $('.btn-primary', modal).one('click', function () {
            modal.modal('hide');
            window.location.href = url;
        });
    });
});