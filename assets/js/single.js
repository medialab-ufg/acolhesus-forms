jQuery( function( $ ) {
    $('#acolhesus_campo_selector').change(function() {
        $.post(acolhesus.ajax_url, {
            action: 'acolhesus_save_post_campo',
            acolhesus_campo: $('#acolhesus_campo_selector').val(),
            post_id: $('#acolhesus_campo_selector').data('post_id')
        })
    }).change();
});