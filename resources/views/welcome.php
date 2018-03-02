<!--Extiende de una plantilla principal-->
@layout("layouts/principal")

<!--Selecciona y agrega contenido a una sección de la plantilla principal-->
@section("styles")
<!--Agrega un elemento css.-->
@style("assets/css/custom.css")
@endsection

<!--Selecciona y agrega contenido a una sección de la plantilla principal-->
@section("content")
<section class="header">
    <div class="container">    
        <h2><i class="fa fa-fw fa-check-square-o"></i> ZSE</h2>        
        <div class="content-body p-t-15 p-l-20 p-r-20 p-b-20">
            <div class="options">
                <a href="javascript:;" class="link-option" data-target="question" title="Agregar pregunta" ><i class="fa fa-fw fa-plus"></i></a>
                <a href="javascript:;" class="link-option" data-target="save" title="Guardar encuesta" ><i class="fa fa-fw fa-save"></i></a>
            </div>
            <div class="qheader">
                <div class="form-group input">
                    <input type="text" class="form-control" placeholder="Título de la encuesta" value="Título de la encuesta" />
                    <span class="after-span"></span>
                </div>
                <div class="form-group">
                    <textarea class="form-control" placeholder="Descripción"></textarea>
                </div>
            </div>
            <hr class=""/>
            <div class="qcontent" id="contentQuestions">
                <div class="question">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group input m-b-5">
                                <input type="text" class="form-control qinput" value="Pregunta sin título" placeholder="Pregunta">
                                <span class="after-span"></span>
                            </div>                    
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-l-15 m-b-0">
                                <select class="form-control cmb-type-options" >
                                    <option value="1">Selección múltiple</option>
                                    <option value="2">Casillas de verificación</option>
                                    <option value="3">Campo de texto</option>
                                    <option value="4">Párrafo</option>
                                </select>
                            </div>
                        </div>    
                        <div class="answers-content">
                            <div class="section">
                                <div class="col-md-12">
                                    <div class="form-group m-b-5 option">
                                        <div class="check">
                                            <div class="radio radio-primary text-left" id="productionList">
                                                <input id="answer_1_1" name="radios_1[]" type="radio">
                                                <label for="answer_1_1" ></label>
                                            </div>
                                        </div>
                                        <div class="input">
                                            <input type="text" class="form-control qinput" value="Opción 1" placeholder="Opción">
                                            <span class="after-span"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">                                    
                                    <a class="btn btn-link add-opcion" data-target="multiple"><i class="fa fa-fw fa-plus"></i> Agregar opción</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<!--Selecciona y agrega contenido a una sección de la plantilla principal.-->
@section("scripts")
@script("assets/js/creation.js")
@endsection