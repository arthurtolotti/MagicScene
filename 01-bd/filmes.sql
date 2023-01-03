CREATE DATABASE  IF NOT EXISTS `filmes`;
USE `filmes`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `name` varchar(45) NOT NULL,
                         `email` varchar(45) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `photo` varchar(255) DEFAULT NULL,
                         `cpf` varchar(50) DEFAULT NULL,
                         `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
                         PRIMARY KEY (`id`),
                         UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES (1,'Arthur','arthuresquinatti@gmail.com','123456',NULL, NULL, NULL);
UNLOCK TABLES;

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `question` text NOT NULL,
                        `answer` text NOT NULL,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
LOCK TABLES `faqs` WRITE;
INSERT INTO `faqs` VALUES (1,'O que é o MagicScene?','O MagicScene é um serviço de transmissão online que oferece uma ampla variedade de filmes clássicos e favoritos da indústria cinematográfica. Você pode assistir a quantos filmes quiser, quando e onde quiser, sem comerciais – tudo por um preço mensal ou anual bem acessível. Aqui você sempre encontra novidades.'),
    (2,'Planos Mensais e Pacote Anual','Os planos são de R$9,90 por mês e R$109,90 por ano. Sem taxas extras.'),
    (3,'Onde posso assistir?','Assista onde e quando quiser. Faça login com sua conta MagicScene no nosso site para começar a assistir no computador ou em qualquer aparelho conectado à Internet.');
UNLOCK TABLES;

DROP TABLE IF EXISTS `filmes`;
CREATE TABLE `filmes` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `nome` text NOT NULL,
                        `genero` text NOT NULL,
                        `ano` int(4) NOT NULL,
                        `sinopse` text NOT NULL,
                        `foto` varchar(255) DEFAULT NULL,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
LOCK TABLES `filmes` WRITE;
INSERT INTO `filmes` VALUES
(10,'Shrek','Aventura | Comédia | Fantasia','2001','Em um pântano distante vive Shrek, um ogro solitário que vê, sem mais nem menos, sua vida ser invadida por uma série de personagens de contos de fada, como três ratos cegos, um grande e malvado lobo e ainda três porcos que não têm um lugar onde morar. Todos eles foram expulsos de seus lares pelo maligno Lorde Farquaad. Determinado a recuperar a tranquilidade de antes, Shrek resolve encontrar Farquaad e com ele faz um acordo: todos os personagens poderão retornar aos seus lares se ele e seu amigo Burro resgatarem uma bela princesa, que é prisioneira de um dragão. Porém, quando Shrek e o Burro enfim conseguem resgatar a princesa logo eles descobrem que seus problemas estão apenas começando.', NULL),
(9, 'Shrek 2', 'Aventura | Comédia | Fantasia', '2004', 'Após se casar com a Princesa Fiona, Shrek vive feliz em seu pântano. Ao retornar de sua lua-de-mel Fiona recebe uma carta de seus pais, que não sabem que ela agora é um ogro, convidando-a para um jantar juntamente com seu grande amor, na intenção de conhecê-lo. A muito custo Fiona consegue convencer Shrek a ir visitá-los, tendo ainda a companhia do Burro. Porém os problemas começam quando os pais de Fiona descobrem que ela não se casou com o Príncipe, a quem havia sido prometida, e enviam o Gato de Botas para separá-los.', NULL),
(8, 'Shrek Terceiro', 'Aventura | Comédia | Fantasia', '2007', 'O rei Harold, pai de Fiona, morre repentinamente. Com isto Shrek precisa ser coroado rei, algo que ele jamais pensou em ser. Juntamente com o Burro e o Gato de Botas, ele precisa encontrar alguém que possa substituí-lo no cargo de soberano do Reino de Tão, Tão Distante. O principal candidato é Artie, um jovem desprezado por todos em sua escola, que é primo de Fiona.', NULL),
(7, 'Shrek para Sempre', 'Aventura | Comédia | Fantasia', '2010', 'Há muito tempo ajustado à vida de casado e totalmente domesticado, Shrek fica entediado e começa a ter saudades dos dias em que se sentia um ogro de verdade. Para recuperá-los, ele firma um pacto com Rumpelstiltskin e é levado a um mundo onde ogros são caçados e ele e Fiona nunca se conheceram, além de que seus amigos Burro e Gato de Botas também não o reconhecem.', NULL),
(6, 'Crepúsculo', 'Aventura | Fantasia | Drama | Romance', '2008', 'A estudante Bella Swan conhece Edward Cullen, um belo mas misterioso adolescente. Edward é um vampiro, cuja família não bebe sangue, e Bella, longe de ficar assustada, se envolve em um romance perigoso com sua alma gêmea imortal.', NULL),
(5, 'A Saga Crepúsculo: Lua Nova', 'Aventura | Fantasia | Drama | Romance', '2009', 'Um incidente na festa de aniversário de Bella Swan faz com que Edward Cullen vá embora. Arrasada, Bella encontra consolo ao lado de Jacob Black. Aos poucos ela é atraída para o mundo dos lobisomens, ancestrais inimigos dos vampiros, e passa a ter sua lealdade testada. Quando descobre que a vida de Edward está em perigo, Bella corre contra o tempo para ajudá-lo no combate aos Volturi, um dos mais poderosos clãs de vampiros existentes.', NULL),
(4, 'A Saga Crepúsculo: Eclipse', 'Aventura | Fantasia | Drama | Romance', '2010', 'Bella Swan enfim está reunida a seu grande amor, Edward Cullen. Eles planejam se casar assim que chegar a formatura, o que marcará também a transformação de Bella em vampira. Apesar da vontade dela, Edward ainda é reticente em relação à transformação. Paralelamente, Jacob Black, apaixonado por Bella, decide lutar pelo seu amor. Só que a vida do trio está em perigo quando uma legião de vampiros recém criados começa a atacar em Seattle, cidade próxima ao local em que vivem.', NULL),
(3, 'A Saga Crepúsculo: Amanhecer: Parte 1', 'Aventura | Fantasia | Drama | Romance', '2011', 'Bella Swan e Edward Cullen enfim se casam, em cerimônia com a presença de amigos e familiares. O casal resolve passar a lua de mel no Rio de Janeiro e, logo em seguida, Bella engravida. O que eles não esperavam era que a gravidez seria tão complicada, colocando em risco a vida do bebê e da própria mãe.', NULL),
(2, 'A Saga Crepúsculo: Amanhecer: Parte 2', 'Aventura | Fantasia | Drama | Romance', '2012', 'Após dar a luz a Renesmee, Bella Swan desperta já vampira. Ela agora precisa aprender a lidar com seus novos poderes, assim como absorver a ideia de que Jake, seu melhor amigo, teve um imprinting com a filha. Devido ao elo existente entre eles, Jake passa a acompanhar com bastante atenção o rápido desenvolvimento de Renesmee, o que faz com que se aproxime cada vez mais dos Cullen. Paralelamente, Aro é informado por Irina da existência de Renesmee e de seus raros poderes.', NULL),
(1, 'Minha Mãe é uma Peça: O Filme', 'Comédia', '2012', 'Dona Hermínia é uma mulher de meia idade, divorciada do marido, que a trocou por uma mais jovem. Hiperativa, ela não larga o pé de seus filhos Marcelina e Juliano, que já estão bem grandinhos. Um dia, após descobrir que eles a consideram uma chata, resolve sair de casa sem avisar ninguém, deixando todos, de alguma forma, preocupados com o que teria acontecido. Mal sabem eles que a mãe foi visitar a querida tia Zélia para desabafar suas tristezas do presente e recordar os bons tempos do passado.', NULL);
UNLOCK TABLES;