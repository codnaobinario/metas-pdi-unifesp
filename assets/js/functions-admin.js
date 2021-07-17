var pdi = {
    ajaxInit: function(data = null) {
        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                loadBlock.add(form);
            },
            complete: function() {
                loadBlock.remove();
            },
            success: function(response) {
                //console.log(response);
                return response;
            }
        })
    },
    saveAcoes: function(btn) {
        const form = btn.closest('form');
        const data = {
            action: 'pdi_save_new_acao',
            form: form.serialize(),
        }

        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                loadBlock.add(form);
            },
            complete: function() {
                loadBlock.remove();
            },
            success: function(response) {
                if (response.status == true) toastr.success('Ação salva!');
                location.reload();
            }
        });
    },
    updateAcao: function(btn) {
        const form = btn.closest('form');
        const data = {
            action: 'pdi_update_acao',
            form: form.serialize(),
        }

        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                loadBlock.add(form);
            },
            complete: function() {
                loadBlock.remove();
            },
            success: function(response) {
                if (response.status == true) toastr.success('Ação atualizada!');
                //console.log(response);
                location.reload();
            }
        });
    },
    saveMetas: function(btn) {
        const form = btn.closest('form');
        const data = {
            action: 'pdi_save_meta',
            form: form.serialize(),
        }

        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                loadBlock.add(form);
            },
            complete: function() {
                loadBlock.remove();
            },
            success: function(response) {
                if (response.status == true) toastr.success('Meta salva!');
                //console.log(response);
                location.reload();
            }
        });
    },
    updateMeta: function(btn) {
        const form = btn.closest('form');
        const data = {
            action: 'pdi_update_meta',
            form: form.serialize(),
        }

        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                loadBlock.add(form);
            },
            complete: function() {
                loadBlock.remove();
            },
            success: function(response) {
                if (response.status == true) toastr.success('Meta atualizada!');
                //console.log(response);
                //location.reload();
            }
        });
    },
    filterMeta: function(select) {
        const form = select.closest('form'),
            table = jQuery('.load-table'),
            data = {
                action: 'pdi_filter_metas',
                form: form.serialize(),
            };
        table.find('table').remove();
        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {

            },
            complete: function() {

            },
            success: function(response) {
                //console.log(response);
                table.html(response.html);
            }
        });
    },
    filterAcoes: function(select) {
        const form = select.closest('form'),
            table = jQuery('.load-table'),
            data = {
                action: 'pdi_filter_acao',
                form: form.serialize(),
            };
        table.find('table').remove();
        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {

            },
            complete: function() {

            },
            success: function(response) {
                table.html(response.html);
            }
        });
    },
    filterObjetivosOuse: function(select) {
        const form = select.closest('form'),
            table = jQuery('.load-table'),
            data = {
                action: 'pdi_filter_objetivos_ouse',
                form: form.serialize(),
            };
        table.find('table').remove();
        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {

            },
            complete: function() {

            },
            success: function(response) {
                table.html(response.html);
            }
        });
    },
    searchObjetivoEspecifico: function(input) {
        const valor = input.val();

        if (valor.length < 3) {
            input.closest('ul#objetivo-especifico').find('.dropdown-objetivo-especifico').fadeOut().find('ul').remove();

            return false;
        }
        var data = {
            action: 'pdi_search_objetivo_especifico',
            valor: valor,
        };

        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {

            },
            complete: function() {

            },
            success: function(response) {
                objetivoEspecifico.resultSearch(input, response.retorno);
            }
        });

    },
    loadSelectAnoAcao: function(indicador_id, local) {
        var data = {
            action: 'pdi_load_select_ano_acoes',
            indicador_id: indicador_id,
        };
        //console.log(data);

        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'html',
            beforeSend: function() {

            },
            complete: function() {

            },
            success: function(response) {
                local.html(response);
            }
        });

    },
    loadObjetivosOuse: function(select, local) {
        var gt_id = select.val();

        if (!gt_id) {
            local.html('<option value="">Selecione o Grande Tema</option>').attr('disabled', true);
            return false;
        }

        data = {
            action: 'pdi_loaad_objetivos_ouse',
            grande_tema_id: gt_id,
        }

        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'html',
            beforeSend: function() {

            },
            complete: function() {

            },
            success: function(response) {
                local.html(response);
                local.attr('disabled', false);
            }
        });
    },
    removeIndicador: function(btn, local) {
        var id = btn.attr('data-indicador-id'),
            form = jQuery('form#pdi-admin-filter-metas');

        var data = {
            action: 'pdi_remove_indicador',
            indicador_id: id,
            form: form.serialize(),
        }

        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {

            },
            complete: function() {

            },
            success: function(response) {
                local.html(response.html);
            }
        });
    },
    editStatusIndicador: function(btn, local) {
        var id = btn.attr('data-indicador-id'),
            status = btn.attr('data-indicador-status'),
            form = jQuery('form#pdi-admin-filter-metas');

        var data = {
            action: 'pdi_indicador_edit_active',
            indicador_id: id,
            status: status,
            form: form.serialize(),
        }

        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {

            },
            complete: function() {

            },
            success: function(response) {
                local.html(response.html);
            }
        });
    },
    removeAcao: function(btn, local) {
        var id = btn.attr('data-acao-id'),
            form = jQuery('form#pdi-admin-filter-acoes');

        var data = {
            action: 'pdi_remove_acao',
            acao_id: id,
            form: form.serialize(),
        }

        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {

            },
            complete: function() {

            },
            success: function(response) {
                local.html(response.html);
            }
        });
    },
    editStatusAcao: function(btn, local) {
        var id = btn.attr('data-acao-id'),
            status = btn.attr('data-acao-status'),
            form = jQuery('form#pdi-admin-filter-acoes');

        var data = {
            action: 'pdi_acao_edit_active',
            acao_id: id,
            status: status,
            form: form.serialize(),
        }

        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {

            },
            complete: function() {

            },
            success: function(response) {
                local.html(response.html);
            }
        });
    }

}

var usersPermission = {
    add: function(btn) {
        var form = btn.closest('form');
        var data = {
            action: 'pdi_add_users_permission',
            form: form.serialize(),
        };

        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                loadBlock.add(form);
            },
            complete: function() {
                loadBlock.remove();
            },
            success: function(response) {
                console.log(response)
                usersPermission.reloadTable(jQuery('.pdi-box-premmission'));
            }
        });
    },
    remove: function(btn) {
        var user_id = btn.attr('data-user-id');
        var data = {
            action: 'pdi_remove_users_permission',
            user_id: user_id,
        };

        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                loadBlock.add(jQuery('.pdi-box-premmission'));
            },
            complete: function() {
                loadBlock.remove();
            },
            success: function(response) {
                console.log(response)
                usersPermission.reloadTable(jQuery('.pdi-box-premmission'));
            }
        });
    },
    reloadTable: function(local) {
        var data = {
            action: 'pdi_reload_table_users_permission',
        };
        jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            data: data,
            dataType: 'html',
            beforeSend: function() {

            },
            complete: function() {

            },
            success: function(response) {
                local.html(response);
            }
        });
    }
}

var adinImport = {
    import: function(btn) {
        var form = btn.closest('form#import-full');
        console.log(form);

        var formData = new FormData(form[0]);
        formData.append('action', 'pdi_import_xls');

        console.log(formData);
        /* var data = {
            action: 'pdi_import_xls',
            arquivo: formData,
        } */
        /* jQuery.ajax({
            type: 'POST',
            url: pdi_options_object.ajaxurl,
            //data: form.serialize() + '&action=' + action + '&conteudo=' + encodeURIComponent(conteudo),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            xhr: function() { // Custom XMLHttpRequest
                var myXhr = jQuery.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function() {}, false);
                }
                return myXhr;
            },
            beforeSend: function() {

            },
            complete: function() {

            },
            success: function(response) {
                response = JSON.parse(response);
                console.log(response);
            }
        }); */
    }
}

var indicadoresAnos = {
    remove: function(btn) {
        var ul = btn.closest('ul');
        btn.closest('li').remove();
        if (btn.attr('data-id-ano-indicador') !== 'undefined') {
            ul.append('<input type="hidden" name="remove_ano_id[]" value="' + btn.attr('data-id-ano-indicador') + '" >');
        }

    },
    newBloco: function() {
        return '<li class="blocos-indicadores-anos"><div class="line-indicadores-anos"><label for="">Ano</label><input type="text" name="ano_meta[]" class="form-control maskAno"></div><div class="line-indicadores-anos"><label for="">Valor</label><input type="text" name="valor_ano_meta[]" class="form-control maskValor"></div><div class="line-indicadores-anos"><label for="">Valor Previsto</label><input type="text" name="valor_previsto_ano_meta[]" class="form-control maskValor"></div><div class="line-indicadores-anos"><label for="">Data do Registro</label><input type="text" name="data_registro_ano_meta[]" class="form-control  maskData"></div><div class="line-indicadores-anos"><label for="">Justificativa</label><input type="text" name="justificativa_ano_meta[]" class="form-control"></div><div class="line-indicadores-anos"><a class="remove-indicador" title="Remover"><span class="dashicons dashicons-trash text-danger"></span></a></div></li>';
    }
}

var objetivoEspecifico = {
    remove: function(btn) {
        btn.closest('li').remove();
    },
    newBloco: function() {
        return '<li class="blocos-objetivo-especifico"><input type="text" name="objetivo_especifico[]" class="form-control input-objetivo-especifico" data-input-save="true" /><div class="dropdown-objetivo-especifico" style="display: none;"></div><a class="remove-objetivo-especifico ml-3" title="Remover"><span class="dashicons dashicons-trash text-danger"></span></a></li>';
    },
    resultSearch: function(input, data) {
        const local = input.closest('li').find('.dropdown-objetivo-especifico');
        if (!data || !data.length) {
            local.find('ul').remove();
            local.fadeOut();
            return false;
        }

        local.find('ul').remove();
        local.append('<ul class="list-objetivo-especifico"></ul>');

        jQuery.each(data, function(i, e) {
            if (e.active != 0) {
                local.find('ul').append('<li data-id="' + e.id + '">' + e.descricao + '</li>')
            }
        });

        local.fadeIn();

    }

}

var loadBlock = {
    add: function(local) {
        local.append('<div class="load-form"><i class="fas fa-cog fa-spin"></i>Aguarde...</div>');
    },
    remove: function() {
        jQuery('.load-form').remove();
    }
}