-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Гру 15 2024 р., 17:45
-- Версія сервера: 8.0.24
-- Версія PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `librarydatabase`
--

DELIMITER $$
--
-- Процедури
--
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `Інформація_про_книги_вказаного_видавництва` (IN `publisher_arg` VARCHAR(30))  SELECT 
	books.title,
    authors.author_name,
    genres.genre_name,
    comments.comment_text
FROM 
	books
JOIN
	authors ON authors.author_id = books.author_id
JOIN
	genres ON genres.genre_id = books.genre_id
JOIN
	comments ON comments.book_id = books.book_id
WHERE
	books.publisher = publisher_arg$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `Відгуки_за_останні_30_днів` ()  BEGIN
SELECT 
    users.username, 
    books.title, 
    comments.date_of_publication, 
    comments.comment_text 
FROM 
    comments
JOIN 
    users ON comments.user_id = users.user_id
JOIN 
    books ON comments.book_id = books.book_id
WHERE 
    comments.date_of_publication > DATE_SUB(CURDATE(), INTERVAL 30 DAY);
END$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `Добавити_користувача` (IN `user_id` INT, IN `username` VARCHAR(20), IN `birthday` DATE, IN `email` VARCHAR(40), IN `password` VARCHAR(12))  BEGIN
INSERT INTO users(users.user_id,users.username,users.birthday,users.email,users.password) VALUES
(user_id, username,birthday,email,password);
END$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `Кількість_відгуків_залишених_користувачами` ()  SELECT 
    users.username, 
    COUNT(comments.comment_id) AS comment_count
FROM 
    comments
JOIN 
    users ON comments.user_id = users.user_id
GROUP BY 
    users.username$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `Неповернуті_книги` ()  SELECT 
	users.username,
    books.title,
    booking_and_borrowing.date_of_issue
FROM
	booking_and_borrowing
JOIN
	users ON users.user_id = booking_and_borrowing.user_id
JOIN
	books ON books.book_id = booking_and_borrowing.book_id
WHERE
	booking_and_borrowing.status = 'не повернуто'$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблиці `authors`
--

CREATE TABLE `authors` (
  `author_id` int NOT NULL,
  `author_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `biography` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `authors`
--

INSERT INTO `authors` (`author_id`, `author_name`, `birth_date`, `nationality`, `biography`) VALUES
(1, 'Леся Українка', '1871-02-25', 'Україна', 'Українська письменниця, поетеса, перекладачка.'),
(2, 'Іван Франко', '1856-11-27', 'Україна', 'Український письменник, поет, перекладач, науковий діяч, публіцист, політик.'),
(3, 'Тарас Шевченко', '1814-03-09', 'Україна', 'Український письменник, поет, художник, громадський діяч.'),
(4, 'Микола Гоголь', '1809-03-31', 'Україна', 'Український письменник, драматург, поет.'),
(5, 'Панас Мирний', '1849-01-03', 'Україна', 'Український письменник, перекладач, громадський діяч.'),
(6, 'Іван Котляревський', '1769-09-09', 'Україна', 'Український письменник, драматург, поет, перекладач, громадський діяч.'),
(7, 'Григорій Сковорода', '1794-09-11', 'Україна', 'Український філософ, письменник, поет, музикант.'),
(8, 'Ліна Костенко', '1930-03-19', 'Україна', 'Українська поетеса, перекладачка, літературознавець.'),
(9, 'Володимир Винниченко', '1860-02-26', 'Україна', 'Український письменник, драматург, політик.'),
(10, 'Михайло Коцюбинський', '1864-09-17', 'Україна', 'Український письменник, перекладач.'),
(11, 'Вільям Шекспір', '1564-04-23', 'Англія', 'Англійський драматург, поет і актор, який вважається найвидатнішим письменником в англійській мові та одним з найвидатніших драматургів світу.'),
(12, 'Данте Аліг\'єрі', '1265-03-27', 'Італія', 'Італійський поет, письменник і політичний діяч.'),
(13, 'Віктор Гюго', '1802-02-26', 'Франція', 'Французький письменник, поет, драматург, політик і громадський діяч, один з найвідоміших французьких письменників.'),
(14, 'Йоганн Вольфганг Гете', '1749-08-28', 'Німеччина', 'Німецький поет, драматург, прозаїк, науковець, державний діяч, театральний режисер і критик.'),
(15, 'Мігель де Сервантес', '1547-10-09', 'Іспанія', 'Іспанський письменник, який вважається одним з найвидатніших письменників в історії світової літератури.'),
(16, 'Марк Твен', '1835-11-30', 'США', 'Американський письменник, гуморист, сатирик, лектор і видавець.'),
(17, 'Чарльз Діккенс', '1812-02-07', 'Англія', 'Англійський письменник і соціальний критик, який вважається одним з найвидатніших письменників вікторіанської епохи.'),
(18, 'Оскар Уайльд', '1854-10-20', 'Ірландія', 'Ірландський письменник, поет, драматург, есеїст і критик.'),
(19, 'Ернест Хемінгуей', '1899-07-21', 'США', 'Американський письменник, новеліст і журналіст, якого часто називають одним з найвпливовіших письменників XX століття.'),
(20, 'Пауло Коельо', '1947-08-24', 'Бразилія', 'Народився в родині інженера. З дитинства мріяв стати письменником. Але в 1960-і роки в Бразилії мистецтво було заборонено військовою диктатурою. У той час слово «художник» було синонімом слів «гомосексуал», «комуніст», «наркоман» і «ледар». Турбуючись про майбутнє сина і намагаючись захистити його від переслідувань влади, батьки відправляють 17 літнього Пауло в психіатричну клініку. Вийшовши з клініки, Коельйо стає хіпі. Він читає все без перебору від Маркса й Леніна до «Бхагават-гіти». Потім засновує підпільний журнал «2001», у якому обговорювалися проблеми духовності, Апокаліпсис. Крім того Пауло писав тексти анархічних пісень. Рок-гурт Raul Seixas зробив ці тексти такими популярними, що Коельо відразу стає багатим і знаменитим. Він продовжує шукати себе: працює журналістом у газеті, намагається реалізуватися в театральній режисурі і драматургії.'),
(21, 'Куліш Пантелеймон Олександрович', '1819-08-07', 'Україна', 'Видатний діяч українського національного відродження, письменник, фольклорист, етнограф, мовознавець, перекладач, критик, редактор, видавець, філософ історії. Сприяв розвиткові української літературної мови, науки, філософії, історії. Був діяльним учасником Кирило-Мефодіївського товариства.');

-- --------------------------------------------------------

--
-- Структура таблиці `booking_and_borrowing`
--

CREATE TABLE `booking_and_borrowing` (
  `operation_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `book_id` int NOT NULL,
  `reservation_date` date DEFAULT NULL,
  `date_of_issue` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `status` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `booking_and_borrowing`
--

INSERT INTO `booking_and_borrowing` (`operation_id`, `user_id`, `book_id`, `reservation_date`, `date_of_issue`, `return_date`, `status`) VALUES
(1, 1, 1, '2023-01-01', '2023-01-02', '2023-01-15', 'повернена'),
(2, 4, 2, '2023-01-01', '2023-01-02', '2023-01-15', 'повернена'),
(3, 8, 3, '2023-01-03', '2023-01-04', '2023-01-18', 'повернена'),
(4, 2, 4, '2023-01-05', '2023-01-06', '2023-01-20', 'повернена'),
(5, 1, 5, '2023-01-07', '2023-01-08', '2023-01-22', 'повернена'),
(6, 9, 6, '2023-01-09', '2023-01-10', '2023-01-24', 'повернена'),
(7, 3, 7, '2023-01-11', '2023-01-12', '2023-01-26', 'повернена'),
(8, 4, 8, '2023-01-13', '2023-01-14', '2023-01-28', 'повернена'),
(9, 5, 9, '2023-01-15', '2023-01-16', '2023-01-30', 'повернена'),
(10, 2, 10, '2023-01-17', '2023-01-18', '2023-02-01', 'повернена'),
(11, 10, 11, '2023-01-19', '2023-01-20', '2023-02-03', 'повернена'),
(12, 19, 12, '2023-01-21', '2023-01-22', '2023-02-05', 'повернена'),
(13, 2, 13, '2023-01-23', '2023-01-24', '2023-02-07', 'повернена'),
(14, 15, 14, '2023-01-25', '2023-01-26', '2023-02-09', 'повернена'),
(15, 16, 15, '2023-01-27', '2023-01-28', '2023-02-11', 'повернена'),
(16, 11, 16, '2023-01-29', '2023-01-30', '2023-02-13', 'повернена'),
(17, 13, 17, '2023-01-31', '2023-02-01', '2023-02-15', 'повернена'),
(18, 20, 18, '2023-02-02', '2023-02-03', '2023-02-17', 'повернена'),
(19, 4, 19, '2023-02-04', '2023-02-05', '2023-02-19', 'повернена'),
(20, 7, 20, '2024-02-06', '2024-02-07', '2024-02-21', 'повернена'),
(21, 15, 19, '2024-06-14', '2024-06-16', '2024-06-26', 'не повернена');

-- --------------------------------------------------------

--
-- Структура таблиці `books`
--

CREATE TABLE `books` (
  `book_id` int NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `author_id` int DEFAULT NULL,
  `genre_id` int DEFAULT NULL,
  `publication_year` int DEFAULT NULL,
  `publisher` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `books`
--

INSERT INTO `books` (`book_id`, `title`, `author_id`, `genre_id`, `publication_year`, `publisher`) VALUES
(1, 'Триста поезій', 8, 2, 2019, 'А-ба-ба-га-ла-ма-га'),
(2, 'Лісова пісня', 1, 1, 2023, 'Видавництво Старого Лева'),
(3, 'Захар Беркут', 2, 3, 2022, 'Фоліо'),
(4, 'Кобзар', 3, 2, 2021, 'А-ба-ба-га-ла-ма-га'),
(5, 'Вечори на хуторі біля Диканьки', 4, 19, 2020, 'Наш Формат'),
(6, 'Хіба ревуть воли, як ясла повні', 5, 7, 2022, 'Клуб Сімейного Дозвілля'),
(7, 'Енеїда', 6, 4, 2021, 'Видавництво Жупанського'),
(8, 'Сад божественних пісень', 7, 2, 2023, 'Відкрита книга'),
(9, 'Маруся Чурай', 8, 1, 2023, 'Ранок'),
(10, 'Чорна рада', 21, 3, 2022, 'Фоліо'),
(11, 'Тіні забутих предків', 10, 3, 2021, 'Наш Формат'),
(12, 'Гамлет', 11, 1, 2020, 'А-ба-ба-га-ла-ма-га'),
(13, 'Божественна комедія', 12, 10, 2023, 'Фоліо'),
(14, 'Знедолені', 13, 7, 2022, 'Фоліо'),
(15, 'Фауст', 14, 10, 2021, 'Видавництво Жупанського'),
(16, 'Дон Кіхот', 15, 16, 2020, 'Наш Формат'),
(17, 'Пригоди Гекльберрі Фінна', 16, 17, 2022, 'Клуб Сімейного Дозвілля'),
(18, 'Великі сподівання', 17, 3, 2021, 'А-ба-ба-га-ла-ма-га'),
(19, 'Портрет Доріана Ґрея', 18, 18, 2020, 'Видавництво Старого Лева'),
(20, 'Старий і море', 19, 15, 2023, 'Фоліо'),
(21, 'Алхімік', 20, 14, 2022, 'Наш Формат'),
(22, 'На полі крові', 1, 1, 2024, 'Видавництво Старого Лева'),
(23, 'Каменярі', 2, 2, 2024, 'Фоліо'),
(24, 'Гайдамаки', 3, 4, 2023, 'А-ба-ба-га-ла-ма-га'),
(25, 'Тарас Бульба', 4, 16, 2024, 'Наш Формат'),
(26, 'Наталка Полтавка', 6, 1, 2024, 'Видавництво Жупанського'),
(27, 'Байки Харківські', 7, 11, 2011, 'Відкрита книга'),
(28, 'Берестечко', 8, 3, 2024, 'Ранок'),
(29, 'Сонячна машина', 9, 14, 2023, 'Фоліо');

-- --------------------------------------------------------

--
-- Структура таблиці `comments`
--

CREATE TABLE `comments` (
  `comment_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `date_of_publication` date DEFAULT NULL,
  `comment_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `book_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `date_of_publication`, `comment_text`, `book_id`) VALUES
(1, 1, '2023-04-18', 'Чіпляє за душу. Книга неймовірна!', 1),
(2, 2, '2024-01-15', 'Неймовірна книга, яка змушує задуматися про сенс життя.', 2),
(3, 3, '2024-01-16', 'Дуже сподобалась мова автора та його стиль викладу.', 3),
(4, 4, '2024-01-17', 'Це одна з найкращих книг, які я читав за останній час.', 4),
(5, 5, '2024-01-18', 'Глибокий сюжет і чудові персонажі. Рекомендую!', 5),
(6, 6, '2024-01-19', 'Книга залишила приємні враження і багато над чим змусила задуматись.', 6),
(7, 7, '2024-01-20', 'Цікава історія, хоча трохи затягнута.', 7),
(8, 8, '2024-01-21', 'Великий плюс книги - її емоційна насиченість.', 8),
(9, 9, '2024-01-22', 'Чудова книга, яку варто прочитати кожному.', 9),
(10, 10, '2024-01-23', 'Сюжет захоплюючий, не можливо відірватися.', 10),
(11, 11, '2024-01-24', 'Надзвичайно талановито написано, велика пошана автору.', 5),
(12, 12, '2024-01-25', 'Цікава книга, але іноді складно слідкувати за думками автора.', 4),
(13, 13, '2024-01-26', 'Книга захоплює з першої сторінки і не відпускає до останньої.', 14),
(14, 14, '2024-01-27', 'Дуже сподобалась, обов\'язково читатиму інші твори цього автора.', 17),
(15, 15, '2024-01-28', 'Історія дуже захоплююча, але місцями важка для сприйняття.', 19),
(16, 16, '2024-01-29', 'Великий плюс книги - її глибокий зміст та мораль.', 22),
(17, 17, '2024-01-30', 'Дуже вразила, ще довго не забуду цю історію.', 17),
(18, 18, '2024-01-31', 'Чудово написано, легко читається і запам\'ятовується.', 18),
(19, 19, '2024-02-01', 'Історія має глибокий сенс і змушує задуматися.', 19),
(20, 20, '2024-02-02', 'Дуже сподобалось, рекомендую всім.', 20),
(21, 21, '2024-02-03', 'Цікава і захоплююча книга, варто прочитати.', 6),
(22, 13, '2024-02-05', 'Сюжет непередбачуваний і захоплюючий.', 26),
(23, 1, '2024-02-06', 'Цікава книга, хоча й важка для сприйняття.', 28),
(24, 2, '2024-02-07', 'Дуже сподобалось, особливо кінцівка.', 19),
(25, 1, '2024-02-08', 'Книга захоплює з першої сторінки, дуже цікава.', 29),
(26, 14, '2024-02-09', 'Глибокий сюжет і чудові персонажі.', 7),
(27, 20, '2024-02-10', 'Великий плюс книги - її емоційна насиченість.', 12),
(28, 18, '2024-02-11', 'Чудова книга, яку варто прочитати кожному.', 30),
(29, 25, '2024-06-18', 'Сюжет захоплюючий, не можливо відірватися.', 5),
(30, 23, '2024-06-13', 'Надзвичайно талановито написано, велика пошана автору.', 30),
(35, 83, '2024-12-15', 'Чудова книга', 29);

-- --------------------------------------------------------

--
-- Структура таблиці `favorite_books`
--

CREATE TABLE `favorite_books` (
  `id` int NOT NULL,
  `book_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `author_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `favorite_books`
--

INSERT INTO `favorite_books` (`id`, `book_id`, `user_id`, `title`, `author_name`) VALUES
(12, 29, 83, 'Сонячна машина', 'Володимир Винниченко'),
(18, 12, NULL, 'Гамлет', 'Вільям Шекспір'),
(19, 12, NULL, 'Гамлет', 'Вільям Шекспір'),
(20, 12, NULL, 'Гамлет', 'Вільям Шекспір'),
(21, 12, NULL, 'Гамлет', 'Вільям Шекспір');

-- --------------------------------------------------------

--
-- Структура таблиці `genres`
--

CREATE TABLE `genres` (
  `genre_id` int NOT NULL,
  `genre_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `genres`
--

INSERT INTO `genres` (`genre_id`, `genre_name`, `description`) VALUES
(1, 'Драма', 'Літературний жанр, що зображає серйозні і важливі конфлікти в житті персонажів.'),
(2, 'Поезія', 'Літературний жанр, що виражає емоції та думки за допомогою ритмічної мови.'),
(3, 'Історичний роман', 'Літературний жанр, що відображає історичні події або епоху.'),
(4, 'Поема', 'Великий віршовий твір на епічну або ліричну тему.'),
(5, 'Ліричні твори', 'Жанр, що виражає особисті емоції та почуття автора.'),
(6, 'Фантастика', 'Жанр, що описує вигадані події, які не можуть відбутися в реальному світі.'),
(7, 'Соціально-побутовий роман', 'Жанр, що розкриває соціальні та побутові проблеми суспільства.'),
(8, 'Психологічний роман', 'Жанр, що досліджує внутрішній світ персонажів, їхні думки та емоції.'),
(9, 'Комедія', 'Літературний жанр, що має на меті розвеселити читача, часто використовує гумор.'),
(10, 'Філософські твори', 'Жанр, що досліджує основні питання буття, знання, моралі та сенсу життя.'),
(11, 'Байка', 'Невеликий алегоричний твір, що часто використовує сатиру або мораль.'),
(12, 'Біографія', 'Жанр, що описує життя і діяльність реальної людини.'),
(13, 'Автобіографія', 'Жанр, у якому автор розповідає про своє власне життя.'),
(14, 'Наукова фантастика', 'Жанр, що базується на наукових або псевдонаукових концепціях.'),
(15, 'Детектив', 'Жанр, в якому йдеться про розслідування злочинів і пошук злочинців.'),
(16, 'Пригодницький роман', 'Жанр, що описує захоплюючі і небезпечні подорожі та пригоди.'),
(17, 'Містика', 'Жанр, що включає елементи надприродного і загадкового.'),
(18, 'Романтика', 'Жанр, що описує любовні стосунки між персонажами.'),
(19, 'Фентезі', 'Жанр, що включає магію та інші надприродні елементи в вигаданому світі.'),
(20, 'Сатиричний роман', 'Жанр, що використовує гумор, іронію та сарказм для критики суспільства чи людей.');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`user_id`, `username`, `birthday`, `email`, `password`, `profile_photo`) VALUES
(1, 'IvanPetrov', '2002-06-06', 'ivan.petrov@example.com', 'password24', NULL),
(2, 'AnnaIvanova', '1995-03-09', 'anna.ivanova@example.com', NULL, NULL),
(3, 'OlegSidorov', '1998-07-22', 'oleg.sidorov@example.com', NULL, NULL),
(4, 'MariaKovalenko', '2001-10-28', 'maria.kovalenko@example.com', NULL, NULL),
(5, 'DmytroShevchenko', '1989-01-13', 'dmytro.shevchenko@example.com', NULL, NULL),
(6, 'NataliaBondarenko', '2000-05-04', 'natalia.bondarenko@example.com', NULL, NULL),
(7, 'OlenaHrytsenko', '1985-12-01', 'olena.hrytsenko@example.com', NULL, NULL),
(8, 'YuriyZinchenko', '1999-09-16', 'yuriy.zinchenko@example.com', NULL, NULL),
(9, 'SerhiyKuzmenko', '2004-11-21', 'serhiy.kuzmenko@example.com', NULL, NULL),
(10, 'IrynaLysenko', '1988-02-11', 'iryna.lysenko@example.com', NULL, NULL),
(11, 'OksanaMelnyk', '2002-03-09', 'oksana.melnyk@example.com', NULL, NULL),
(12, 'VolodymyrTkachenko', '2003-07-08', 'volodymyr.tkachenko@example.com', NULL, NULL),
(13, 'OleksandrKravets', '1994-08-22', 'oleksandr.kravets@example.com', NULL, NULL),
(14, 'ValentynaHnatyuk', '1997-11-25', 'valentyna.hnatyuk@example.com', NULL, NULL),
(15, 'AndriyYakovlev', '2005-03-19', 'andriy.yakovlev@example.com', NULL, NULL),
(16, 'TetianaKostenko', '1990-12-15', 'tetiana.kostenko@example.com', NULL, NULL),
(17, 'KaterynaSoroka', '1991-01-05', 'kateryna.soroka@example.com', NULL, NULL),
(18, 'MykolaTymoshenko', '1997-06-18', 'mykola.tymishenko@example.com', NULL, NULL),
(19, 'HalynaFedorchuk', '1988-09-17', 'halyna.fedorchuk@example.com', NULL, NULL),
(20, 'YuliaZadorozhna', '2000-11-26', 'yulia.zadorozhna@example.com', NULL, NULL),
(21, 'PetroBaran', '1979-11-01', 'petro.baran@example.com', NULL, NULL),
(22, 'NadiaMazur', '1993-02-07', 'nadia.mazur@example.com', NULL, NULL),
(23, 'BohdanShulha', '1996-04-13', 'bohdan.shulha@example.com', NULL, NULL),
(24, 'ViktorHavryliuk', '2003-02-21', 'viktor.havryliuk@example.com', NULL, NULL),
(25, 'RostyslavSemenyuk', '2000-08-16', 'rostyslav.semenyuk@example.com', NULL, NULL),
(83, 'serhii', '2024-11-24', 'aftanasserhii@gmail.com', '$2y$10$PADoDYMYQdmR4CPSwkdb8eyRZvt5SoUU6iFW3F70RtifWMmJwIOIi', NULL);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`),
  ADD UNIQUE KEY `author_name` (`author_name`);

--
-- Індекси таблиці `booking_and_borrowing`
--
ALTER TABLE `booking_and_borrowing`
  ADD PRIMARY KEY (`operation_id`),
  ADD KEY `user_id` (`user_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Індекси таблиці `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Індекси таблиці `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Індекси таблиці `favorite_books`
--
ALTER TABLE `favorite_books`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`,`email`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблиці `booking_and_borrowing`
--
ALTER TABLE `booking_and_borrowing`
  MODIFY `operation_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблиці `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблиці `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT для таблиці `favorite_books`
--
ALTER TABLE `favorite_books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблиці `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `booking_and_borrowing`
--
ALTER TABLE `booking_and_borrowing`
  ADD CONSTRAINT `booking_and_borrowing_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `booking_and_borrowing_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Обмеження зовнішнього ключа таблиці `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `authors` (`author_id`),
  ADD CONSTRAINT `books_ibfk_3` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`genre_id`);

--
-- Обмеження зовнішнього ключа таблиці `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
