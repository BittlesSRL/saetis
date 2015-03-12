$(document).on('ready', function() {
    $.ajaxPrefilter( "json script", function( options ) {
        options.crossDomain = true;
    });  

    $(document).on('click', '#registrarPlanificacion', function(e) {
        e.preventDefault();
        $('#page-wrapper').load('vistaRegistrarPlanificacion.php');
    });
    
    $(document).on('click', '#Seguimiento', function(e) {
        e.preventDefault();
        $('#page-wrapper').load('VistaSeguimiento.php');
    });

    $(document).on('click', '.btnRegistroAsistencia', function() {
        var funcion = 'registrar asistencia';
        var fila = $(this).parents().get(1);
        var registro = $(fila).data('registro');
        $('.modalRegistroAsistencia').find('.modal-body').load('VistaModalSeguimiento.php', {
            funcion:funcion,
            registro:registro
        });
        $('.modalRegistroAsistencia').modal('show');
    }); 

    $(document).on('click', '.btnRegistroReportes', function() {
        var funcion = 'registrar reportes';
        var fila = $(this).parents().get(1);
        var registro = $(fila).data('registro');
        $('.modalRegistroReportes').find('.modal-body').load('VistaModalSeguimiento.php', {
            funcion:funcion,
            registro:registro
        });
        $('.modalRegistroReportes').modal('show');
    });
});

function registrarAsistencia(){
    $("#registroAsistencia").find("form")
        .bootstrapValidator({
            excluded: ":disabled",
            submitHandler: function(validator, form, submitButton) {
                var funcion = 'registrar asistencia';
                var registro = $('#registroAsistencia').data('registro');
                var codigos = new Array();
                var socios = new Array();
                var asistencias = new Array();
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
                $.post('../Controlador/RegistrarSeguimiento.php', {
                    funcion:funcion,
                    registro:registro,
                    codigos:codigos.join(),
                    socios:socios.join(),
                    asistencias:asistencias.join()
                });
                $('.modalRegistroAsistencia').modal('hide');
                $('#registroAsistencia').find('form').bootstrapValidator('destroy');
                $('.modalRegistroAsistencia').find('.modal-body').empty();
                $('#btnAsistencia'+registro).attr("disabled", true);
          }
      });
}

function registrarReportes() {
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
                var registro = $('#registroReportes').data('registro');
                var roles = new Array();
                var actividades = new Array();
                var hechos = new Array();
                var resultados = new Array();
                var conclusiones = new Array();
                var observaciones = new Array();
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
                $.post('../Controlador/RegistrarSeguimiento.php', {
                    funcion:funcion,
                    registro:registro,
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
                $('#btnReportes'+registro).attr("disabled", true);
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

function registrarPlanificacion() {
    $('#registroActividadPlanificacion').find('form')
        .bootstrapValidator({
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            submitHandler: function(validator, form, submitButton) {
                if (validator.isValid()) {
                    var actividad = validator.getFieldElements('actividad').val();
                    var fecha = validator.getFieldElements('fecha').val();
                    var registro = '<tr>'+
                                       '<td>'+actividad+'</td>'+
                                       '<td>'+fecha+'</td>'+
                                       '<td align="center">'+
                                           '<button class="btn btn-xs btn-danger btnBorrarActividadPlanificacion">'+
                                               '<i class="fa fa-times"></i>'+
                                           '</button>'+
                                       '</td>'+
                                   '</tr>';
                    var contenido = $('#registroPlanificacion').find('table').find('tbody');
                    $(contenido).append(registro);
                    if ($(contenido).find('tr').length == 1) {
                        $('#registroPlanificacion').show();
                        $('#btnCancelarActividadPlanificacion').show();
                    }
                    $('#registroActividadPlanificacion').hide();
                    $('#registroPlanificacion').find('legend').text('Registro de planificacion');
                    $('#registroPlanificacion').children().show();
                    var actividades = $('#registroPlanificacion').data('actividades').split(',');
                    actividades.push(actividad);
                    $('#registroPlanificacion').data('actividades', actividades.join());
                }
            },
            fields: {
                actividad: {
                    validators: {
                        diferenteActividadPlanificacion: {
                            message: 'Este nombre de actividad ya esta siendo usado'
                        },
                        notEmpty: {
                            message: 'El nombre de la actividad es un dato requerido'
                        },
                        stringLength: {
                            max: 20,
                            message: 'El nombre de la actividad debe ser menor o igual a 20 caracteres'
                        }
                    }
                },
                fecha: {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de la actividad es un dato requerido'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'La fecha no es valida'
                        }
                    }
                }
            }
        });

    var f = new Date();
    $(".form_datetime").datetimepicker({
        format: 'yyyy-mm-dd',
        startDate: f.getFullYear() + "-" + ("0" + (f.getMonth() + 1)).slice(-2) + "-" + ("0" + f.getDate()).slice(-2),
        endDate: "2014-06-30",
        autoclose: true,
        minView: 2,
        todayBtn: true,
        todayHighlight: true,
        language: 'es'
    });
    
    $('.form_datetime').on('changeDate', function() {
        $('#registroActividadPlanificacion').find('form')
            .data('bootstrapValidator')
            .updateStatus('fecha', 'NOT_VALIDATED')
            .validateField('fecha');
    });

    $(document).on('click', '.btnBorrarActividadPlanificacion', function() {
        var cuerpo = $(this).parents().get(2);
        if ($(cuerpo).find('tr').length == 1) {
            $('#registroPlanificacion').hide();
            $('#registroActividadPlanificacion').find('form').data('bootstrapValidator').resetForm(true);
            $('#registroActividadPlanificacion').show();
            $('#btnCancelarActividadPlanificacion').hide();
        }
        var fila = $(this).parents().get(1);
        var actividades = $('#registroPlanificacion').data('actividades').split(',');          
        var actividad = actividades.indexOf($(fila).find('td:first').text());
        actividades.splice(actividad, 1);
        $('#registroPlanificacion').data('actividades', actividades.join());
      //  $(fila).remove();
    });
    
    $(document).on('click', '#btnCancelarActividadPlanificacion', function() {
        $('#registroActividadPlanificacion').hide();
        $('#registroPlanificacion').show();
        $('#registroPlanificacion').find('legend').text('Registro de planificacion');
        $('#registroPlanificacion').children().show();
    });

    $(document).on('click', '#btnAgregarActividadPlanificacion', function() {
        $('html, body').animate({scrollTop: 0}, 100);
        $('#registroActividadPlanificacion').find('form').data('bootstrapValidator').resetForm(true);
        $('#registroActividadPlanificacion').show();
        $('#registroPlanificacion').find('legend').text('Planificacion');
        $('#registroPlanificacion').children().not('table, legend').hide();
    });

    $(document).on('click', '#btnRegistrarPlanificacion', function() { 
        var actividades = new Array();
        var fechas = new Array();
        $('#registroPlanificacion table tbody tr').each(function() {
            $(this).children("td").each(function(index) {
                switch (index) {
                    case 0:
                        actividades.push($(this).text());
                        break;
                    case 1:
                        fechas.push($(this).text());
                        break;
                }
            })
        });
        $('#page-wrapper').load('../Controlador/RegistrarPlanificacion.php', {
            actividades:actividades.join(),
            fechas:fechas.join()
        });
    });
}

function registrarEntregables() {
    $('#registroEntregable').find('form')
        .bootstrapValidator({
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            submitHandler: function(validator, form, submitButton) {
                if (validator.isValid()) {
                    var entregable = validator.getFieldElements('entregable').val();
                    var descripcion = validator.getFieldElements('descripcion').val();
                    var registro = '<tr>'+
                                       '<td>'+entregable+'</td>'+
                                       '<td>'+descripcion+'</td>'+
                                       '<td align="center">'+ 
                                           '<button class="btn btn-xs btn-danger btnBorrarEntregable">'+
                                               '<i class="fa fa-times"></i>'
                                           '</button>'+
                                       '</td>'+
                                   '</tr>'; 
                    var contenido = $('#registroEntregables').find('table').find('tbody');
                    $(contenido).append(registro);
                    if ($(contenido).find('tr').length == 1) {
                        $('#registroEntregables').show();
                        $('#btnCancelarEntregable').show();
                    }
                    $('#registroEntregable').hide();
                    $('#registroEntregables').find('legend').text('Registro de entregables');
                    $('#registroEntregables').children().show();
                    var entregables = $('#registroEntregables').data('entregables').split(',');
                    entregables.push(entregable);
                    $('#registroEntregables').data('entregables', entregables.join());
                }
            },
            fields: {
                entregable: {
                    validators: {
                        diferenteEntregable: {
                            message: 'Este nombre de entregable ya esta siendo usado'
                        },
                        notEmpty: {
                            message: 'El nombre del entregable es un dato requerido'
                        },
                        stringLength: {
                            max: 20,
                            message: 'El nombre del entregable debe ser menor o igual a 20 caracteres'
                        }
                    }
                },
                descripcion: {
                    validators: {
                        notEmpty: {
                            message: 'La descripcion del entregable es un dato requerido'
                        },
                        stringLength: {
                            max: 40,
                            message: 'La descripcion del entregable debe ser menor o igual a 40 caracteres'
                        }
                    }
                }
            }
        });
    
    $(document).on('click', '.btnBorrarEntregable', function() {
        var cuerpo = $(this).parents().get(2);
        if ($(cuerpo).find('tr').length == 1) {
            $('#registroEntregables').hide();
            $('#registroEntregable').find('form').data('bootstrapValidator').resetForm(true);
            $('#registroEntregable').show();
            $('#btnCancelarEntregable').hide();
        }
        var fila = $(this).parents().get(1);
        var entregables = $('#registroEntregables').data('entregables').split(',');          
        var entregable = entregables.indexOf($(fila).find('td:first').text());
        entregables.splice(entregable, 1);
        $('#registroEntregables').data('entregables', entregables.join());
        $(fila).remove();
    });

    $(document).on('click', '#btnCancelarEntregable', function() {
        $('#registroEntregable').hide();
        $('#registroEntregables').show();
        $('#registroEntregables').find('legend').text('Registro de entregables');
        $('#registroEntregables').children().show();
    });

    $(document).on('click', '#btnAgregarEntregable', function() {
        $('html, body').animate({scrollTop: 0}, 100);
        $('#registroEntregable').find('form').data('bootstrapValidator').resetForm(true);
        $('#registroEntregable').show();
        $('#registroEntregables').find('legend').text('Entregables');
        $('#registroEntregables').children().not('table, legend').hide();
    });

    $(document).on('click', '#btnRegistrarEntregables', function() {
        var entregables = new Array();
        var descripciones = new Array();
        $('#registroEntregables table tbody tr').each(function() {
            $(this).children("td").each(function(index) {
                switch (index) {
                    case 0:
                        entregables.push($(this).text());
                        break;
                    case 1:
                        descripciones.push($(this).text());
                        break;
                }
            })
        });
        $('#page-wrapper').load('../Controlador/RegistrarPlanificacion.php', {
            entregables:entregables.join(),
            descripciones:descripciones.join()
        });
    });
}

function registrarCostoProyecto() {
    $('#registroCostoProyecto').find('form')
        .bootstrapValidator({
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            submitHandler: function(validator, form, submitButton) {
                if (validator.isValid()) {
                    var costo = validator.getFieldElements('costo').val();
                    var porcentajeA = validator.getFieldElements('porcentajeA').val();
                    $('#page-wrapper').load('../Controlador/RegistrarPlanificacion.php', {
                        costo:costo,
                        porcentajeA:porcentajeA
                    });

                }
                
            },
            fields: {
                costo: {
                    validators: {
                        notEmpty: {
                            message: 'El costo total del proyecto es un dato requerido'
                        },
                        numeric: {
                            message: 'El costo total del proyecto debe ser un dato numerico. El separador decimal es el punto (.)'
                        }
                    }
                },
                porcentajeA: {
                    validators: {
                        notEmpty: {
                            message: 'El porcentaje de aceptacion del proyecto es un dato requerido'
                        },
                        integerN: {
                            message: 'El porcentaje de aceptacion del proyecto debe ser un numero entero.'
                        },
                        porcentajeAc:{
                            message: 'El numero debe ser mayor o igual a 60 y menor o igual a 100'
                        }
                    }
                }
            }
        });
}

function registrarPlanPagos() {
    $('#registroPago').find('form')
        .bootstrapValidator({
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            submitHandler: function(validator, form, submitButton) {
                if (validator.isValid()) {
                    var actividad = validator.getFieldElements('actividades').val();
                    var fecha = validator.getFieldElements('actividades').find('[value="'+actividad+'"]').data('fecha');
                    var porcentaje = parseFloat(validator.getFieldElements('porcentaje').val());
                    var monto = parseFloat($('#registroPlanPagos').data('costo')) * (porcentaje / 100);
                    var entregables = ((String(validator.getFieldElements('entregables').val())).split(',')).join(',<br>');
                    var registro = '<tr>'+
                                       '<td>'+actividad+'</td>'+
                                       '<td>'+fecha+'</td>'+
                                       '<td>'+porcentaje+'%</td>'+
                                       '<td>'+monto+'</td>'+
                                       '<td>'+entregables+'</td>'+
                                       '<td align="center">'+
                                           '<button class="btn btn-xs btn-danger btnBorrarPago">'+
                                               '<i class="fa fa-times"></i>'+
                                           '</button>'+
                                       '</td>'+
                                   '</tr>';
                    var contenido = $('#registroPlanPagos').find('table').find('tbody');
                    $(contenido).append(registro);
                    if ($(contenido).find('tr').length == 1) {
                        $('#registroPlanPagos').show();
                        $('#btnCancelarPago').show();
                    }
                    $('#registroPago').hide();
                    $('#registroPlanPagos').find('legend').text('Registro de plan de pagos');
                    var max = $('#registroPlanPagos').data('max');
                    var min = $('#registroPlanPagos').data('min');
                    max = max - porcentaje;
                    $('#registroPlanPagos').data('max', max);
                    if (max != min) {
                        $('#registroPlanPagos').children().not('#btnRegistrarPlanPagos').show();
                    } else {
                        $('#registroPlanPagos').children().show();
                        $('#btnRegistrarPlanPagos').show();
                        $('#btnAgregarPago').hide();
                        $('#registroPlanPagos .bs-callout-warning p').text('Revise los pagos agregados antes de registrarlos. El registro del plan de pagos solo se realiza una vez...');
                    }
                    $('option[value="'+actividad+'"]', $('#registroPago').find('form').find('[name="actividades"]')).remove();
                    $('#registroPago').find('form').find('[name="actividades"]').multiselect('rebuild');
                }
            },
            fields: {
                actividades: {
                    validators: {
                        callback: {
                            message: 'La actividad es un dato requerido, seleccione uno',
                            callback: function(value, validator) {
                                          var options = validator.getFieldElements('actividades').val();
                                          return (options && options.length >= 1);
                                      }
                        }
                    }
                },
                entregables: {
                    validators: {
                        callback: {
                            message: 'Los entregables es un dato requerido, seleccione al menos uno',
                            callback: function(value, validator) {
                                          var options = validator.getFieldElements('entregables').val();
                                          return (options && options.length >= 1);
                                      }
                        }
                    }
                },
                porcentaje: {
                    validators: {
                        notEmpty: {
                            message: 'El porcentaje del costo total del proyecto es un dato requerido'
                        },
                        numeric: {
                            message: 'El porcentaje del costo total del proyecto debe ser un dato numerico. El separador decimal es el punto (.)'
                        },
                        porcentajeMax: {
                            message: 'error max',
                        },
                        porcentajeMin: {
                            message: 'error min',
                        }
                    }
                }
            }
        })
        .find('[name="actividades"]')
            .multiselect({
                buttonWidth: '468px',
                buttonText: function(options) {
                    if (options.length == 0) {
                        return 'Seleccione una actividad <b class="caret"></b>';
                    }
                    else {
                        var selected = '';
                        options.each(function() {
                            selected += $(this).text() + ', ';
                        });
                        return selected.substr(0, selected.length -2) + ' <b class="caret"></b>';
                    }
                },
                onChange: function(element, checked) {
                    var values = new Array();;
                    $('#registroPago').find('form').find('[name="actividades"]').find('option').each(function() {
                        if ($(this).val() !== element.val()) {
                            values.push($(this).val());
                        }
                    });
                    var selected = 0;
                    $('option', $('#registroPago').find('form').find('[name="actividades"]')).each(function() {
                        if ($(this).prop('selected')) {
                            selected++;
                        }
                    });
                    if (selected >= 1) {
                        $('#registroPago').find('form').find('[name="actividades"]').siblings('div').children('ul').dropdown('toggle');
                    }
                    $('#registroPago').find('form').find('[name="actividades"]').multiselect('deselect', values);
                    $('#registroPago').find('form')
                        .data('bootstrapValidator')
                        .updateStatus('actividades', 'NOT_VALIDATED')
                        .validateField('actividades');
                }
            })
            .end()
        .find('[name="entregables"]')
            .multiselect({
                buttonWidth: '468px',
                buttonWidth: '468px',
                buttonText: function(options) {
                    if (options.length == 0) {
                        return 'Seleccione los entregables <b class="caret"></b>';
                    }
                    else {
                        if (options.length > 1) {
                            return options.length + ' seleccionados <b class="caret"></b>';
                        }
                        else {
                            var selected = '';
                            options.each(function() {
                                selected += $(this).text() + ', ';
                            });
                            return selected.substr(0, selected.length - 2) + ' <b class="caret"></b>';
                        }
                    }
                },
                onChange: function(element, checked) {
                    $('#registroPago').find('form')
                        .data('bootstrapValidator')
                        .updateStatus('entregables', 'NOT_VALIDATED')
                        .validateField('entregables');
                }
            });

    $(document).on('click', '.btnBorrarPago', function() {
        var cuerpo = $(this).parents().get(2);
        if ($(cuerpo).find('tr').length == 1) {
            $('#registroPlanPagos').hide();
            multiselect_deselectAll($('#registroPago').find('form').data('bootstrapValidator').getFieldElements('actividades'));
            multiselect_deselectAll($('#registroPago').find('form').data('bootstrapValidator').getFieldElements('entregables'));
            $('#registroPago').find('form').data('bootstrapValidator').resetForm(true);
            $('#registroPago').show();
            $('#btnCancelarPago').hide();
        }
        var fila = $(this).parents().get(1);
        var porcentaje = $(fila).find('td').eq(2).text();
        porcentaje = parseFloat(porcentaje.substr(0, porcentaje.length - 1));
        var actividad = $(fila).find('td').eq(0).text();
        var fecha = $(fila).find('td').eq(1).text();
        $('#registroPago').find('form').find('[name="actividades"]').append('<option data-fecha="'+ fecha +'" value="' + actividad + '">' + actividad + '</option>');
        $('#registroPago').find('form').find('[name="actividades"]').multiselect('rebuild');
        var max = $('#registroPlanPagos').data('max');
        var min = $('#registroPlanPagos').data('min');
        if (max == min) {
            $('#btnAgregarPago').show();
            $('#btnRegistrarPlanPagos').hide();
            $('#registroPlanPagos .bs-callout-warning p').text('Para registrar el plan de pagos debe registrar pagos cuyos porcentajes del total sumen 100%...');
        }
        max = max + porcentaje;
        $('#registroPlanPagos').data('max', max);
        $(fila).remove();
        
        if ($('#registroPago').find('form').find('[name="actividades"]').find('option').length == 2) {
            multiselect_deselectAll($('#registroPago').find('form').data('bootstrapValidator').getFieldElements('actividades'));
            $('#registroPago').find('form').find('[name="porcentaje"]').val('');
            $('#registroPago').find('form').find('[name="porcentaje"]').prop('readonly', false);
        }
        
    });

    $(document).on('click', '#btnCancelarPago', function() {
        $('#registroPago').hide();
        $('#registroPlanPagos').show();
        $('#registroPlanPagos').find('legend').text('Registro de plan de pagos');
        $('#registroPlanPagos').children().not('#btnRegistrarPlanPagos').show();
    });

    $(document).on('click', '#btnAgregarPago', function() {
        $('html, body').animate({scrollTop: 0}, 100);
        $('#registroPago').find('form').data('bootstrapValidator').resetForm(true);
        multiselect_deselectAll($('#registroPago').find('form').data('bootstrapValidator').getFieldElements('actividades'));
        multiselect_deselectAll($('#registroPago').find('form').data('bootstrapValidator').getFieldElements('entregables'));
        if ($('#registroPago').find('form').find('[name="actividades"]').find('option').length == 1) {
            var actividad = $('#registroPago').find('form').find('[name="actividades"]').find('option').val();
            var porcentaje = $('#registroPlanPagos').data('max');
            $('#registroPago').find('form').find('[name="porcentaje"]').val(porcentaje);
            $('#registroPago').find('form').find('[name="porcentaje"]').prop('readonly', true);
            $('#registroPago').find('form').find('[name="actividades"]').multiselect('select', actividad);
        }
        $('#registroPago').show();
        $('#registroPlanPagos').find('legend').text('Plan de pagos');
        $('#registroPlanPagos').children().not('table, legend').hide();
    });

    $(document).on('click', '#btnRegistrarPlanPagos', function() {
        var actividades = new Array();
        var fechas = new Array();
        var porcentajes = new Array();
        var montos = new Array();
        var entregables = new Array();
        $('#registroPlanPagos table tbody tr').each(function() {
            $(this).children("td").each(function(index) {
                switch (index) {
                    case 0:
                        actividades.push($(this).text());
                        break;
                    case 1:
                        fechas.push($(this).text());
                        break;
                    case 2:
                        var x = $(this).text();
                        porcentajes.push(x.substr(0, x.length - 1));
                        break;
                    case 3:
                        montos.push($(this).text());
                        break;
                    case 4:
                        entregables.push($(this).text());
                        break;
                }
            })
        })
        $('#page-wrapper').load('../Controlador/RegistrarPlanificacion.php', {
            actividades:actividades.join(),
            fechas:fechas.join(),
            porcentajes:porcentajes.join(),
            montos:montos.join(),
            entregables:entregables.join('|')
        });
    });
}

function multiselect_deselectAll($el) {
    $('option', $el).each(function(element) {
        $el.multiselect('deselect', $(this).val());
    });
}
