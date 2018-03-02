var __dom = {
    //Para agregar todas las interacciones del dom genericas.
    init: function () {
        $('body').on('click', '.alert .close', function (e) {
            $(this).parent().slideUp(500);
            return __app.stopEvent(e);
        });
        __dom.events();
    },
    events: function () {

    },
    /**
     * Usa select2...
     * @param {Element} cmb
     * @param {Array} array
     * @param {Object} keyNames : Ej: {text:"keyName", value:"keyName"}; value también soporta un array para concatenar keyNames,
     * @returns {undefined}
     */
    llenarCombo: function (cmb, array, keyNames) {
        window.setTimeout(function () {
            cmb.html("");
            cmb.append(new Option("Selecciona", ""));
            if (Array.isArray(array) && array.length > 0) {
                for (var i = 0; i < array.length; i++) {
                    var dato = array[i];
                    var value = "";
                    if (Array.isArray(keyNames.text)) {
                        var keys = keyNames.text.length;
                        for (var j = 0; j < keys; j++) {
                            value += dato[keyNames.text[j]] + ((j < (keys - 1)) ? " " : "");
                        }
                    } else {
                        value = dato[keyNames.text];
                    }
                    cmb.append(new Option(value, dato[keyNames.value]));
                }
            } else {
                __dom.comboVacio(cmb);
            }
            cmb.select2({width: "100%"});
            cmb.trigger('selectfilled');
        }, 10);
    },
    /**
     * Llenará un <select> con una opción No hay registros.
     * @param {type} cmb
     */
    comboVacio: function (cmb) {
        cmb.html("");
        cmb.append(new Option("No hay registros", "-1"));
    },
    /**
     * Alerta boostrap...
     * @param {type} mensaje
     * @param {type} tipo
     * @param {type} alerta
     * @returns alert with methods...
     */
    printAlert: function (message, tipo, alerta) {
        var icon = function (tipo) {
            switch (tipo) {
                case 'success':
                    return '<i class="fa fa-fw fa-info-circle"></i> ';
                case 'loading':
                    return '<i class="fa fa-fw fa-refresh fa-spin"></i> ';
                case 'danger':
                    return '<i class="fa fa-fw fa-times-circle"></i> ';
                default:
                    return '<i class="fa fa-fw fa-warning"></i> ';
            }
        };
        alerta.find('#text').html(icon(tipo) + message);
        tipo = (tipo == 'loading') ? 'info' : tipo;
        alerta.attr('class', 'alert alert-' + tipo + ' alert-dismissable');
        alerta.hide().slideDown(500);
        return {
            print: function (message, tipo) {
                alerta.find('#text').html(icon(tipo) + message);
                alerta.attr('class', 'alert alert-' + tipo + ' alert-dismissable');
            },
            clear: function () {
                alerta.find('#text').html("");
            },
            add: function (message) {
                if (alerta.find('ul').length == 0) {
                    alerta.find('#text').html("<ul></ul>");
                }
                alerta.find('#text ul').append('<li>' + icon(tipo) + message + '</li>');
            },
            hide: function () {
                alerta.hide();
            },
            show: function () {
                alerta.slideDown(500);
            }
        };
    },
    alertControl: function (response, alert, hideOnSuccess) {
        if (__app.successResponse(response)) {
            if (hideOnSuccess != true) {
                __dom.printAlert(response.message, 'success', alert);
            } else {
                alert.addClass('hidden').hide();
            }
        } else
        if (response.code == 0) {
            __dom.printAlert(response.message, 'warning', alert);
        } else {
            __dom.printAlert(response.message, 'danger', alert);
        }
        return alert;
    },
    alertError: function (alert) {
        var messageError = 'Se ha producido un error desconocido, por favor compruebe su conexión a internet y vuelva a intenarlo nuevamente.';
        __dom.printAlert(messageError, 'danger', alert);
    },
    betweenHours: function (hms_inicio, hms_fin, hms_referencia) {
        hms_inicio = formatDate(hms_inicio, 'HH:mm:ss');
        hms_fin = formatDate(hms_fin, 'HH:mm:ss');
        hms_referencia = formatDate(hms_referencia, 'HH:mm:ss');
//        console.log(hms_referencia);
        var h, m, s;
        //HORA INICIO.
        hms_inicio = hms_inicio.split(/[^\d]+/);
        h = hms_inicio[0];
        m = hms_inicio[1];
        s = hms_inicio[2];
        s_inicio = 3600 * h + 60 * m + s;
        //HORA FIN.
        hms_fin = hms_fin.split(/[^\d]+/);
        h = hms_fin[0];
        m = hms_fin[1];
        s = hms_fin[2];
        var s_fin = 3600 * h + 60 * m + s;
        //HORA REFERENCIA.
        hms_referencia = hms_referencia.split(/[^\d]+/);
        h = hms_referencia[0];
        m = hms_referencia[1];
        s = hms_referencia[2];
        var s_referencia = 3600 * h + 60 * m + s;
        if (s_inicio <= s_fin) {
            return s_referencia >= s_inicio && s_referencia <= s_fin;
        } else {
            return s_referencia >= s_inicio || s_referencia <= s_fin;
        }
    },
    /**
     * Configura un calendario con datepicker boostrap.
     * NOTA: Requiere datepicker, inputmask y JQuery para funcionar...
     * @param {type} control
     * @param {type} fechaInicio
     * @param {type} fechaFin
     * @param {type} fechaDefecto
     * @param {type} btnToday
     * @returns {unresolved}
     */
    configCalendar: function (control, fechaInicio, fechaFin, fechaDefecto, btnToday) {
        control.datepicker('remove');
        control.mask("99/99/9999");
        control.attr('placeholder', 'DD/MM/AAAA');
        var args = {
            format: 'dd/mm/yyyy',
            weekStart: 1,
            todayBtn: (btnToday) ? 'linked' : false,
            clearBtn: false,
            language: 'es',
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true
        };
        if (!!fechaInicio) {
            args.startDate = fechaInicio;
        }
        if (!!fechaFin) {
            args.endDate = fechaFin;
        }
        if (!!fechaDefecto) {
            args.defaultViewDate = fechaDefecto;
            control.val(fechaDefecto);
        }

        control.parents(".input-group").find("button").attr('type', 'button').on('click', function () {
            control.trigger("focus");
        });
        if (control.parent('.input-group.date').length > 0) {
            return control.parent('.input-group.date').datepicker(args);
        }

        return control.datepicker(args);
    },
    scrollTop: function () {
        $("html, body").animate({scrollTop: 0}, "slow");
    },
    controlSubmit: function (form, callback, clearForm) {
        form.find('fieldset').prop('disabled', true);
        btnSubmit = form.find('button[type="submit"]');
        btnSubmit.prop('disabled', true);
        btnSubmit.find('.fa-save').attr('class', 'fa fa-fw fa-refresh fa-spin');
        var obj = form.getFormData();
        var ajax = null;
        __dom.printAlert("Enviando, por favor espere...", 'loading', form.find('.alert'));
        ajax = __app.post(form.attr('action'), obj);
        ajax.complete(function () {
            form.find('fieldset').prop('disabled', false);
            btnSubmit.prop('disabled', false);
            form.find('button[type="submit"] .fa-refresh.fa-spin').attr('class', 'fa fa-fw fa-save');
        }).success(function (response) {
            if (__app.successResponse(response)) {
                __dom.printAlert(response.message, 'success', form.find('.alert'));
                if (clearForm != false) {
                    form.find('input:not([type="hidden"]),textarea,select').val('');
                    form.find('select.select2-hidden-accessible').trigger('change.select2');
                }
                if (typeof callback === "function") {
                    callback(response);
                }
            } else {
                var typeAlert = 'danger';
                if (response.code == 0) {
                    typeAlert = 'warning';
                }
                __dom.printAlert(response.message, typeAlert, form.find('.alert'));
            }
        }).error(function (e) {
//            console.error(e);
            __dom.alertError(form.find('.alert'));
        });
        return ajax;
    },
    submitDirect: function (form, callback, clearForm) {
        __dom.controlSubmit(form, callback, clearForm).send();
    },
    /**
     * 
     * @param {type} form
     * @param {type} callback
     * @param {type} clearForm = Recibe falso, cuando no quiera limpiar...
     * @returns {undefined}
     */
    submit: function (form, callback, clearForm) {
        if (!form || form.length == 0) {
            return;
        }
        form.validate();
        var onSubmitForm = function (e) {
            if (e.isDefaultPrevented())
            {
                return;
            }
            var form = $(this);
            __app.stopEvent(e);
            __dom.submitDirect(form, callback, clearForm);
        };
        form.on('submit', onSubmitForm);
    },
    fillString: function (dom, obj) {
        var getKeyPart = function (keyPart, key) {
            if (keyPart.trim("") != "") {
                keyPart += "." + key;
            } else {
                keyPart = key;
            }
            return keyPart;
        };
        var getValueFromObjet = function (obj, keyPart) {
            for (var key in obj) {
                //Evalua si el atributo actual es un objeto...
                var o = obj[key];
                if (typeof o === "object") {
                    getValueFromObjet(o, getKeyPart(keyPart, key));
                } else {
                    keyTemp = getKeyPart(keyPart, key);
                    var reg = new RegExp("{" + keyTemp + "}", "g");
                    dom = dom.replace(reg, o);
                }
            }
        };
        getValueFromObjet(obj, "");
        return dom;
    },
    /**
     * Configuración DataTables...
     * @param {type} data
     * @param {type} columns
     * @param {type} onDraw
     * @returns {__dom.configTable.app.domAnonym$3}
     */
    configTable: function (data, columns, onDraw) {
        return {
            data: data,
            columns: columns,
            "language": {
                "url": __app.urlbase + "assets/plugins/datatables/lang/es.json"
            },
            columnDefs: [{
                    defaultContent: "",
                    targets: 0,
                    orderable: false,
                }],
            order: [[1, 'asc']],
            drawCallback: onDraw
        }
    },
    refreshTable: function (tabla, data) {
        tabla.clear().draw();
        tabla.rows.add(data);
        tabla.columns.adjust().draw();
    },
    parsearFecha: function (fecha) {
        return fecha.slice(0, 10).split('-').reverse().join().replace(/\,/g, '/');
    },
    /**
     * Recibe una fecha string y la parsea en el formato yyyy-MM-dd
     * @param {type} dateString
     * @returns fecha en formato yyyy-MM-dd
     */
    formatDate(dateString, method) {
        if (dateString && dateString.trim() != "") {
            //dateString, outputFormat, inputFormat...
            if (method === "month") {
                return formatDate(dateString, 'dd/NNN/yyyy', 'yyyy/MM/dd');
            } else if (method === "fillForm") {
                return formatDate(dateString, 'dd/MM/yyyy', 'yyyy/MM/dd');
            } else if (method === "getFormData") {
                return formatDate(dateString, 'yyyy-MM-dd', 'dd/MM/yyyy');
            }
        } else {
            return "Indefinido";
        }
    },
    formatDateForPrint(dateString, method) {
        if (dateString && dateString.trim() != "") {
            if (method === "fillForm") {
                //dateString, outputFormat, inputFormat...            
                return formatDate(dateString, "yyyy-MM-ddTHH:mm", "yyyy-MM-dd HH:mm");
            } else if (method === "getFormData") {
                return dateString;
            }
        } else {
            return "Indefinido";
        }
    },
    confirmar: function (texto, callbackconfirm, callbackcancel, close) {
        swal({
            title: "Confirmar",
            text: texto,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            closeOnConfirm: ((close === false) ? false : true),
            closeOnCancel: ((close === false) ? false : true)
        }).then(function (isConfirm) {
            if (isConfirm.value) {
                if (typeof callbackconfirm === "function") {
                    callbackconfirm();
                }
            } else {
                if (typeof callbackcancel === "function") {
                    callbackcancel();
                }
            }
        });
    },
};
$(function () {
    __dom.init();
});