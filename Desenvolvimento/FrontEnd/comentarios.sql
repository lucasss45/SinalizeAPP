CREATE TABLE comentarios (
    ID int(11) NOT NULL AUTO_INCREMENT,
    Usuario_ID int(11) NOT NULL,
    Comentario text NOT NULL,
    Submit_Date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Curtidas int DEFAULT 0,
    Topico ENUM('Avaliações', 'Sugestões', 'Dúvidas'),
    PRIMARY KEY (ID),
    FOREIGN KEY (Usuario_ID) REFERENCES usuarios(ID)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


