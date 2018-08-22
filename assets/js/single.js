jQuery( function( $ ) {
    var no_edit = '.acolhesus-readonly';
    var base = '.acolhesus-form-container';
    var cant_edit = ($(".acolhesus-form-container " + no_edit).length > 0);
    var campo_atuacao = '#acolhesus_campo_selector';
    var fase_selector = "#acolhesus_fase_selector";
    var eixo_selector = "#acolhesus_eixo_selector";
    var current_post_id = $(campo_atuacao).data('post_id');

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
                acolhesus_fase:  $(fase_selector).val(),
                acolhesus_eixo:  $(eixo_selector).val(),
                post_id: current_post_id
            }).success(function (r) {
                $(self).find("option[value='']").remove();
                $(self).removeClass('required-acolhesus');
                $($field_msg).hide();
            });
        }
    });

    var tag = 'input[name="novo_form"]';
    var is_new = ( $(tag).length > 0 && $(tag).val() === "true" );
    if (is_new) {
        var campo = sessionStorage.getItem("rhs_campo"), fase = sessionStorage.getItem("rhs_fase");
        if(campo)
        {
            $(campo_atuacao).val(campo);
            sessionStorage.removeItem('rhs_campo');
        } else $(campo_atuacao).val('');

        if(fase)
        {
            $(fase_selector).val(fase);
            sessionStorage.removeItem('rhs_fase');
        } else $(fase_selector).val('');

        var data = { action: 'delete_new_form_tag', post_id: current_post_id };
        $.post(acolhesus.ajax_url, data).success(function() {
            $('.acolhesus_basic_info_selector').change();
        });
    }
    
    if ($(base + ' .single input[type="submit"]').length == 0) {
        var save_btn = 'button.save_for_later';
        if ($(save_btn).length === 1) {
            $(save_btn).css('margin-top',0);
        }
    }

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
    var attachments = '.form_attachments';
    $(attachments).last().remove();
    $(attachments).first().appendTo($(attachments_wrapper));
    if ((typeof $(attachments_wrapper + " ul").html() === "undefined") || ($(attachments_wrapper + " ul").html() === "")) {
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

    $(document).on('change', 'input.form-control, select.form-control, input[type=checkbox], textarea.form-control', function () {
        window.onbeforeunload = function() {
            return false;
        };
    });

    $(window).on('load', function () {
        $(document).on('click', 'a.btn-success', function () {
            window.onbeforeunload = function() {
                return false;
            };
        });
    });

    $(document).on('click', 'input[type=submit], button[type=submit]', function (event) {
        window.onbeforeunload = '';
    });

    $(document).on('click', '.save_for_later', function() {
        window.onbeforeunload = '';
        save_for_later();
    });

    var fileInput = document.querySelector("input[type=file]");
    if (fileInput) {
        fileInput.addEventListener('change', function (e) {
            var result = sessionStorage.getItem('rhs_input_file');
            if(!result)
            {
                result = [];
            }else{
                result = JSON.parse(result);
            }

            for(var file of fileInput.files)
            {
                (function (file) {
                    var reader = new FileReader();
                    reader.onload = (function (file) {
                        var name = file.name;
                        return function (e){
                            result.push({name: name, file: reader.result});
                            sessionStorage.setItem('rhs_input_file', JSON.stringify(result));
                        }
                    })(file);

                    var fileInfo = reader.readAsDataURL(file);
                })(file)
            }
        })
    }


    /*Verificação de data em: Indicadores*/
    var month_id = 'fld_680040', year_id = "fld_637266";
    var month = "select[name="+month_id+"]", year = "select[name="+year_id+"]";

    if($(month).length > 0 && $(year).length > 0 && $(campo_atuacao).length > 0 && $(fase_selector).length > 0)
    {
        if(is_new)
        {
            if($(month).val() === '' || $(year).val() === '' || $(campo_atuacao).val() === '' || $(fase_selector).val() === '')
            {
                $(":input[type=submit]").prop("disabled", true);
            } else $(":input[type=submit]").prop("disabled", false);

            var div = document.createElement('div');
            var warning = "Já existe uma resposta para este estado com este mês e ano de ocorrência! Favor escolher outra data.";
            div.id = "cant_save";
            div.style.display = 'none';
            div.className = "data-inserida-box";

            div.innerHTML = "<p class='text-center alert alert-warning'>" + warning + "</p>";
            $(div).insertAfter('.first_row');

            $(document).on("change", month+", "+year+", "+campo_atuacao+", "+fase_selector, function () {
                if($(month).val() === '' || $(year).val() === '' || $(campo_atuacao).val() === '' || $(fase_selector).val() === '')
                {
                    $(":input[type=submit]").prop("disabled", true);
                }else{
                    var data ={
                        month_id: month_id,
                        year_id: year_id,
                        month_val: $(month).val(),
                        year_val: $(year).val(),
                        state: $(campo_atuacao).val()
                    };

                    jQuery.post(acolhesus.ajax_url, {
                        action: 'acolhesus_verify_indicadores_info',
                        data: data
                    }).success(function (result) {
                        result = result.substr(0, result.length-1);
                        if(result == 'true')
                        {
                            $(":input[type=submit]").prop("disabled", false);
                            $("#cant_save").hide();
                        }else{
                            $(":input[type=submit]").prop("disabled", true);
                            $("#cant_save").show();
                        }
                    });
                }
            });
        }
    }else if($(fase_selector).length > 0)
    {
        if($(fase_selector).val() === '')
        {
            $(":input[type=submit]").prop("disabled", true);
        }else $(":input[type=submit]").prop("disabled", false);

        $(document).on('change', fase_selector, function () {
            if($(fase_selector).val() === '')
            {
                $(":input[type=submit]").prop("disabled", true);
            }else $(":input[type=submit]").prop("disabled", false);
        });
    }



});

function save_for_later() {
    swal({ showConfirmButton: false, showCancelButton: false, title: 'Salvando formulário...', icon: "warning" });
    var all_inputs = new FormData(),
        cr_post = get_save("input[name=_cf_cr_pst]", all_inputs);

    //Text, number
    get_save('input[type=text]', all_inputs);
    get_save('input[type=number]', all_inputs);

    //Radio and checkbox
    get_save('input:checked', all_inputs);

    //Text areas
    get_save('textarea', all_inputs);

    //A:btnSuccess
    get_save('a.btn-success', all_inputs);

    //Select box
    get_save('select', all_inputs);

    //Form ID
    var form = document.querySelector('div.caldera-grid > form'),
            formId = form.dataset.formId;

    //Files
    var fileInput = document.querySelector("input[type=file]");
    if (fileInput) {
        var input_file = JSON.parse(sessionStorage.getItem('rhs_input_file'));

        all_inputs.append("file_input_id", fileInput.name);
        all_inputs.append("file_value", sessionStorage.getItem('rhs_input_file'));
    }

    all_inputs.append('action', 'acolhesus_save_for_later');
    all_inputs.append('formId', formId);

    //----------------- Send by AJAX -------------------------------//
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function()
    {
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
        {
            sessionStorage.removeItem('rhs_input_file');
            swal("Formulário salvo com sucesso!", "Você pode continuar a preenchê-lo posteriormente antes de enviar", "success");
            setTimeout(function () {
               //window.location.reload();
            }, 1000);
        }
    };

    xmlHttp.open("post", acolhesus.ajax_url);
    xmlHttp.send(all_inputs);
}

function get_save(query, all_inputs) {
    var nodes = document.querySelectorAll(query);
    Array.prototype.forEach.call (nodes, function (node) {
        var id = node.name, value;
        if(query == 'select' && node.style.display == 'none')
        {
            id = id.substring(0, id.indexOf('['));
            value = [];
            value.push("autocomplete");
            jQuery("div[id *="+id+"] ul li").each(function (index, val) {
                var text = jQuery(val).find("div").text().trim();
                if(text !== '')
                {
                    value.push(text)
                }
            })
        }else if(node.type != 'radio' || node.tagName == 'A')
        {
            value = node.value;
        }
        else
        {
            value = node.parentNode.dataset.label;
            if(!value)
            {
                value = node.value;
            }
        }

        if(value)
        {
            all_inputs.append(id, value);
        }
    } );
}

jQuery(document).on('cf.validate.FormSuccess', function(event, obj) {
    jQuery('button.save_for_later').hide();
    jQuery('.fixed-meta').hide();
    jQuery('.cities-mc').hide();
    jQuery('#acolhesus_form_anexos').hide();
    jQuery('#form-accordion').hide();
});