-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja(
id SERIAL PRIMARY KEY,
kayttajatunnus varchar(50) NOT NULL,
salasana varchar(50) NOT NULL
);

CREATE TABLE Muistiinpano(
id SERIAL PRIMARY KEY,
kayttaja_id INTEGER REFERENCES Kayttaja(id),
otsikko varchar(50) NOT NULL,
sisalto varchar(1000) NOT NULL,
prioriteetti varchar(30) NOT NULL
);

CREATE TABLE Luokka(
id SERIAL PRIMARY KEY,
kayttaja_id INTEGER REFERENCES Kayttaja(id),
nimi varchar(50) NOT NULL
);

CREATE TABLE Liitostaulu(
id SERIAL PRIMARY KEY,
muistiinpano_id INTEGER REFERENCES Muistiinpano(id),
luokka_id INTEGER REFERENCES Luokka(id)
);
