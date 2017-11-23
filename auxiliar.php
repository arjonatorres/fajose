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
