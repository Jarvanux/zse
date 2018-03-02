<!DOCTYPE html>
<html>
    <head>
        <title>Error en la aplicación - Deplyn</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
        <?php
        Html::addFavicon("assets/img/logo.png");
        Html::addStyle("assets/css/error.css");
        ?>
    </head>
    <body>
        <header>
            <div class="container">
                <h1><?= isset($title) ? $title : "Error"; ?></h1>
            </div>
        </header>
        <div class="container">
            <div class="description"><?= isset($description) ? $description : "Se ha producido un error desconocido."; ?></div>            
            <div class="solutions"><?= isset($solutions) ? $solutions : ""; ?></div>
            <a href="<?= URL::base(); ?>" >Volver al inicio</a>
        </div>
    </body>
</html>
