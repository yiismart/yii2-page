var page = {
    init: function() {
        $('#make-alias').on('click', this.make_alias);
    },
    make_alias: function() {
        var $button = $(this), $input = $('#pageform-alias');
        if ($input.hasClass('state-loading')) {
            return;
        }
        $input.addClass('state-loading');
        $.get($button.data('url'), {s: $('#pageform-title').val()}, function(data) {
            $input.val(data).removeClass('state-loading');
        }, 'json');
    }
};

page.init();
