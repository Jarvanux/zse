var vista = {
    init: function () {
        vista.events();
    },
    events: function () {
        $('.content-body').on('focus', 'input', vista.onFocus);
        $('.content-body').on('focusout', 'input', vista.onFocus);
        $('.content-body').on('click', '.add-opcion', vista.onClickOpcion);
        $('.link-option').on('click', vista.onClickOpcion);
        $('.content-body').on('change', 'select.cmb-type-options', vista.onChangeTypeOption);
    },
    onChangeTypeOption: function () {
        var cmb = $(this);
        var type = cmb.val();
        console.log("CHANGE", type);
        parent = cmb.parents('.question');
        var q = parent.index() + 1;
        var section = section = parent.find('.answers-content');
        section.html('');
        switch (type) {
            case "1":
                section.append(vista.getContentMultipleOption(q));
                break;
            case "2":
                section.append(vista.getContentCheckOption(q));
                break;
            case "3":
                section.append(vista.getContentInputText());
                break;
            case "4":
                section.append(vista.getContentParagraph());
                break;
        }
    },
    onFocus: function () {
        var parent = $(this).parents('.input');
        var after = parent.find('.after-span');
        if (after.hasClass('hover')) {
            after.removeClass('hover');
        } else {
            after.addClass('hover');
        }
    },
    onClickOpcion: function () {
        var linkAddOption = $(this);
        var parent = linkAddOption.parents('.answers-content');
        var option = linkAddOption.attr('data-target');
        var q = linkAddOption.parents('.question').index() + 1;
        if (q > 1) {
            q -= 1;
        }
        console.log(linkAddOption.parents('.question').index());
        switch (option) {
            case "multiple":
                parent.find('.section').append(vista.getMultipleOption(parent.find('.section .option').length + 1, q));
                break;
            case "check":
                parent.find('.section').append(vista.getCheckOption(parent.find('.section .option').length + 1, q));
                break;
            case "question":
                $('#contentQuestions').append(vista.getQuestion());
                break;
        }
    },
    getQuestion: function () {
        var i = $('.content-body .question').length + 1;
        return '<hr/><div class="question"><div class="row"><div class="col-md-8"><div class="form-group input m-b-5"><input type="text" class="form-control qinput" value="Pregunta sin título" placeholder="Pregunta"><span class="after-span"></span></div></div><div class="col-md-4"><div class="form-group m-l-15 m-b-0"><select class="form-control cmb-type-options" ><option value="1">Selección múltiple</option><option value="2">Casillas de verificación</option><option value="3">Campo de Texto</option><option value="4">Párrafo</option></select></div></div><div class="answers-content"><div class="section"><div class="col-md-12"><div class="form-group m-b-5 option"><div class="check"><div class="radio radio-primary text-left" id="productionList"><input id="qanswer_' + i + '_1" name="radios_' + i + '[]" type="radio"><label for="qanswer_' + i + '_1" ></label></div></div><div class="input"><input type="text" class="form-control qinput" value="Opción 1" placeholder="Opción"><span class="after-span"></span></div></div></div></div><div class="col-md-12"><div class="form-group"><a class="btn btn-link add-opcion" data-target="multiple"><i class="fa fa-fw fa-plus"></i> Agregar opción</a></div></div></div></div></div>';
    },
    getContentMultipleOption: function (q) {
        return '<div class="section"><div class="col-md-12"><div class="form-group m-b-5 option"><div class="check"><div class="radio radio-primary text-left" id="productionList"><input id="qanswer_' + q + '_1" name="radios_' + q + '[]" type="radio"><label for="qanswer_' + q + '_1" class=""></label></div></div><div class="input"><input type="text" class="form-control qinput" value="Opción 1" placeholder="Opción"><span class="after-span"></span></div></div></div></div><div class="col-md-12"><div class="form-group"><a class="btn btn-link add-opcion" data-target="multiple"><i class="fa fa-fw fa-plus"></i> Agregar opción</a></div></div>';
    },
    getContentCheckOption: function (q) {
        return '<div class="section"><div class="col-md-12"><div class="form-group m-b-5 option"><div class="check"><div class="checkbox checkbox-primary text-left" id="productionList"><input id="qanswer_' + q + '_1" name="checkbox_' + q + '[]" type="checkbox"><label for="qanswer_' + q + '_1" class=""></label></div></div><div class="input"><input type="text" class="form-control qinput" value="Opción 1" placeholder="Opción"><span class="after-span"></span></div></div></div></div><div class="col-md-12"><div class="form-group"><a class="btn btn-link add-opcion" data-target="check"><i class="fa fa-fw fa-plus"></i> Agregar opción</a></div></div>';
    },
    getContentInputText: function () {
        return '<div class="section"><div class="col-md-12 p-l-25"><div class="form-group p-t-10"><input class="form-control" placeholder="Campo de respuesta" rows="3" /></div></div></div>';
    },
    getContentParagraph: function () {
        return '<div class="section"><div class="col-md-12 p-l-25"><div class="form-group p-t-10"><textarea class="form-control" placeholder="Párrafo de respuesta" rows="3" ></textarea></div></div></div>';
    },
    getMultipleOption: function (index, q) {
        return '<div class="col-md-12"><div class="form-group m-b-5 option"><div class="check"><div class="radio radio-primary text-left" id="productionList"><input id="qanswer_' + q + '_' + index + '" name="radios_' + q + '[]" type="radio"><label for="qanswer_' + q + '_' + index + '" ></label></div></div><div class="input"><input type="text" class="form-control qinput" value="Opción ' + index + '" placeholder="Opción"><span class="after-span"></span></div></div></div>';
    },
    getCheckOption: function (index, q) {
        return '<div class="col-md-12"><div class="form-group m-b-5 option"><div class="check"><div class="checkbox checkbox-primary text-left" id="productionList"><input id="qanswer_' + q + '_' + index + '" name="checkbox_' + q + '[]" type="checkbox"><label for="qanswer_' + q + '_' + index + '" class=""></label></div></div><div class="input"><input type="text" class="form-control qinput" value="Opción ' + index + '" placeholder="Opción"><span class="after-span"></span></div></div></div>';
    }
};
$(vista.init);