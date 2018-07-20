jQuery( function( $ ) {
    var no_edit = '.acolhesus-readonly';
    var base = '.acolhesus-form-container';
    var cant_edit = ($(".acolhesus-form-container " + no_edit).length > 0);
    var campo_atuacao = '#acolhesus_campo_selector';
    var current_post_id = $(campo_atuacao).data('post_id');

    var tag = 'input[name="novo_form"]';
    var is_new = ( $(tag).length > 0 && $(tag).val() === "true" );
    if (is_new) {
        $(campo_atuacao).val('');
        $.post(acolhesus.ajax_url, { action: 'delete_new_form_tag', post_id: current_post_id });
    }


    $('.acolhesus_basic_info_selector').change(function() {
        var opt_val = $(this).val();
        var field = $(this).attr('name');
        var $field_msg = '.' + field + " .fixed";

        if ((0 === opt_val.length) && ("" === opt_val)) {
            $(this).addClass('required-acolhesus');
            $($field_msg).show();
        } else {
            var self = this;
            $.post(acolhesus.ajax_url, {
                action: 'acolhesus_save_post_basic_info',
                acolhesus_campo: $(campo_atuacao).val(),
                acolhesus_fase: $('#acolhesus_fase_selector').val(),
                acolhesus_eixo: $('#acolhesus_eixo_selector').val(),
                post_id: current_post_id
            }).success(function (r) {
                $(self).find("option[value='']").remove();
                $(self).removeClass('required-acolhesus');
                $($field_msg).hide();
            });
        }
    });

    var current_form_id = $('.caldera-grid form').attr('id');
    $('form#' + current_form_id).submit(function (e) {
        e.preventDefault();
        $('.acolhesus_basic_info_selector').change();
        return false;
    });

    if (cant_edit) {
        $(base + ' ' + no_edit + ' input[type=\'submit\']').remove();
        $(base + ' ' + no_edit + ' button.cf-uploader-trigger').remove();
        $(no_edit + ' :radio').attr('disabled', true);
        $(no_edit + ' :checkbox').attr('disabled', true);
        $(no_edit + ' a.acolhesus_readonly').each( function(id, e) {
            var answer = $(this).text();
            $(this).replaceWith(answer);
        });
        $(no_edit + ' .is-cfdatepicker').each( function(id, e) {
            var date = $(this).val();
            $(this).replaceWith(date);
        });

        var select2_el_id = "#" + $(no_edit + ' .acolhesus_readonly_s2 select').attr('id');
        setTimeout(
         function() {
             $(select2_el_id).select2('readonly', true);
         },100);

        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                var new_elements = mutation.addedNodes;
                if (!new_elements)
                    return;

                for (var i = 0; i < new_elements.length; i++) {
                    var _el = new_elements[i];
                    if ('trumbowyg-button-pane' === $(_el).attr('class')) {
                        $(_el).remove();
                        $(no_edit + ' .trumbowyg-editor').attr('contenteditable', false);
                    }
                }
            });
        }).observe(document.body, {
            childList: true,
            subtree: true,
            attributes: false,
            characterData: false
        });
    }

    if ($('.user-cant-see').length > 0) {
        $(base + ' h3').remove();
        $(base + ' hr').remove();
    }

    var accordion = '#form-accordion';
    var icons = {
        header: "ui-icon-circle-arrow-e",
        activeHeader: "ui-icon-circle-arrow-s"
    };
    $(accordion).accordion({
        icons: icons,
        collapsible: true,
        active: false,
        heightStyle: "content"
    });
    $("#toggle").button().on("click", function() {
        if ($(accordion).accordion( "option", "icons")) {
            $(accordion).accordion( "option", "icons", null);
        } else {
            $(accordion).accordion( "option", "icons", icons);
        }
    });

    var $select_class = '.matriz-cenario-cities';
    if ($($select_class).length > 0) {
        var post = $("#form_id").data('id');
        $($select_class).select2({
            placeholder: "Selecione um ou mais municípios",
            allowClear: true,
            multiple: true,
            theme: 'classic'
        }).on( 'select2:select', function(evt) { toggle_city({event: evt}, post, true); })
            .on( 'select2:unselect', function(evt) { toggle_city({event: evt}, post, false);
            });
    }

    var $entry_cities = $('#entry_cities');
    if ( $entry_cities.length > 0 ) {
        var _cities = JSON.parse( $entry_cities.val() );
        $($select_class).val(_cities).trigger('change');
    }

    var total_cities = $('#total_entry_cities').val();
    if (total_cities && total_cities > 0) {
        $('.cities-mc .field_required').hide();
    }

    if (cant_edit) {
        $($select_class).prop("disabled", true);
        $('.select2-container--classic .select2-selection--multiple').css('border', 0);
    }

    var attachments_wrapper = '#acolhesus_form_anexos';
    $('.form_attachments').last().remove();
    $('.form_attachments').first().appendTo($(attachments_wrapper));
    if ($(attachments_wrapper + " ul").html() == "" ) {
        $(attachments_wrapper).remove();
    }

    function toggle_city(obj_evt, post_id, add) {
        if (add) {
            var _action = 'add_entry_city';
        } else if ( add === false) {
            var _action = 'remove_entry_city';
        } else {
            return false;
        }

        var event = obj_evt.event;
        var data = event.params.data;

        var total_cities = $($select_class).val();
        if (total_cities && total_cities.length > 0) {
            $('.cities-mc .field_required').hide();
        } else {
            $('.cities-mc .field_required').show();
        }

        if (_action && post_id && data.id) {
            var del_data = { action: _action, city: data.id, post_id: post_id};
            $.post(acolhesus.ajax_url, del_data);
        }
    }

    $(attachments_wrapper + ' a.acolhesus-remove-file').on('click', function() {
        var nome = $(this).data('name');
        if (confirm("Deseja remover o anexo " + nome + "?")) {
            var attach_id = $(this).data('id');
            var entry_id = $('input[name="_cf_frm_edt"]').val();
            console.log("Removendo " + attach_id);

            if (attach_id && entry_id) {
                var data = { action: 'delete_form_attachment', attach: attach_id, entry: entry_id};
                $.post(acolhesus.ajax_url, data).success(function () {
                    $(attachments_wrapper + " li.attach-" + attach_id).hide();
                });
            } else {
                alert("Não foi possível remover " + nome + " agora. Tente novamente mais tarde.");
            }
        }
    });
});