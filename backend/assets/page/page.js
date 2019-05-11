var page = {
    init: function() {
        $('#make-url').on('click', this.make_url);
    },
    make_url: function() {
        var $button = $(this), $input = $('#pageform-url');
        if ($input.hasClass('state-loading')) {
            return;
        }
        $input.addClass('state-loading');
        $.get($button.data('url'), {title: $('#pageform-title').val()}, function(data) {
            $input.val(data).removeClass('state-loading');
        }, 'json');
    }
};

page.init();
