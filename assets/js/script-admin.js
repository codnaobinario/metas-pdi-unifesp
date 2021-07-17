(function($) {
    $(document).ready(function() {
        $(document).on('focus', '.maskAno', function() {
            $(this).mask('0000');
        }).on('focus', '.maskData', function() {
            $(this).mask('00/00/0000');
        }).on('focus', '.maskNumber', function() {
            $(this).mask('#.##0', {
                reverse: true,
                maxlength: false,
                placeholder: '0',
                onKeyPress: function(v, ev, curField, opts) {
                    var mask = curField.data('mask').mask;
                    var decimalSep = (/0(.)00/gi).exec(mask)[1] || ',';
                    if (curField.data('mask-isZero') && curField.data('mask-keycode') == 8)
                        $(curField).val('');
                    else if (v) {
                        // remove previously added stuff at start of string
                        v = v.replace(new RegExp('^0*\\?0*'), ''); //v = v.replace(/^0*,?0*/, '');
                        v = v.length == 0 ? '000' : (v.length == 1 ? '00' + v : (v.length == 2 ? '0' + v : v));
                        $(curField).val(v).data('mask-isZero', (v == '000'));
                    }
                }
            });
        }).on('focus', '.maskValor', function() {
            $(this).mask('#.##0,00', {
                reverse: true,
                maxlength: false,
                placeholder: '0,00',
                onKeyPress: function(v, ev, curField, opts) {
                    var mask = curField.data('mask').mask;
                    var decimalSep = (/0(.)00/gi).exec(mask)[1] || ',';
                    if (curField.data('mask-isZero') && curField.data('mask-keycode') == 8)
                        $(curField).val('');
                    else if (v) {
                        // remove previously added stuff at start of string
                        v = v.replace(new RegExp('^0*\\' + decimalSep + '?0*'), ''); //v = v.replace(/^0*,?0*/, '');
                        v = v.length == 0 ? '0' + decimalSep + '00' : (v.length == 1 ? '0' + decimalSep + '0' + v : (v.length == 2 ? '0' + decimalSep + v : v));
                        $(curField).val(v).data('mask-isZero', (v == '0' + decimalSep + '00'));
                    }
                }
            });
        });

        $(document).on('click', '.add-indicadores-anos', function() {
            $('ul#indicadores-anos').append(indicadoresAnos.newBloco());
        }).on('click', '.remove-indicador', function() {
            indicadoresAnos.remove($(this));
        }).on('click', '.add-objetivo-especifico', function() {
            $('ul#objetivo-especifico').append(objetivoEspecifico.newBloco());
        }).on('click', '.remove-objetivo-especifico', function() {
            objetivoEspecifico.remove($(this));
        });
        $(document).on('keyup', '.input-objetivo-especifico', function() {
            pdi.searchObjetivoEspecifico($(this))
        }).on('click', 'ul.list-objetivo-especifico li', function() {
            const li = $(this).closest('li.blocos-objetivo-especifico'),
                input = li.find('input');
            input.val($(this).text()).attr('data-input-save', false);
            li.find('.dropdown-objetivo-especifico').fadeOut();
        });

        $(document).on('change', '#indicador-meta', function() {
            /* if (!$(this).val()) {
                $('#ano-acao').html('<option value="">Selecione o Indicador Meta</option>');
            } else {
                pdi.loadSelectAnoAcao($(this).val(), $('#ano-acao'));
            } */
        })

        $(document).on('click', function(event) {
            if ($('ul.list-objetivo-especifico li').length) {
                if (!$(event.target).is("ul.list-objetivo-especifico li")) {
                    $('.dropdown-objetivo-especifico').fadeOut();
                }
            }

        });

        $(document).on('click', '.add-indicador-meta', function() {
            pdi.saveMetas($(this));
        }).on('click', '.add-acoes', function() {
            pdi.saveAcoes($(this));
        }).on('change', '.admin-filter-acoes', function() {
            pdi.filterAcoes($(this));
        }).on('change', '.admin-filter-metas', function() {
            pdi.filterMeta($(this));
        }).on('change', '.admin-filter-ouse', function() {
            pdi.filterObjetivosOuse($(this));
        }).on('click', '.update-indicador-meta', function() {
            pdi.updateMeta($(this));
        }).on('click', '.update-acoes', function() {
            pdi.updateAcao($(this));
        });

        $(document).on('click', '.add-user-permission', function() {
            usersPermission.add($(this));
        }).on('click', '.delete-permission', function() {
            usersPermission.remove($(this));
        })

        $(document).on('change', 'select#grande-tema', function() {
            pdi.loadObjetivosOuse($(this), $('select#objetivo-ouse'));
        })

        $(document).on('click', '.btn-remove-indicador', function() {
            if (confirm("Você tem certeza que deseja excluir esta Meta? \n Ela não poderá ser recuperada.")) {
                pdi.removeIndicador($(this), $('.load-table'));
            } else {
                return false;
            }
        }).on('click', '.btn-status-indicador', function() {
            pdi.editStatusIndicador($(this), $('.load-table'));
        }).on('click', '.btn-remove-acao', function() {
            if (confirm("Você tem certeza que deseja excluir esta Ação? \n Ela não poderá ser recuperada.")) {
                pdi.removeAcao($(this), $('.load-table'));
            } else {
                return false;
            }
        }).on('click', '.btn-status-acao', function() {
            pdi.editStatusAcao($(this), $('.load-table'));
        })

        $(document).on('click', '.btn-import-metas', function() {
            var form = $('form#import-metas');
            if ($('input[name=file_import_metas]').get(0).files.length === 0) {

            } else {
                if (confirm("Você tem certeza que gostaria de importar Metas? \n Esta ação removerá os seus dados e irá substituir pelos novos.")) {
                    form.submit();
                } else {
                    return false;
                }
            }
        }).on('click', '.btn-import-acoes', function() {
            var form = $('form#import-acoes');
            if ($('input[name=file_import_acoes]').get(0).files.length === 0) {

            } else {
                if (confirm("Você tem certeza que gostaria de importar Ações? \n Esta ação removerá os seus dados e irá substituir pelos novos.")) {
                    form.submit();
                } else {
                    return false;
                }
            }
        })




    });
})(jQuery);