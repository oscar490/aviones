------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
      id         BIGSERIAL    PRIMARY KEY
    , nombre     VARCHAR(255) NOT NULL UNIQUE
    , password   VARCHAR(255) NOT NULL

);


DROP TABLE IF EXISTS aeropuertos CASCADE;

CREATE TABLE aeropuertos
(
      id       BIGSERIAL    PRIMARY KEY
    , id_aero  VARCHAR(3)   NOT NULL UNIQUE
    , den_aero VARCHAR(255) NOT NULL
);



DROP TABLE IF EXISTS companias CASCADE;

CREATE TABLE companias
(
      id      BIGSERIAL    PRIMARY KEY
    , den_com VARCHAR(255) NOT NULL
);


DROP TABLE IF EXISTS vuelos CASCADE;

CREATE TABLE vuelos
(
      id         BIGSERIAL     PRIMARY KEY
    , id_vuelo   VARCHAR(6)    NOT NULL UNIQUE
    , origen_id  BIGINT        REFERENCES aeropuertos (id) ON DELETE
                               NO ACTION ON UPDATE CASCADE
    , destino_id BIGINT        REFERENCES aeropuertos (id) ON DELETE
                               NO ACTION ON UPDATE CASCADE
    , comp_id    BIGINT        REFERENCES companias (id) ON DELETE
                               NO ACTION ON UPDATE CASCADE
    , salida     TIMESTAMP(0)  NOT NULL
    , llegada    TIMESTAMP(0)  NOT NULL
    , plazas     NUMERIC(5,0)  NOT NULL CONSTRAINT ck_numeros_positivos
                               CHECK (plazas >= 0)
    , precio     NUMERIC(5,2)  NOT NULL

);


DROP TABLE IF EXISTS reservas CASCADE;

CREATE TABLE reservas
(
      id         BIGSERIAL    PRIMARY KEY
    , usuario_id BIGINT       REFERENCES usuarios (id) ON DELETE
                              NO ACTION ON UPDATE CASCADE
    , vuelo_id   BIGINT       REFERENCES vuelos (id) ON DELETE
                              NO ACTION ON UPDATE CASCADE
    , asiento    NUMERIC(5)   NOT NULL CONSTRAINT ck_numeros_positivos
                              CHECK (asiento >= 0)
    , fecha_hora TIMESTAMP(0) NOT NULL DEFAULT localtimestamp
);


INSERT INTO usuarios (nombre, password)
    VALUES ('oscar', crypt('oscar', gen_salt('bf', 13))),
            ('pepe', crypt('pepe', gen_salt('bf', 13)));


INSERT INTO aeropuertos (id_aero, den_aero)
    VALUES ('AAA', 'Madrid'), ('BBB', 'Sevilla'), ('CCC', 'Portugal');

INSERT INTO companias (den_com)
    VALUES ('Vuelos Oscar'), ('Vuelos Mirame');

INSERT INTO vuelos (id_vuelo, origen_id, destino_id, comp_id, salida, llegada, plazas, precio)
    VALUES ('AA1111', 1, 2, 1, localtimestamp + '1 days'::interval, localtimestamp + '2 days'::interval, 10, 25.00),
            ('AA2222', 2, 3, 1, localtimestamp + '1 days'::interval, localtimestamp + '3 days'::interval, 3, 25.00),
            ('AA3333', 3, 2, 1, localtimestamp + '2 days'::interval, localtimestamp + '4 days'::interval, 10, 25.00);

INSERT INTO reservas (usuario_id, vuelo_id, asiento, fecha_hora)
    VALUES (1, 1, 3, default), (2, 1, 4, default), (2, 3, 5, localtimestamp );
