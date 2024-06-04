CREATE TABLE usuarios (
    ID int(11) NOT NULL AUTO_INCREMENT,
    Nome varchar(50) NOT NULL,
    Email varchar(120) NOT NULL,
    Senha varchar(120) NOT NULL,
    PRIMARY KEY (ID)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
