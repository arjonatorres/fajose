<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Películas</title>
        <style>
            #tabla {
                margin: auto;
            }
        </style>
    </head>
    <body>
        <?php
        require 'auxiliar.php';

        $titulo = trim(filter_input(INPUT_GET, 'titulo'));
        $pdo = conectar();
        $query = $pdo->prepare('SELECT *
                         FROM peliculas
                        WHERE lower(titulo) LIKE :titulo');
        $query->execute([':titulo' => '%'.mb_strtolower($titulo).'%']);
        ?>
        <div>
            <form action="index.php" method="get">
                <label for="titulo">Título: </label>
                <input id="titulo" type="text" name="titulo" value="<?= h($titulo) ?>" />
                <input type="submit" value="Buscar" />
            </form>
        </div>
        <div>
            <table id="tabla" border="2">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Año</th>
                        <th>Sinopsis</th>
                        <th>Duración</th>
                        <th>Género Id</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($query as $v): ?>
                        <tr>
                            <td><?= h($v['titulo']) ?></td>
                            <td><?= h($v['anyo']) ?></td>
                            <td><?= h($v['sinopsis']) ?></td>
                            <td><?= h($v['duracion']) ?></td>
                            <td><?= h($v['genero_id']) ?></td>
                            <td><a href="borrar.php?id=<?= $v['id'] ?>">
                                    Borrar
                                </a>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
            <a href="insertar.php">Insertar una película</a>
        </div>

    </body>
</html>
