DROP TABLE IF EXISTS generos CASCADE;

CREATE TABLE generos
(
    id     BIGSERIAL    PRIMARY KEY
  , genero VARCHAR(255) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS peliculas CASCADE;

CREATE TABLE peliculas
(
    id        BIGSERIAL    PRIMARY KEY
  , titulo    VARCHAR(255) NOT NULL
  , anyo      NUMERIC(4)
  , sinopsis  TEXT
  , duracion  SMALLINT     DEFAULT 0 CONSTRAINT ck_peliculas_duracion_positiva
                           CHECK (duracion >= 0)
  , genero_id BIGINT       NOT NULL REFERENCES generos(id)
                           ON UPDATE CASCADE
                           ON DELETE NO ACTION
);

INSERT INTO generos(genero)
     VALUES ('Comedia')
          , ('Terror')
          , ('Drama')
          , ('Aventura')
          , ('Ciencia-Ficción');

INSERT INTO peliculas(titulo, anyo, sinopsis, duracion, genero_id)
     VALUES ('Los últimos Jedi', 2017, 'Va uno y se cae...', 204, 3)
        , ('Los Goonies', 1985, 'Unos niños encuentran un tesoro', 120, 5)
        , ('Aquí llega Condemor', 1996, 'Mejor no cuento nada', 90, 1);
