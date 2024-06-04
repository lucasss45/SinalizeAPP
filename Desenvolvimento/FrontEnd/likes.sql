CREATE TABLE IF NOT EXISTS likes (
  Comentario_ID int(11) NOT NULL,
  Usuario_ID int(11) NOT NULL,
  PRIMARY KEY (Comentario_ID, Usuario_ID),
  FOREIGN KEY (Comentario_ID) REFERENCES comentarios(ID),
  FOREIGN KEY (Usuario_ID) REFERENCES usuarios(ID)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
