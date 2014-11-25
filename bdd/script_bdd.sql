CREATE TABLE type_imprimante (
    id_type     INTEGER AUTO_INCREMENT PRIMARY KEY,
    type        VARCHAR(255)
);
  
CREATE TABLE marque_imprimante (
    id_marque   INTEGER AUTO_INCREMENT PRIMARY KEY,
    marque      VARCHAR(255)
);
  
CREATE TABLE modele_imprimante (
    id_modele   INTEGER AUTO_INCREMENT PRIMARY KEY,
    modele      VARCHAR(255)
);
  
CREATE TABLE format_imprimante (
    id_format   INTEGER AUTO_INCREMENT PRIMARY KEY,
    format      VARCHAR(255)
);
 
CREATE TABLE imprimantes (
    id_imprimante       INTEGER AUTO_INCREMENT PRIMARY KEY,
    nom_imprimante      VARCHAR(32),
    adresse_ip          VARCHAR(32),
    iso                 VARCHAR(255),
    batiment            VARCHAR(5),
    salle               VARCHAR(32),
    type_imprimante     INTEGER,
    marque_imprimante   INTEGER,
    modele_imprimante   INTEGER,
    format_imprimante   INTEGER,
    CONSTRAINT FK_type FOREIGN KEY(type_imprimante) REFERENCES type_imprimante(id_type),
    CONSTRAINT FK_marque FOREIGN KEY(marque_imprimante) REFERENCES marque_imprimante(id_marque),
    CONSTRAINT FK_modele FOREIGN KEY(modele_imprimante) REFERENCES modele_imprimante(id_modele),
    CONSTRAINT FK_format FOREIGN KEY(format_imprimante) REFERENCES format_imprimante(id_format)
) ENGINE="InnoDB";
  
CREATE TABLE compteur (
    id_compteur INTEGER AUTO_INCREMENT PRIMARY KEY,	
    id_imprimante   INTEGER,
    date_releve     VARCHAR(10),
    compteur        INTEGER,
);
