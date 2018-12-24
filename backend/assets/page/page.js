$('#pageform-makealias').on('click', function () {
    makeAlias();
});

function makeAlias() {
    var title = $('#pageform-title'), alias = $('#pageform-alias');
    alias.addClass('loading');
    $.get(alias.data('url'), {title: title.val()}, function (data) {
        alias.removeClass('loading');
        if (title.val() == data.title) {
            alias.val(data.alias);
        }
    }, 'json');
}
