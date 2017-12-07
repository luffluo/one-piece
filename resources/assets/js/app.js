
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

jQuery(function () {
    $('a[data-method]').on('click', function (e) {
        e.preventDefault();

        var method = $(this).data('method');

        if (undefined !== $(this).attr('data-confirm') && ! confirm($(this).data('confirm'))) {
            return false;
        }

        var form = $('<form style="display: none;" action="' + $(this).attr('href') + '" method="post">'
            + '<input type="hidden" name="_token" value="' + $("meta[name='csrf-token']").attr('content') + '">'
            + '<input type="hidden" name="_method" value="' + method.toUpperCase() + '">'
            + '</form>').insertAfter($(this));

        form.submit();
    });
});
