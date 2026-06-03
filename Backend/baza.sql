CREATE DATABASE IF NOT EXISTS mojedrustvo CHARACTER SET utf8 COLLATE utf8_slovenian_ci;
USE mojedrustvo;

CREATE TABLE uporabnik (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    ime             VARCHAR(50)  NOT NULL,
    priimek         VARCHAR(50)  NOT NULL,
    username        VARCHAR(50)  NOT NULL UNIQUE,
    email           VARCHAR(100) NOT NULL UNIQUE,
    geslo_hash      VARCHAR(255) NOT NULL,
    vloga           ENUM('neclan','clan','admin') DEFAULT 'clan',
    vrsta_prijave   varchar(20) default 'navadna',
    datum_rojstva   DATE,
    datum_reg       DATETIME DEFAULT CURRENT_TIMESTAMP,
    aktiven         TINYINT(1) DEFAULT 1
);

CREATE TABLE dogodek (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    naslov          VARCHAR(150) NOT NULL,
    opis            TEXT,
    lokacija        VARCHAR(100),
    datum_cas       DATETIME,
    cena            DECIMAL(8,2) DEFAULT 0,
    st_mest         INT DEFAULT 0,
    slika_url       VARCHAR(255),
    vrsta           VARCHAR(50),
    je_javen        TINYINT(1) DEFAULT 1,
    kreator_id      INT,
    FOREIGN KEY (kreator_id) REFERENCES uporabnik(id)
);

CREATE TABLE prijava (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    uporabnik_id    INT NOT NULL,
    dogodek_id      INT NOT NULL,
    datum_prijave   DATETIME DEFAULT CURRENT_TIMESTAMP,
    status          ENUM('cakanje','potrjena','zavrnjena') DEFAULT 'cakanje',
    opomnik_poslan  TINYINT(1) DEFAULT 0,
    FOREIGN KEY (uporabnik_id) REFERENCES uporabnik(id),
    FOREIGN KEY (dogodek_id)   REFERENCES dogodek(id)
);

CREATE TABLE objava (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    naslov          VARCHAR(150) NOT NULL,
    vsebina         TEXT,
    tip             VARCHAR(50),
    je_javna        TINYINT(1) DEFAULT 1,
    je_pomembna     TINYINT(1) DEFAULT 0,
    datum_objave    DATETIME DEFAULT CURRENT_TIMESTAMP,
    avtor_id        INT,
    FOREIGN KEY (avtor_id) REFERENCES uporabnik(id)
);

CREATE TABLE obvestilo (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    uporabnik_id    INT NOT NULL,
    zadeva          VARCHAR(150),
    sporocilo       TEXT,
    tip             ENUM('potrditev','opomnik'),
    poslano_ob      DATETIME DEFAULT CURRENT_TIMESTAMP,
    prebrano        TINYINT(1) DEFAULT 0,
    prijava_id      INT,
    FOREIGN KEY (uporabnik_id) REFERENCES uporabnik(id),
    FOREIGN KEY (prijava_id)   REFERENCES prijava(id)
);

INSERT INTO uporabnik (ime, priimek, username, email, geslo_hash, vloga)
VALUES ('Admin', 'Društvo', 'admin', 'admin@mojedrustvo.si',
        '$2y$10$HvUnaLSbZ0BbMB1lyLmLzetdgZKT1HbfA43i/iwBTK/hycB2yXPYu', 'admin');

alter table uporabnik
add profilna_slika varchar(255) default '../Frontend/slike/default.png';

CREATE TABLE komentar(
    id              INT AUTO_INCREMENT PRIMARY KEY,
    uporabnik_id    INT NOT NULL,
    dogodek_id      INT NOT NULL,
    besedilo        TEXT NOT NULL,
    datum TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uporabnik_id) REFERENCES uporabnik(id),
    FOREIGN KEY (dogodek_id) REFERENCES dogodek(id)
);

CREATE TABLE priljubljeni(
    id              INT AUTO_INCREMENT PRIMARY KEY,
    uporabnik_id    INT NOT NULL,
    dogodek_id      INT NOT NULL,
    FOREIGN KEY (uporabnik_id) REFERENCES uporabnik(id),
    FOREIGN KEY (dogodek_id) REFERENCES dogodek(id)
);