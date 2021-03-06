<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Inserta una película</title>
    </head>
    <body>
        <?php
        require 'auxiliar.php';

        $titulo = trim(filter_input(INPUT_POST, 'titulo'));
        $anyo = trim(filter_input(INPUT_POST, 'anyo'));
        $sinopsis = trim(filter_input(INPUT_POST, 'sinopsis'));
        $duracion = trim(filter_input(INPUT_POST, 'duracion'));
        $genero_id = trim(filter_input(INPUT_POST, 'genero_id'));
        if(!empty($_POST)) {
            $error = [];
            try {
                comprobarTitulo($titulo, $error);
                comprobarAnyo($anyo, $error);
                comprobarDuracion($duracion, $error);
                $pdo = conectar();
                comprobarGenero($pdo, $genero_id, $error);
                comprobarErrores($error);
                $valores = array_filter(compact('titulo', 'anyo', 'sinopsis', 'duracion', 'genero_id'));
                insertarPelicula($pdo, $valores);
                ?>
                <h3>La película se ha insertado correctamente</h3>
                <?php
                volver();
            } catch (Exception $e) {
                mostrarErrores($error);
            }
        }
        if (empty($_POST) || (!empty($_POST) && (!empty($error)))):
        ?>
        <form action="insertar.php" method="post">
            <label for="titulo">Título: </label>
            <input id="titulo" type="text" name="titulo"
                value="<?= h($titulo) ?>" />
                <br />
            <label for="anyo">Año: </label>
            <input id="anyo" type="text" name="anyo"
                value="<?= h($anyo) ?>" />
                <br />
            <label for="sinopsis">Sinopsis: </label>
            <textarea id="sinopsis" name="sinopsis"
                rows="8" cols="80"><?= h($sinopsis) ?></textarea><br />
            <label for="duracion">Duración: </label>
            <input id="duracion" type="text" name="duracion" value="<?= h($duracion) ?>" /><br />
            <label for="genero_id">Género: </label>
            <input id="genero_id" type="text" name="genero_id" value="<?= h($genero_id) ?>" /><br />
            <hr />
            <input type="submit" value="Insertar" />
            <a href="index.php">Volver</a>
        </form>
        <?php
        endif;
        ?>
    </body>
</html>
