

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `categorie` (`id`, `name`) VALUES
(1, 'kill'),
(2, 'love'),
(3, 'confusion'),
(4, 'money');



CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `potion_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `comment` (`id`, `description`, `potion_id`, `created_at`, `author`) VALUES
(1, 'Top top vraiment pas décue, mon ex est dead en 2 jours ! La folie !', 7, '2020-04-16 14:12:19', 'jenny'),
(2, 'Top top vraiment pas décue, ma belle mere est dead en 2 jours ! La folie !', 8, '2020-04-16 14:12:19', 'jenny'),
(3, 'Top top vraiment pas décue, mon boss est dead en 2 jours ! La folie !', 7, '2020-04-16 14:12:19', 'jenny'),
(4, 'Top top vraiment pas décue, mon ex est dead en 2 jours ! La folie !', 7, '2020-04-16 14:12:19', 'jenny'),
(5, 'Yeah vraiment genial money money', 8, '2020-04-16 16:49:53', 'jenny'),
(20, 'Yolo', 9, '2020-04-16 18:11:29', 'jenny'),
(22, 'Yolo', 10, '2020-04-16 18:13:09', 'jenny'),
(23, 'The format specifier is the same as supported by date, except when the filtered data is of type DateInterval, when the format must conform to DateInterval::format instead.', 10, '2020-04-16 18:26:25', 'jenny'),
(29, 'Mouahahahahahaah', 7, '2020-04-16 22:31:28', 'jenny'),
(30, 'J\'ai utilisé la potion sans probleme', 13, '2020-04-17 08:39:12', 'Gogole'),
(31, 'Fuck all of you i don\'t care', 13, '2020-04-17 08:39:57', 'Boobs'),
(32, 'Commentaire', 11, '2020-04-17 09:23:23', 'jenny'),
(33, 'Yo', 11, '2020-04-17 09:23:49', 'jenny'),
(34, 'Comment', 10, '2020-04-17 09:47:50', 'Jenny');



CREATE TABLE `magicien` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `magicien` (`id`, `email`, `password`) VALUES
(1, 'jenny@gmail.com', '1234');



CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `magicien_id` int(11) NOT NULL,
  `potion_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `panier` (`id`, `magicien_id`, `potion_id`, `qty`, `status_id`, `token`) VALUES
(4, 1, 9, 2, 1, 'Zi\",p6(>AV[U%}\"'),
(5, 1, 8, 3, 1, 'Zi\",p6(>AV[U%}\"'),
(6, 1, 9, 1, 1, 'LKW[<e\"41\'Z|]BV'),
(7, 1, 8, 4, 1, 'LKW[<e\"41\'Z|]BV'),
(8, 1, 12, 2, 1, 'LKW[<e\"41\'Z|]BV'),
(9, 1, 7, 1, 1, '_9DITo]\\FzqIpPJ'),
(10, 1, 13, 1, 1, 'MH#s85lafuhQu,r'),
(11, 1, 8, 3, 1, 'MH#s85lafuhQu,r'),
(12, 1, 11, 3, 1, 'BU<z:s*KzArlg}F'),
(13, 1, 9, 3, 1, 'BU<z:s*KzArlg}F'),
(14, 1, 14, 2, 1, 'BU<z:s*KzArlg}F');



CREATE TABLE `potion` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `potion` (`id`, `name`, `price`, `qty`, `category_id`, `score`) VALUES
(7, 'plop', 600, 40, 1, 11),
(8, 'fix', 50, 40, 1, 7),
(9, 'foo', 90, 10, 2, 10),
(10, 'it\'s a no', 40, 5, 4, 4),
(11, 'maybe', 100, 20, 3, 4),
(12, 'yolo', 50, 10, 4, 2),
(13, 'pink', 150, 40, 2, 2),
(14, 'plopinette', 42, 20, 3, 3);



CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `status` (`id`, `name`) VALUES
(1, 'in progress'),
(2, 'payed');


ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);


ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produit_id` (`potion_id`);


ALTER TABLE `magicien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);


ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `panier_id` (`potion_id`),
  ADD KEY `id` (`id`),
  ADD KEY `magicien_id` (`magicien_id`),
  ADD KEY `status_id` (`status_id`);


ALTER TABLE `potion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `id` (`id`) USING BTREE;

ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

ALTER TABLE `magicien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `potion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`potion_id`) REFERENCES `potion` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`potion_id`) REFERENCES `potion` (`id`),
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`magicien_id`) REFERENCES `magicien` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `panier_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `potion`
  ADD CONSTRAINT `potion_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categorie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;