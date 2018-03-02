var __app = {
    urlbase: $('body').attr('data-base').trim('/') + '/',
    validResponse: function (response) {
        switch (response.code) {
            case 1:
                response = response;
                break;
            case 0:
                response = response;
                break;
            case - 1:
                response = false;
                break;
            default :
                if (response.code < 0) {
                    response = false;
                } else {
                    response = response;
                }
                break;

        }
        return response;
    },
    urlTo: function (url) {
        return __app.urlbase + url;
    },
    successResponse: function (response) {
        return response.code > 0;
    },
    parseResponse: function (response) {
        var data = __app.validResponse(response);
        if (data) {
            return data.data;
        } else {
            return false;
        }
    },
    stopEvent: function (e) {
        if (e) {
            if (e.preventDefault) {
                e.preventDefault();
            }
            if (e.stopPropagation) {
                e.stopPropagation();
            }
            if (!!e.returnValue) {
                e.returnValue = false;
            }
        }
        return;
    },
    /**
     *
     * @param {String} url
     * @param {Object} data
     * @param {function} success
     * @param {function} error
     * @param {function} before
     * @param {function} complete
     */
    get: function (url, data, success, error, before, complete) {
        var ajax = __app.getObjectAjax(url, data, success, error, "GET", before, complete);
        return $.extend({ajax: ajax}, __app.methods);
    },
    /**
     * @param {String} url
     * @param {Object} data
     * @param {function} success
     * @param {function} error
     * @param {function} before
     * @param {function} complete
     */
    post: function (url, data, success, error, before, complete) {
        var ajax = __app.getObjectAjax(url, data, success, error, "POST", before, complete);
        return $.extend({ajax: ajax}, __app.methods);
        //app.ajax(ajax);
    },
    methods: {
        before: function (callback) {
            this.ajax.before = callback;
            return this;
        },
        complete: function (callback) {
            this.ajax.complete = callback;
            return this;
        },
        success: function (callback) {
            this.ajax.success = callback;
            return this;
        },
        error: function (callback) {
            this.ajax.error = callback;
            return this;
        },
        send: function () {
            __app.ajax(this.ajax);
        }
    },
    getObjectAjax(url, data, success, error, method, before, complete) {
        var ajax = new Object();
        ajax.url = url;
        ajax.data = data;
        ajax.type = method;
        ajax.success = success;
        ajax.error = (error) ? error : __app.ajaxError;
        ajax.beforeSend = (before) ? before : __app.beforeSend;
        ajax.complete = (complete) ? complete : null;
        return ajax;
    },
    beforeSend: function (data) {
    },
    uploadFile: function (url, input, validExtensions) {
        var public = {
            progress: function (callback) {
                if (typeof callback === "function") {
                    public.progress = callback;
                }
                return public;
            },
            complete: function (callback) {
                if (typeof callback === "function") {
                    public.complete = callback;
                }
                return public;
            },
            errorExtension: function (callback) {
                if (typeof callback === "function") {
                    public.errorExtension = callback;
                }
                return public;
            },
            error: function (callback) {
                if (typeof callback === "function") {
                    public.error = callback;
                }
                return public;
            }
        };
        var actions = {
            onProgress: function (e) {
                var max = e.total;
                var current = e.loaded;
                var percentage = (current * 100) / max;
                public.progress(percentage);
            },
            errorExtension: function (file) {
                console.error("Archivo no admitido, extención no válida.", file);
                public.errorExtension(file);
            }
        };

        var start = function (url, input, validExtensions) {
            var file = input.files;
            if (file.length > 0) {
                file = file[0];
            } else {
                console.warn("No se seleccionó ningún archivo");
                return;
            }
            var ext = file.name.split('.');
            ext = ext[ext.length - 1];
            var valid = 0;
            if (validExtensions) {
                for (var i = 0; i < validExtensions.length; i++) {
                    if (ext && ext.toLowerCase() == validExtensions[i]) {
                    } else {
                        valid--;
                        actions.errorExtension(file);
                    }
                }
            }
            if (valid == 0) {
                var formData = new FormData();
                formData.append("filename", "file");
                formData.append("file", file);
                $.ajax({
                    url: __app.urlTo(url),
                    type: 'POST',
                    data: formData,
                    xhr: function () {
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) {
                            myXhr.upload.addEventListener('progress', actions.onProgress, false);
                        }
                        return myXhr;
                    },
                    cache: false,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (data, textStatus, jqXHR)
                    {
                        if (typeof data.error === 'undefined')
                        {
                            public.complete(data);
                        } else
                        {
                            console.log('ERRORS: ' + data.error);
                            public.error(data.error);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        console.log('ERRORS: ' + textStatus);
                        public.error(textStatus);
                    }
                });
            }
        };
        public.start = function () {
            start(url, input, validExtensions);
        };
        return public;
    },
    ajax: function (args) {
        var ajax = new Object();
        ajax.url = (__app.urlbase + args.url);
        ajax.type = (args.type) ? args.type : "POST";
        ajax.data = (args.data);
        ajax.dataType = (args.dataType) ? args.dataType : "json";
//        ajax.beforeSend = (args.beforeSend) ? args.beforeSend : app.beforeSend;
        ajax.complete = args.complete;
        ajax.success = (args.success);
        ajax.error = (args.error) ? args.error : __app.error;
        $.ajax(ajax);
    },
    error: function (error) {
        console.log(error);
    },
    formToJSON: function (formArray) {
        var returnArray = {};
        for (var i = 0; i < formArray.length; i++) {
            returnArray[formArray[i]['name']] = formArray[i]['value'];
        }
        return returnArray;
    },
    getParamURL: function (param) {
        var url = new URL(location.href);
        var c = url.searchParams.get(param);
        return c;
    }
};