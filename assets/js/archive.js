jQuery( function( $ ) {
    $('#add_acolhesus_entry').click(function() {
        var data = {
            title: $('#add_acolhesus_entry').text(),
            action: 'acolhesus_add_form_entry',
            type: $('#new_post_type').val()
        };
        $.post(acolhesus.ajax_url, data).success(function(res) {
            var r = JSON.parse(res);
            var entryURL = r.redirect_url;
            if(entryURL) {
                window.location = entryURL;
            }

        }).error(function (erro) {
            alert('Tente novamente mais tarde!');
        });
    });
});

