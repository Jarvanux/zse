<!DOCTYPE html>
<html>
    <head>        
        <!--Se crea un archivo con las cosas que vamos a usar más genéricas para 
        todos los layouts o páginas de la aplicación.-->
        @import("layouts/parts/head.php")
        <!--Declare sus espacios de trabajo con la sentencia @yield(nombreespacio),
        así podrá importar en estos los scripts y código html necesarios desde 
        los archivos que herenden de este layout.-->
        <!--Sección de estilos-->
        @yield("styles")        
        @style("assets/css/helper-class.css")
    </head>
    <body data-base="{{URL::base()}}">
        <!--Declare sus espacios de trabajo con la sentencia @yield(nombreespacio),
        así podrá importar en estos los scripts y código html necesarios desde 
        los archivos que importen de este layout.-->
        @yield("content")
        @yield("footer")
        @script("http://code.jquery.com/jquery-3.3.1.min.js")
        @script("https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js")
        @script("assets/plugins/jquery.validate.min.js")        
        @script("assets/plugins/HelperForm.js")
        @script("assets/plugins/Utils/app.dom.js")
        @script("assets/plugins/Utils/app.global.js")
        @yield("scripts")
    </body>
</html>