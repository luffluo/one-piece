+function ($) {

    'use strict';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("click.bs.nav.data-api", '[data-toggle="nav-min"]', function () {
        $.ajax({
            url: $('body').data('url'),
            type: 'post',
            dataType: 'json',
            success: function (result) {
            }
        });

        $("body").toggleClass("nav-min");
    });

    $(document).on("click.bs.data-api", '[data-toggle="off-canvas"]', function () {
        $("body").toggleClass("on-canvas");
    });

    $(document).on("click.bs.sidebar.data-api", '[data-toggle="sidebar"]', function (e) {
        e.preventDefault();
        $(this).parent("li").toggleClass("open");
    });

    $(window).on("load", function () {
        $('[data-toggle="nav-accordion"]').each(function (index, element) {
            var lists = $(element).find("ul").parent("li");
            var a = lists.children("a");
            var listsRest = $(element).children("ul").children("li").not(lists);
            var app = $("body");
            var stopClick = 0;
            a.on("click", function (e) {
                e.preventDefault();
                var self = $(this), parent = self.parent("li");
                a.not(self).next("ul").slideUp();
                self.next("ul").slideToggle();
                lists.not(parent).removeClass("open");
                parent.toggleClass("open");
            });
        });

        $('[data-toggle="scrollbar"]').each(function () {
            $(this).perfectScrollbar({
                suppressScrollX: !0
            });
        });

        $('[data-toggle="sortable"]').each(function () {
            $(this).sortable({
                stop: function (event, ui) {
                    $(ui.item[0].parentElement).children("li").each(function (i, el) {
                        $(el).find("input").val(i);
                        $(el).find("span.badge").html(i);
                    });
                }
            });
        });
    });

    $('[action-confirm]').on('click', function () {
        var $this = $(this);
        var message = $this.attr('action-confirm');

        if ('' == message) {
            message = '确认要执行此操作吗？';
        }

        return confirm(message);
    });
}(jQuery);
