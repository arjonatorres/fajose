<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Borra una película</title>
    </head>
    <body>
        <?php
        require 'auxiliar.php';
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) ?? false;
        try {
            $error = [];
            comprobarParametro($id, $error);
            $pdo = conectar();
            buscarPelicula($pdo, $id, $error);
            comprobarErrores($error);

            $sent = $pdo->prepare('DELETE FROM peliculas
                                         WHERE id = :id');
            $sent->execute([':id' => $id]);
            ?>
            <h3>Película borrada correctamente</h3>
            <?php
            volver();
        } catch (Exception $e) {
            mostrarErrores($error);
        }
        ?>
    </body>
</html>
