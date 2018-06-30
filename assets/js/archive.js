jQuery( function( $ ) {
    $('.add_acolhesus_entry').click(function() {
        var post_title = $(this).attr('data-newTitle');
        var post_type  = $(this).attr('data-postType');

        var data = {
            title: post_title,
            action: 'acolhesus_add_form_entry',
            type: post_type
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
    
    $('#close_form').click(function () {
        var r = confirm("Deseja realmente fechar a edição deste formulário?");
        if(r) {
            var data = {action: 'acolhesus_lock_form', type: $('#current_post_type').val() };
            $.post(acolhesus.ajax_url, data);
        }
    });

    $_forms_ = '.acolhesus-forms-list';
    $_filters = '.acolhesus-filtros';
    $($_forms_).accordion(getAccordionConfig());
    $($_filters).accordion(getAccordionConfig());

    if ($( $_forms_ ).hasClass('filtered')) {
        $($_forms_).accordion("option", {"active": 0});
        $($_filters).accordion("option", {"active": 0});
    }

    $('.toggle_lock_form_entries').click(function () {
        var entry = {
            id:     $(this).attr('data-id'),
            status: $(this).attr('data-status'),
            txt:    $(this).attr('data-txt')
        };

        var msg = entry.status + ' ' +  entry.txt + ' ?';
        var class_map = {'Validar formulário': 'danger', 'Abrir edição': 'info'};

        swal({ title: msg,
                showCancelButton: true,
                confirmButtonClass: "btn-" + class_map[entry.status],
                confirmButtonText: entry.status,
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            },
            function(isConfirm) {
            if(entry.id && entry.status && isConfirm) {
                var data = {
                    action: 'toggle_lock_single_form',
                    form_id: entry.id
                };
                $.post(acolhesus.ajax_url, data).success(function(res) {
                    var r = JSON.parse(res);
                    if (r.success) {
                        swal({ title: r.success });
                        toggleEntryStatus(entry.id,r.list);
                    }
                });
            }
        });
    });

    function toggleEntryStatus(_id, new_data) {
        if(new_data.status && new_data.button) {
            $(".status-" + _id + " span").attr('class', new_data.status.class).text(new_data.status.status);
            $("a#entry-" + _id).removeClass()
                .addClass('toggle_lock_form_entries entry-status btn btn-'+new_data.button.class)
                .text(new_data.button.text).attr('data-status', new_data.button.text);
        }
    }

    function getAccordionConfig() {
        var icons = {
            header: "ui-icon-circle-arrow-e",
            activeHeader: "ui-icon-circle-arrow-s"
        };
        return {
            collapsible: true,
            active: false,
            heightStyle: "content",
            icons: icons
        };
    }


    $('.acolhesus_filter_forms').select2({width: '100%'});

});

