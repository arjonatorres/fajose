<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Borra una película</title>
    </head>
    <body>
        <?php
        require 'auxiliar.php';
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? false;
        try {
            $error = [];
            comprobarParametro($id, $error);
            $pdo = conectar();
            $fila = buscarPelicula($pdo, $id, $error);
            comprobarErrores($error);
            ?>
            <h3>¿Está seguro que desea borrar la película?</h3>
            <form action="hacer_borrado.php" method="post">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="submit" value="Sí" />
                <?php volver(); ?>
            </form>
            <?php
        } catch (Exception $e) {
            mostrarErrores($error);
        }
        ?>
    </body>
</html>
