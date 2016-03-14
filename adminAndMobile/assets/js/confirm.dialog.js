(function ($, undefined) {

    $('[data-confirm]').on('click', function (event) {
        var obj = this;
        event.preventDefault();
        event.stopImmediatePropagation();

        var confirmModal = $('#confirmModal');
        confirmModal.find('.modal-title').append($(obj).data('confirm-title'));
        confirmModal.find('.modal-body').append('<p>' + $(obj).data('confirm-text') + '</p>');
        confirmModal.find('#confirmModalOk').addClass($(obj).data('confirm-ok-class'));
        confirmModal.find('#confirmModalCancel').addClass($(obj).data('confirm-cancel-class'));

        /* these two are not obligatory */
        if ($(obj).data('confirm-ok-text')) {
            confirmModal.find('#confirmModalOk').html($(obj).data('confirm-ok-text'));
        }
        if ($(obj).data('confirm-cancel-text')) {
            confirmModal.find('#confirmModalCancel').html($(obj).data('confirm-cancel-text'));
        }

        confirmModal.find('#confirmModalOk').on('click', function () {
            var tagName = $(obj).prop("tagName");
            if (tagName == 'INPUT') {
                var form = $(obj).closest('form');
                form.submit();
            } else {
                document.location = obj.href;
            }
        });
        confirmModal.modal('show');
        return false;
    });

    $('#confirmModal').on('hidden.bs.modal', function () {
        var confirmModal = $('#confirmModal');
        confirmModal.find('.modal-title').text('');
        confirmModal.find('.modal-body').text('');
        confirmModal.find('#confirmModalOk').attr('class', confirmModal.find('#confirmModalOk').data('class'));
        confirmModal.find('#confirmModalCancel').attr('class', confirmModal.find('#confirmModalCancel').data('class'));
        console.log('closing modal');
    })

})(jQuery);