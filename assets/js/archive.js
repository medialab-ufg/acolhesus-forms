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
    
    $('#close_form').click(function () {
        var r = confirm("Deseja realmente fechar a edição deste formulário?");
        if(r) {
            var data = {action: 'acolhesus_lock_form', type: $('#current_post_type').val() };
            $.post(acolhesus.ajax_url, data);
        }
    });

    $('.lock_form_entries').click(function () {

        var msg = 'Fechar a edição para ' + $(this).attr('data-txt') + ' ?';
        var post_id = $(this).attr('data-id');
        swal({ title: msg,
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Fechar edição",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            },
            function(isConfirm) {
            if(isConfirm) {
                console.log('postado ... ' + post_id);
                var data = {
                    action: 'lock_single_form',
                    form_id: post_id
                };
                $.post(acolhesus.ajax_url, data);
            }
        });
    });

    $('.unlock_form_entries').click(function () {
        var msg = 'Abrir a edição para ' + $(this).attr('data-txt') + ' ?';
        var post_id = $(this).attr('data-id');
        swal({ title: msg,
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Abrir edição",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            },
            function(isConfirm) {
                if(isConfirm) {
                    console.log('postado ... ' + post_id);
                    var data = {
                        action: 'unlock_single_form',
                        form_id: post_id
                    };
                    $.post(acolhesus.ajax_url, data);
                }
            });
    });

});

