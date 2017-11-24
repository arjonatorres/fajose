<?php

function h(?string $param): string
{
    return htmlspecialchars($param, ENT_QUOTES | ENT_SUBSTITUTE);
}

function conectar(): PDO
{
    return new PDO('pgsql:host=localhost;dbname=fajose', 'fajose', 'fajose');
}

function comprobarParametro($param, array &$error): void
{
    if ($param === false) {
        $error[] = 'Parámetro no válido';
        throw new Exception();
    }
}

function buscarPelicula(PDO $pdo, int $id, array &$error): array
{
    $query = $pdo->prepare('SELECT *
                     FROM peliculas
                    WHERE id = :id');
    $query->execute([':id' => $id]);
    $fila = $query->fetch();
    if (empty($fila)) {
        $error[] = 'La película no existe';
        throw new Exception;
    }
    return $fila;
}

function mostrarErrores(array $error): void
{
    foreach ($error as $v): ?>
        <h3>Error: <?= $v ?></h3>
    <?php
    endforeach;
}

function comprobarErrores(array $error):void
{
    if (!empty($error)) {
        throw new Exception;
    }
}

function volver():void
{
    ?>
    <a href="index.php">Volver</a>
    <?php
}

function borrarPelicula(PDO $pdo, int $id, array $error): void
{
    $sent = $pdo->prepare('DELETE FROM peliculas
                                 WHERE id = :id');
    $sent->execute([':id' => $id]);
    if ($sent->rowCount() !== 1) {
        $error[] = 'Se ha producido un problema al borrar la película';
        throw new Exception;
    }
}

function comprobarTitulo(string $titulo, array &$error): void
{
    if ($titulo === '') {
        $error[] = 'El título es obligatorio';
        return;
    }
    if (mb_strlen($titulo) > 255) {
        $error[] = 'El título es demasiado largo';
    }
}

function comprobarAnyo(string $anyo, array &$error): void
{
    if ($anyo === '') {
        return;
    }
    $filtro = filter_var($anyo , FILTER_VALIDATE_INT, [
        'options' => [
            'min_range' => 0,
            'max_range' => 9999,
        ],
    ]);
    if ($filtro === false) {
        $error[] = 'Año no válido';
    }
}

function comprobarDuracion(string $duracion, array &$error): void
{
    if ($duracion === '') {
        return;
    }
    $filtro = filter_var($duracion , FILTER_VALIDATE_INT, [
        'options' => [
            'min_range' => 0,
            'max_range' => 32767,
        ],
    ]);
    if ($filtro === false) {
        $error[] = 'Duración no válida';
    }
}

function comprobarGenero(PDO $pdo, string $genero_id, array &$error): void
{
    if ($genero_id === '') {
        $error[] = 'El género es obligatorio';
        return;
    }
    $filtro = filter_var($genero_id , FILTER_VALIDATE_INT, [
        'options' => [
            'min_range' => 1,
        ],
    ]);
    if ($filtro === false) {
        $error[] = 'El género debe ser un número entero > 0';
        return;
    }
    $sent = $pdo->prepare('SELECT COUNT(*)
                             FROM generos
                            WHERE id = :id');
    $sent->execute([':id' => $genero_id]);
    if ($sent->fetchColumn() === 0) {
        $error[] = 'El género no existe';
    }
}

function insertarPelicula(PDO $pdo, array $valores): void
{
    $cols = array_keys($valores);
    $vals = array_fill(0, count($valores), '?');
    $instr = 'INSERT INTO peliculas(' . implode(', ', $cols) . ') ' .
                'VALUES (' . implode(', ', $vals) . ')';
    $sent = $pdo->prepare($instr);
    $sent->execute(array_values($valores));
}
