jQuery( function( $ ) {
    $('.acolhesus_basic_info_selector').change(function() {
        $.post(acolhesus.ajax_url, {
            action: 'acolhesus_save_post_basic_info',
            acolhesus_campo: $('#acolhesus_campo_selector').val(),
            acolhesus_fase: $('#acolhesus_fase_selector').val(),
            acolhesus_eixo: $('#acolhesus_eixo_selector').val(),
            post_id: $('#acolhesus_campo_selector').data('post_id')
        })
    }).change();

    $('.acolhesus-form-container .acolhesus-readonly input[type=\'submit\']').remove();
    $('.acolhesus-form-container .acolhesus-readonly :radio').attr('disabled', true);

    if ( $('.user-cant-see').length > 0 ) {
        $('.acolhesus-form-container h3').remove();
        $('.acolhesus-form-container hr').remove();
    }
});