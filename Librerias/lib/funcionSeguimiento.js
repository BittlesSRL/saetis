$(document).on('ready', function() {
    

    $(document).on('click', '#SeguimientoSemanal', function(e) {
        
        e.preventDefault();
        $('#page-wrapper').load('VistaSeguimientoSemanal.php');
    });


    $(document).on('click', '.btnRegistroAsistenciaSemanal', function() {

        var funcion = 'registrar asistencia';
        var fila = $(this).parents().get(1);
        var usuario = $(fila).data('usuario');
        $('.modalRegistroAsistencia').find('.modal-body').load('VistaModalSeguimientoSemanal.php', {
            funcion:funcion,
            usuario:usuario
        });
        $('.modalRegistroAsistencia').modal('show');
    });

     $(document).on('click', '.btnRegistroReportesSemanal', function() {

        var funcion = 'registrar reportes';
        var fila = $(this).parents().get(1);
        var usuario = $(fila).data('usuario');
        $('.modalRegistroReportes').find('.modal-body').load('VistaModalSeguimientoSemanal.php', {
            funcion:funcion,
            usuario:usuario
        });
        $('.modalRegistroReportes').modal('show');
    });

      $(document).on('click', '.btnSeguimientoSemanal', function() {

        var funcion = 'registrar seguimiento';
        var fila = $(this).parents().get(1);
        var usuario = $(fila).data('usuario');
        $('.modalSeguimiento').find('.modal-body').load('VistaModalSeguimientoSemanal.php', {
            funcion:funcion,
            usuario:usuario
        });
        $('.modalSeguimiento').modal('show');
    });
});

function registrarAsistenciaSemanal(){

    $("#registroAsistencia").find("form")
        .bootstrapValidator({
            excluded: ":disabled",
            submitHandler: function(validator, form, submitButton) {
                var funcion = 'registrar asistencia';
                var codigos = new Array();
                var socios = new Array();
                var asistencias = new Array();
                var grupoE = $("#registroAsistencia").data("grupoe")

                $("#registroAsistencia form table tbody tr").each(function() {

                    $(this).children("td").each(function(index) {
                        switch (index) {
                            case 0:
                                codigos.push($(this).text());
                                break;
                            case 1:
                                socios.push($(this).text());
                                break;
                            case 2:
                                var codigo = $($(this).parents().get(0)).data("codigo");
                                asistencias.push(validator.getFieldElements("Asistencia"+codigo).filter(":checked").val());
                                break;
                        }
                    });

                    
                });
                $.post('../Controlador/RegistrarSeguimientoSemanal.php', {
                    grupoE:grupoE,
                    funcion:funcion,
                    codigos:codigos.join(),
                    socios:socios.join(),
                    asistencias:asistencias.join()
                });

                $('.modalRegistroAsistencia').modal('hide');
                $('#registroAsistencia').find('form').bootstrapValidator('destroy');
                $('.modalRegistroAsistencia').find('.modal-body').empty();
          }
      });
}

function registrarSeguimientoSemanal(){

    $("#registroSeguimiento").find("form")
        .bootstrapValidator({
            excluded: ":disabled",
            submitHandler: function(validator, form, submitButton) {
                var funcion = 'registrar seguimiento';
               
                var grupoE = $("#registroSeguimiento").data("grupoe")

             
               
          }
      });
}

function registrarReportesSemanal() {

    $('#registroReportes').find('form')
        .bootstrapValidator({
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            submitHandler: function(validator, form, submitButton) {
                var funcion = 'registrar reportes';
                var roles = new Array();
                var actividades = new Array();
                var hechos = new Array();
                var resultados = new Array();
                var conclusiones = new Array();
                var observaciones = new Array();
                var grupoE = $("#registroReportes").data("grupoe")

                $("#registroReportes form table tbody tr").each(function() {
                    var rol = $(this).find('td').eq(0).text();
                    roles.push(rol);
                    $(this).children("td").each(function(index) {
                        switch (index) {
                            case 1:
                                actividades.push(validator.getFieldElements(rol+'Actividades').val());
                                break;
                            case 2:
                                hechos.push(validator.getFieldElements(rol+'Hecho').filter(":checked").val());
                                break;
                            case 3:
                                resultados.push(validator.getFieldElements(rol+'Resultados').val());
                                break;
                            case 4:
                                conclusiones.push(validator.getFieldElements(rol+'Conclusiones').val());
                                break;
                            case 5:
                                observaciones.push(validator.getFieldElements(rol+'Observaciones').val());
                                break;
                        }
                    });
                });
                $.post('../Controlador/RegistrarSeguimientoSemanal.php', {
                    grupoE:grupoE,
                    funcion:funcion,
                    roles:roles.join(),
                    actividades:actividades.join(),
                    hechos:hechos.join(),
                    resultados:resultados.join(),
                    conclusiones:conclusiones.join(),
                    observaciones:observaciones.join()
                });
                $('.modalRegistroReportes').modal('hide');
                $('#registroRol').find('form').bootstrapValidator('destroy');
                $('#registroReportes').find('form').bootstrapValidator('destroy');
                $('.modalRegistroReportes').find('.modal-body').empty();
            }
        });

    $('#registroRol').find('form')
        .bootstrapValidator({
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            submitHandler: function(validator, form, submitButton) {
                if (validator.isValid()) {
                    
                    var rol = validator.getFieldElements('roles').val();
                    var registro = '<tr>'+
                                       '<td class="col-md-2">'+rol+'</td>'+
                                       '<td class="col-md-2">'+
                                           '<div class="form-group">'+
                                               '<div class="col-md-12">'+
                                                   '<textarea class="form-control" rows="4" name="'+rol+'Actividades"></textarea>'+
                                               '</div>'+
                                           '</div>'+
                                       '</td>'+
                                       '<td class="col-md-1">'+
                                           '<div class="form-group">'+
                                               '<div class="col-md-12" style="padding-left: 0">'+
                                                   '<div class="radio">'+
                                                       '<label><input type="radio" name="'+rol+'Hecho" value="si" /> si</label>'+
                                                   '</div>'+
                                                   '<div class="radio">'+
                                                       '<label><input type="radio" name="'+rol+'Hecho" value="no" /> no</label>'+
                                                   '</div>'+
                                               '</div>'+
                                           '</div>'+
                                       '</td>'+
                                       '<td class="col-md-2">'+
                                           '<div class="form-group">'+
                                               '<div class="col-md-12">'+
                                                   '<textarea class="form-control" rows="4" name="'+rol+'Resultados"></textarea>'+
                                               '</div>'+
                                           '</div>'+
                                       '</td>'+
                                       '<td class="col-md-2">'+
                                           '<div class="form-group">'+
                                               '<div class="col-md-12">'+
                                                   '<textarea class="form-control" rows="4" name="'+rol+'Conclusiones"></textarea>'+
                                               '</div>'+
                                           '</div>'+
                                       '</td>'+
                                       '<td class="col-md-2">'+
                                           '<div class="form-group">'+
                                               '<div class="col-md-12">'+
                                                   '<textarea class="form-control" rows="4" name="'+rol+'Observaciones"></textarea>'+
                                               '</div>'+
                                           '</div>'+
                                       '</td>'+
                                       '<td class="col-md-1" align="center">'+
                                           '<button class="btn btn-xs btn-danger btnBorrarReporte">'+
                                               '<i class="fa fa-times"></i>'+
                                           '</button>'+
                                       '</td>'+
                                   '</tr>';
                    var contenido = $('#registroReportes').find('table').find('tbody');
                    $(contenido).append(registro);
                    if ($(contenido).find('tr').length == 1) {
                        $('#registroReportes').show();
                        $('#btnCancelarRol').show();
                    }
                    if ($('#registroRol').find('form').find('[name="roles"]').find('option').length == 1) {
                        $('#btnAgregarRol').hide();
                    }
                    $('#registroRol').hide();
                    $('#registroReportes').find('legend').text('Registro de reportes');
                    $('#registroReportes').find('form').children().show();
                    $('option[value="'+rol+'"]', $('#registroRol').find('form').find('[name="roles"]')).remove();
                    $('#registroRol').find('form').find('[name="roles"]').multiselect('rebuild');

                    $('#registroReportes').find('form')
                        .bootstrapValidator('addField', rol+'Actividades', {
                            container: 'tooltip',
                            validators: {
                                notEmpty: {
                                    message: 'Las actividades es un dato requerido'
                                },
                                stringLength: {
                                    max: 50,
                                    message: 'Las actividades deben ser menor o igual a 50 caracteres'
                                }
                            }
                        })   
                        .bootstrapValidator('addField', rol+'Hecho', {
                            container: 'tooltip',
                            validators: {
                                notEmpty: {
                                    message: 'Seleccione una opcion'
                                }
                            }
                        })
                        .bootstrapValidator('addField', rol+'Resultados', {
                            container: 'tooltip',
                            validators: {
                                notEmpty: {
                                    message: 'Los resultados es un dato requerido'
                                },
                                stringLength: {
                                    max: 50,
                                    message: 'Los resultados deben ser menor o igual a 50 caracteres'
                                }
                            }
                        })
                        .bootstrapValidator('addField', rol+'Conclusiones', {
                            container: 'tooltip',
                            validators: {
                                notEmpty: {
                                    message: 'Las conclusiones es un dato requerido'
                                },
                                stringLength: {
                                    max: 50,
                                    message: 'Las conclusiones deben ser menor o igual a 50 caracteres'
                                }
                            }
                        })
                        .bootstrapValidator('addField', rol+'Observaciones', {
                            container: 'tooltip',
                            validators: {
                                notEmpty: {
                                    message: 'Las observaciones es un dato requerido'
                                },
                                stringLength: {
                                    max: 50,
                                    message: 'Las observaciones deben ser menor o igual a 50 caracteres'
                                }
                            }
                        });

                        $('#registroReportes').find('form')

                            .find('[name="'+rol+'Hecho"]')
                                .iCheck({
                                    checkboxClass: 'icheckbox_square-green',
                                    radioClass: 'iradio_square-green'
                                })
                                .on('ifChanged', function(e) {
                                    var field = $(this).attr('name');

                                    $('#registroReportes').find('form')
                                        .bootstrapValidator('updateStatus', field, 'NOT_VALIDATED')
                                        .bootstrapValidator('validateField', field);
                                });
                }
            },
            fields: {
                roles: {
                    container: 'popover',
                    validators: {
                        callback: {
                            message: 'El rol es un dato requerido, seleccione uno',
                            callback: function(value, validator) {
                                          var options = validator.getFieldElements('roles').val();
                                          return (options && options.length >= 1);
                                      }
                        }
                    }
                }
            }
        })
        .find('[name="roles"]')
            .multiselect({
                buttonWidth: '195px',
                buttonText: function(options) {
                    if (options.length == 0) {
                        return 'Seleccione un rol <b class="caret"></b>';
                    }
                    else {
                        var selected = '';
                        options.each(function() {
                            selected += $(this).text() + ', ';
                        });
                        return selected.substr(0, selected.length - 2) + ' <b class="caret"></b>';
                    }
                },
                onChange: function(element, checked) {
                    var selected = 0;
                    $('option', $('#registroRol').find('form').find('[name="roles"]')).each(function() {
                        if ($(this).prop('selected')) {
                            selected++;
                        }
                    });
                    if (selected >= 1) {
                        $('#registroRol').find('form').find('[name="roles"]').siblings('div').children('ul').dropdown('toggle');
                    }
                    var values = new Array();
                    $('#registroRol').find('form').find('[name="roles"]').find('option').each(function() {
                        if ($(this).val() !== element.val()) {
                            values.push($(this).val());
                        }
                    });
                    $('#registroRol').find('form').find('[name="roles"]').multiselect('deselect', values);
                    $('#registroRol').find('form')
                        .data('bootstrapValidator')
                        .updateStatus('roles', 'NOT_VALIDATED')
                        .validateField('roles');
                }
            });
    
    $(document).on('click', '.btnBorrarReporte', function() {
        var cuerpo = $(this).parents().get(2);
        if ($(cuerpo).find('tr').length == 1) {
            $('#registroReportes').hide();
            multiselect_deselectAll($('#registroRol').find('form').data('bootstrapValidator').getFieldElements('roles'));
            $('#registroRol').find('form').data('bootstrapValidator').resetForm(true);
            $('#registroRol').show();
            $('#btnCancelarRol').hide();
        }
        if ($('#registroRol').find('form').find('[name="roles"]').find('option').length == 0) {
            $('#btnAgregarRol').show();
        }
        var fila = $(this).parents().get(1);
        var rol = $(fila).find('td').eq(0).text();
        $('#registroRol').find('form').find('[name="roles"]').append('<option value="' + rol + '">' + rol + '</option>');
        $('#registroRol').find('form').find('[name="roles"]').multiselect('rebuild');
        $(fila).remove();
    });

    $(document).on('click', '#btnCancelarRol', function() {
        $('#registroRol').hide();
        $('#registroReportes').show();
        $('#registroReportes').find('legend').text('Registro de reportes');
        $('#registroReportes').find('form').children().show();
    });

    $(document).on('click', '#btnAgregarRol', function() {
        $('html, body').animate({scrollTop: 0}, 100);
        multiselect_deselectAll($('#registroRol').find('form').data('bootstrapValidator').getFieldElements('roles'));
        $('#registroRol').find('form').data('bootstrapValidator').resetForm(true);        
        $('#registroRol').show();
        $('#registroReportes').find('form').find('legend').text('Reportes');
        $('#registroReportes').find('form').children().not('table, legend').hide();
    });
}