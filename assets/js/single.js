jQuery( function( $ ) {
    var no_edit = '.acolhesus-readonly';
    var base = '.acolhesus-form-container';
    var cant_edit = ($(".acolhesus-form-container " + no_edit).length > 0);

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
                acolhesus_campo: $('#acolhesus_campo_selector').val(),
                acolhesus_fase: $('#acolhesus_fase_selector').val(),
                acolhesus_eixo: $('#acolhesus_eixo_selector').val(),
                post_id: $('#acolhesus_campo_selector').data('post_id')
            }).success(function (r) {
                $(self).find("option[value='']").remove();
                $(self).removeClass('required-acolhesus');
                $($field_msg).hide();
            });
        }
    });

    $('form').submit(function (e) {
        $('.acolhesus_basic_info_selector').change();
        e.preventDefault();
        return false;
    });

    if(cant_edit) {
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
    $($select_class).select2({
        placeholder: "Selecione um ou mais municípios",
        allowClear: true,
        theme: 'classic'
    }).on('select2:select', function(evt) {
        var data = evt.params.data;
        var _val_ = data.id;
        if (data.selected && _val_) {
            var post = $("#form_id").data('id');

            $.post(acolhesus.ajax_url, {
                action: 'add_city_to_form',
                city: _val_,
                post_id: post
            }).success(function (r) { });
        }
    });

    var $entry_cities = $('#entry_cities');
    if ( $entry_cities.length > 0 ) {
        var _cities = JSON.parse( $entry_cities.val() );
        $($select_class).val(_cities).trigger('change');
    }

});