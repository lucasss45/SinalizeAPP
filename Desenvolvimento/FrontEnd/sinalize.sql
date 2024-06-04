-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/06/2024 às 01:02
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sinalize`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `ID` int(11) NOT NULL,
  `Usuario_ID` int(11) NOT NULL,
  `Comentario` text NOT NULL,
  `Submit_Date` datetime NOT NULL DEFAULT current_timestamp(),
  `Topico` enum('Avaliações','Sugestões','Dúvidas') DEFAULT NULL,
  `Curtidas` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `comentarios`
--

INSERT INTO `comentarios` (`ID`, `Usuario_ID`, `Comentario`, `Submit_Date`, `Topico`, `Curtidas`) VALUES
(1, 1, 'Excelente aplicativo! Ansioso por novas atualizações', '2024-06-04 18:15:26', 'Avaliações', 1),
(2, 2, 'Vocês poderiam adicionar uma funcionalidade de missões diárias ou níveis semelhante ao duolingo', '2024-06-04 18:21:52', 'Sugestões', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `likes`
--

CREATE TABLE `likes` (
  `Comentario_ID` int(11) NOT NULL,
  `Usuario_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `likes`
--

INSERT INTO `likes` (`Comentario_ID`, `Usuario_ID`) VALUES
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Email` varchar(120) NOT NULL,
  `Senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Nome`, `Email`, `Senha`) VALUES
(1, 'Augusto Rodrigues Feltrin', 'guto.feltrin@gmail.com', '$2y$10$mmocUZeSEr1NWkxXwlUe2OHO2qNvw/7kOKt3ux/B7LL0SrXLl8QXe'),
(2, 'Mestre dos Magos', 'mestre@hotmail.com', '$2y$10$MCwpqUwewuOnsVWXg2DXTe/wSA0SHA6EMjjczG2ZXTJ4HWO4eT9J.');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Usuario_ID` (`Usuario_ID`);

--
-- Índices de tabela `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`Comentario_ID`,`Usuario_ID`),
  ADD KEY `Usuario_ID` (`Usuario_ID`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`Usuario_ID`) REFERENCES `usuarios` (`ID`);

--
-- Restrições para tabelas `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`Comentario_ID`) REFERENCES `comentarios` (`ID`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`Usuario_ID`) REFERENCES `usuarios` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
