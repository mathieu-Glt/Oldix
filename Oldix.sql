-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `category` (`id`, `name`, `slug`) VALUES
(1,	'action',	'action'),
(2,	'horror',	'horror'),
(3,	'science-fiction',	'science-fiction'),
(4,	'polar',	'polar'),
(5,	'romance',	'romance'),
(6,	'western',	'western'),
(7,	'drama',	'drama'),
(8,	'thriller',	'thriller'),
(9,	'comedy',	'comedy');

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20211022123001',	'2021-10-22 14:30:59',	573),
('DoctrineMigrations\\Version20211025124549',	'2021-10-25 14:46:28',	436);

DROP TABLE IF EXISTS `language`;
CREATE TABLE `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `language` (`id`, `name`, `slug`) VALUES
(1,	'english',	'english'),
(2,	'french',	'french'),
(3,	'silent',	'silent');

DROP TABLE IF EXISTS `movie`;
CREATE TABLE `movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `released_date` int(11) NOT NULL,
  `realisator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `synopsis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1D5EF26F82F1BAF4` (`language_id`),
  KEY `IDX_1D5EF26FA76ED395` (`user_id`),
  CONSTRAINT `FK_1D5EF26F82F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  CONSTRAINT `FK_1D5EF26FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `movie` (`id`, `language_id`, `user_id`, `name`, `slug`, `link`, `picture_url`, `released_date`, `realisator`, `synopsis`) VALUES
(1,	1,	NULL,	'The Driller Killer',	'the-driller-killer',	'https://www.youtube.com/watch?v=c0wr-PFTN2k&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BYmE3Yzc1ZTktMDAwNC00OTg0LWI1ZmYtMzg2NDNiOWRlZjkwXkEyXkFqcGdeQXVyMjI4MjA5MzA@._V1_SX300.jpg',	1979,	'Abel Ferrara',	'An artist slowly goes insane while struggling to pay his bills, work on his paintings, and care for his two female roommates, which leads him taking to the streets of New York after dark and randomly killing derelicts with a power drill.'),
(2,	2,	NULL,	'Plan 9 from Outer Space',	'plan-9-from-outer-space',	'https://www.youtube.com/watch?v=DXTC2Ob8spY&ab_channel=PublicDomainDatabase',	'https://m.media-amazon.com/images/M/MV5BMjExMzJhYTYtZDlhNC00NDIyLWIyMGUtMDBhOGE3MzAzMjA1XkEyXkFqcGdeQXVyNjMwMjk0MTQ@._V1_SX300.jpg',	1957,	'Ed Wood',	'Evil aliens attack Earth and set their terrible \"Plan 9\" into action. As the aliens resurrect the dead of the Earth, the lives of the living are in danger.'),
(3,	1,	NULL,	'Scarlet Street',	'scarlet-street',	'https://www.youtube.com/watch?v=MNRSxu22NxU&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BMzY1ODRkN2MtNWM5My00ZDNiLTk0YzUtMzBkMGQ0NmUxODRkXkEyXkFqcGdeQXVyNDY2MTk1ODk@._V1_SX300.jpg',	1945,	'Fritz Lang',	'A man in mid-life crisis befriends a young woman, though her fiancé persuades her to con him out of the fortune they mistakenly assume he possesses.'),
(4,	1,	NULL,	'Black Dragons',	'black-dragons',	'https://www.youtube.com/watch?v=gXJamhA22S4&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BY2U0NjJmYjMtZDUzZi00YzVkLTkwNWEtOGFkYTg3ZDQ0YjYwXkEyXkFqcGdeQXVyMTQ2MjQyNDc@._V1_SX300.jpg',	1942,	'William Nigh',	'A cabal of American industrialists, all fifth-columnists intent on sabotaging the war effort.,'),
(5,	1,	NULL,	'Maniac',	'maniac',	'https://www.youtube.com/watch?v=5gYnHa4izjo&ab_channel=BloodyCinemaUSA',	'https://m.media-amazon.com/images/M/MV5BMDFiNmJhYTQtYWQ0MS00OTEwLWJkNjQtMDIzNWQ3NjExMTg4XkEyXkFqcGdeQXVyOTI2MjI5MQ@@._V1_SX300.jpg',	1934,	'Dwain Esper',	'A former vaudevillian gifted at impersonation assists a mad scientist in reanimating corpses and soon goes mad himself.'),
(6,	2,	NULL,	'And then there were none',	'and-then-there-were-none',	'https://www.youtube.com/watch?v=pS7-Ccl9ayQ&ab_channel=Cin%C3%A9clap',	'https://m.media-amazon.com/images/M/MV5BYThiMzJiNzMtMzI4My00MmFmLThjODctNWE2MjMwZTM1NGFkXkEyXkFqcGdeQXVyNjUwMzI2NzU@._V1_SX300.jpg',	1945,	'René Clair',	'\"Seven guests, a newly hired secretary and two staff are gathered at a manor house on an isolated island by an unknown absentee host and are killed off one-by-one. They work together to determine who the killer is before it\'s too late'),
(7,	3,	NULL,	'The Birth of a Nation',	'the-birth-of-a-nation',	'https://www.youtube.com/watch?v=nGQaAddwjxg&ab_channel=JamesBuck',	'https://m.media-amazon.com/images/M/MV5BNWZlNjg5ZTYtM2JiMi00MDZkLTlmOWQtYmMzMGY2NDc0NjdjXkEyXkFqcGdeQXVyMzg1ODEwNQ@@._V1_SX300.jpg',	1915,	'D.W Griffith',	'The Stoneman family finds its friendship with the Camerons affected by the Civil War, both fighting in opposite armies. The development of the war in their lives plays through to Lincoln\'s assassination and the birth of the Ku Klux K'),
(8,	2,	NULL,	'L\'Egyptien',	'egyptien',	'https://www.youtube.com/watch?v=TcmpoRJISIM&ab_channel=lepeplum',	'https://m.media-amazon.com/images/M/MV5BNzE3N2Y4NzAtNzY1Yi00MTliLTkxNzEtNGZhM2EyYWQ0MTdmXkEyXkFqcGdeQXVyMDI2NDg0NQ@@._V1_SX300.jpg',	1954,	'Michael Curtiz',	'In ancient Egypt, a poor orphan becomes a genial physician and is eventually appointed at the Pharaoh\'s court where he witnesses palace intrigues and learns dangerous royal secrets.'),
(15,	1,	NULL,	'Modern Times',	'modern-times',	'https://www.youtube.com/watch?v=2gLa4wAia9g&t=1s&ab_channel=Timepass',	'https://m.media-amazon.com/images/M/MV5BYjJiZjMzYzktNjU0NS00OTkxLWEwYzItYzdhYWJjN2QzMTRlL2ltYWdlL2ltYWdlXkEyXkFqcGdeQXVyNjU0OTQ0OTY@._V1_SX300.jpg',	1936,	'Charles Chaplin',	'The Tramp struggles to live in modern industrial society with the help of a young homeless woman.'),
(16,	3,	NULL,	'The Kid',	'the-kid',	'https://www.youtube.com/watch?v=LQE0c1Zugx8&ab_channel=PaulMinaStorm',	'https://m.media-amazon.com/images/M/MV5BZjhhMThhNDItNTY2MC00MmU1LTliNDEtNDdhZjdlNTY5ZDQ1XkEyXkFqcGdeQXVyNjc1NTYyMjg@._V1_SX300.jpg',	1921,	'Charles Chaplin',	'The Tramp cares for an abandoned child, but events put that relationship in jeopardy.'),
(17,	1,	NULL,	'His Girl Friday',	'his-girl-friday',	'https://www.youtube.com/watch?v=kmYcT5gT6a4&ab_channel=Retrospective',	'https://m.media-amazon.com/images/M/MV5BZDVmZTZkYjMtNmViZC00ODEzLTgwNDAtNmQ3OGQwOWY5YjFmXkEyXkFqcGdeQXVyNDY2MTk1ODk@._V1_SX300.jpg',	1940,	'Howard Hawks',	'A newspaper editor uses every trick in the book to keep his ace reporter ex-wife from remarrying.'),
(21,	2,	NULL,	'M - Eine Stadt sucht einen Mörder',	'm-eine-stadt-sucht-einen-mörder',	'https://www.youtube.com/watch?v=ssdtn60srNc&ab_channel=LesClassiques',	'https://m.media-amazon.com/images/M/MV5BODA4ODk3OTEzMF5BMl5BanBnXkFtZTgwMTQ2ODMwMzE@._V1_SX300.jpg',	1931,	'Fritz Lang',	'When the police in a German city are unable to catch a child-murderer, other criminals join in the manhunt.'),
(22,	1,	NULL,	'Meet John Doe',	'meet-john-doe',	'https://www.youtube.com/watch?v=U-0b4U5d8Ag&ab_channel=FilmClassiqueComplet',	'https://m.media-amazon.com/images/M/MV5BMjJmOGYwNmItMjI5MS00ZGE2LWJlNDUtODZjYTBjNGQ1MTg5XkEyXkFqcGdeQXVyNDE5MTU2MDE@._V1_SX300.jpg',	1941,	'Frank Capra',	'A penniless drifter is recruited by an ambitious columnist to impersonate a non-existent person who said he\'d be committing suicide as a protest, and a political movement begins.'),
(23,	1,	NULL,	'His Girl Friday',	'his-girl-friday',	'https://www.youtube.com/watch?v=kmYcT5gT6a4&t=2s&ab_channel=Retrospective',	'https://m.media-amazon.com/images/M/MV5BZDVmZTZkYjMtNmViZC00ODEzLTgwNDAtNmQ3OGQwOWY5YjFmXkEyXkFqcGdeQXVyNDY2MTk1ODk@._V1_SX300.jpg',	1940,	'Howard Hawks',	'A newspaper editor uses every trick in the book to keep his ace reporter ex-wife from remarrying.'),
(27,	2,	NULL,	'The 39 Steps',	'the-39-steps',	'https://www.youtube.com/watch?v=0YFcTgr2rw4&ab_channel=SlopeRiderSC',	'https://m.media-amazon.com/images/M/MV5BMTY5ODAzMTcwOF5BMl5BanBnXkFtZTcwMzYxNDYyNA@@._V1_SX300.jpg',	1935,	'Alfred Hitchcock',	'A man in London tries to help a counter-espionage Agent. But when the Agent is killed, and the man stands accused, he must go on the run to save himself and stop a spy ring which is trying to steal top secret information.'),
(28,	2,	NULL,	'Les diaboliques',	'les-diaboliques',	'https://www.youtube.com/watch?v=h66gU9prCeM&ab_channel=CINEMAWORLD',	'https://m.media-amazon.com/images/M/MV5BZDVlZDdjNDktN2M4ZC00NjdkLThiMDctM2FiZWNlYjIzNDExXkEyXkFqcGdeQXVyMTA1NTM1NDI2._V1_SX300.jpg',	1955,	'Henri-Georges Clouzot',	'The wife and mistress of a loathed school principal plan to murder him with what they believe is the perfect alibi.'),
(29,	1,	NULL,	'Night of the Living Dead',	'night-of-the-living-dead',	'https://www.youtube.com/watch?v=xYq3zDfZcTg&ab_channel=gougouneprod',	'https://m.media-amazon.com/images/M/MV5BMzRmN2E1ZDUtZDc2ZC00ZmI3LTkwOTctNzE2ZDIzMGJiMTYzXkEyXkFqcGdeQXVyMTQxNzMzNDI@._V1_SX300.jpg',	1968,	'George A. Romero',	'A ragtag group of Pennsylvanians barricade themselves in an old farmhouse to remain safe from a horde of flesh-eating ghouls that are ravaging the East Coast of the United States.'),
(30,	2,	NULL,	'The Lady Vanishes',	'the-lady-vanishes',	'https://www.youtube.com/watch?v=KL0zOEd6aWo&ab_channel=lesgrandsfilmsdel%27histoire',	'https://m.media-amazon.com/images/M/MV5BNjk3YzFjYTktOGY0ZS00Y2EwLTk2NTctYTI1Nzc2OWNiN2I4XkEyXkFqcGdeQXVyNzM0MTUwNTY@._V1_SX300.jpg',	1938,	'Alfred Hitchcock',	'While travelling in continental Europe, a rich young playgirl realizes that an elderly lady seems to have disappeared from the train.'),
(31,	1,	NULL,	'My Man Godfrey',	'my-man-godfrey',	'https://www.youtube.com/watch?v=qt2ntYiLYeI&ab_channel=TCC-TimelessClassicsNowinColor',	'https://m.media-amazon.com/images/M/MV5BNmMwZTJlMTctYjM5Ni00Zjg4LWEzN2EtZmJlZjcyMmMzM2NiL2ltYWdlXkEyXkFqcGdeQXVyMDI2NDg0NQ@@._V1_SX300.jpg',	1936,	'Gregory La Cava',	'A scatterbrained socialite hires a vagrant as a family butler - but there\'s more to Godfrey than meets the eye.'),
(32,	2,	NULL,	'Charade',	'charade',	'https://www.youtube.com/watch?v=5Ojng5VLy2o&ab_channel=CultureTube',	'https://m.media-amazon.com/images/M/MV5BMTA0Y2UyMDUtZGZiOS00ZmVkLTg3NmItODQyNTY1ZjU1MWE4L2ltYWdlL2ltYWdlXkEyXkFqcGdeQXVyNjc1NTYyMjg@._V1_SX300.jpg',	1963,	'Stanley Donen',	'Romance and suspense ensue in Paris as a woman is pursued by several men who want a fortune her murdered husband had stolen. Whom can she trust?'),
(33,	3,	NULL,	'Steamboat Bill, Jr.',	'steamboat-bill-jr-',	'https://www.youtube.com/watch?v=n9QPfiLuQ9c&ab_channel=10000.PublicDomainMovies',	'https://m.media-amazon.com/images/M/MV5BOTg2MjUyMjYyOV5BMl5BanBnXkFtZTgwNjM0NDAwMjE@._V1_SX300.jpg',	1928,	'Charles Reisner, Buster Keaton',	'The effete son of a cantankerous riverboat captain comes to join his father\'s crew.'),
(34,	3,	NULL,	'The General',	'the-general',	'https://www.youtube.com/watch?v=x3HioYRd0Ck&ab_channel=LesTrainsDeFrance',	'https://m.media-amazon.com/images/M/MV5BYmRiMDFlYjYtOTMwYy00OGY2LWE0Y2QtYzQxOGNhZmUwNTIxXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_SX300.jpg',	1926,	'Clyde Bruckman, Buster Keaton',	'When Union spies steal an engineer\'s beloved locomotive, he pursues it single-handedly and straight through enemy lines.'),
(35,	1,	NULL,	'Der blaue Engel',	'der-blaue-engel',	'https://www.youtube.com/watch?v=4tRguhbp018&ab_channel=ArtHouseMedia',	'https://m.media-amazon.com/images/M/MV5BMmExOWQyYmUtMDZlZS00ZWQxLWE3YWQtMmM2ZmJhNWJhYzExXkEyXkFqcGdeQXVyNDE5MTU2MDE@._V1_SX300.jpg',	1930,	'Josef von Sternberg',	'An elderly professor\'s ordered life spins dangerously out of control when he falls for a nightclub singer.'),
(36,	1,	NULL,	'My Favorite Brunette',	'my-favorite-brunette',	'https://www.youtube.com/watch?v=XtaWk9ScjV8&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BZWViOWUxY2EtOTVmMC00NWYwLTk2ZWQtYmM5YjE5YmQzZDBmL2ltYWdlXkEyXkFqcGdeQXVyMDI2NDg0NQ@@._V1_SX300.jpg',	1947,	'Elliott Nugent',	'Shortly before his execution on the death row in San Quentin, amateur sleuth and baby photographer Ronnie Jackson, tells reporters how he got there.'),
(37,	1,	NULL,	'Little Shop of Horrors',	'little-shop-of-horrors',	'https://www.youtube.com/watch?v=Mc6UufvOkDg&ab_channel=CultureTube',	'https://m.media-amazon.com/images/M/MV5BOGE3OTgxMTUtZWUyNC00OTlhLWE5MzMtOWU2ZjMwZDAxNzA0XkEyXkFqcGdeQXVyNjUwNzk3NDc@._V1_SX300.jpg',	1960,	'Roger Corman',	'A clumsy young man nurtures a plant and discovers that it\'s carnivorous, forcing him to kill to feed it.'),
(38,	1,	NULL,	'Carnival of Souls',	'carnival-of-souls',	'https://www.youtube.com/watch?v=vNYg4YWkp0k&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BYjgxYjI1ODktNWYyNy00N2EyLWFhOWEtMmI1ZmU3ZmU5ZWFjXkEyXkFqcGdeQXVyNjc1NTYyMjg@._V1_SX300.jpg',	1962,	'Herk Harvey',	'After a traumatic accident, a woman becomes drawn to a mysterious abandoned carnival.'),
(39,	1,	NULL,	'The Last Man on Earth',	'the-last-man-on-earth',	'https://www.youtube.com/watch?v=feQIhzNpBLQ&ab_channel=ARF',	'https://m.media-amazon.com/images/M/MV5BODA0MzRhYWMtMGUxYi00NmQyLWEyOWYtMGI4NjM3ZDE5NTEyXkEyXkFqcGdeQXVyMTQxNzMzNDI@._V1_SX300.jpg',	1964,	'Ubaldo Ragona',	'When a disease turns all of humanity into the living dead, the last man on earth becomes a reluctant vampire hunter.'),
(40,	1,	NULL,	'Dementia 13',	'dementia-13',	'https://www.youtube.com/watch?v=MtFQCuuNDLU&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BM2ViNWNhNjYtYzY3Ni00YzMxLTkzZGItZGI5MzdkZjc0OTk3XkEyXkFqcGdeQXVyNTc1NTQxODI@._V1_SX300.jpg',	1963,	'Francis Ford Coppola',	'Shocked by the death of her spouse, a scheming widow hatches a bold plan to get her hands on the inheritance, unaware that she is targeted by an axe-wielding murderer who lurks in the family\'s estate. What mystery shrouds the noble h'),
(41,	1,	NULL,	'The Gorilla',	'the-gorilla',	'https://www.youtube.com/watch?v=IP1xlXj76Mw&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BNmFlMmJhNWQtNmUxNS00YTgzLTk1ZTYtNDNkNDMyNDU0MDU4XkEyXkFqcGdeQXVyMzg1ODEwNQ@@._V1_SX300.jpg',	1939,	'Allan Dwan',	'When a wealthy man is threatened by a killer known as The Gorilla, he hires the Ritz Brothers to investigate. A real escaped gorilla shows up at the mansion just as the investigators arrive.'),
(42,	1,	NULL,	'Santa Claus Conquers the Martians',	'santa-claus-conquers-the-martians',	'https://www.youtube.com/watch?v=0d8beSTsMjU&ab_channel=CLASSICTV',	'https://m.media-amazon.com/images/M/MV5BZDllYzM0YjktYWNjOC00MjZjLWE2Y2EtOGRkMTY1N2I3MjUxXkEyXkFqcGdeQXVyMTQ2MjQyNDc@._V1_SX300.jpg',	1964,	'Nicholas Webster',	'The Martians kidnap Santa Claus because there is nobody on Mars to give their children presents.'),
(43,	1,	NULL,	'La figlia di Frankenstein',	'la-figlia-di-frankenstein',	'https://www.youtube.com/watch?v=kKHbY-dYQyg&ab_channel=TheCurator',	'https://m.media-amazon.com/images/M/MV5BN2UxYTE3MDctNWNhNC00ZmMwLTk0NzUtZTczOTgxMjJjNDFjXkEyXkFqcGdeQXVyMTQ2MjQyNDc@._V1_SX300.jpg',	1971,	'Mel Welles, Aureliano Luppi',	'After Baron Frankenstein is killed by his own monster, his daughter transplants his assistant\'s brain into a handsome young body, all while the original monster seeks revenge against those who participated in its creation.'),
(44,	1,	NULL,	'Captain Kidd',	'captain-kidd',	'https://www.youtube.com/watch?v=6BVn4GQDFUo&ab_channel=TCC-TimelessClassicsNowinColor',	'https://m.media-amazon.com/images/M/MV5BMGM5YzUwZmItMDYwOC00ZTY0LTk5ZTMtNzRiNzVlNGFkYTg4L2ltYWdlXkEyXkFqcGdeQXVyNjQzNDI3NzY@._V1_SX300.jpg',	1945,	'Rowland V. Lee',	'The unhistorical adventures of pirate Captain Kidd revolve around treasure and treachery.'),
(45,	1,	NULL,	'A Farewell to Arms',	'a-farewell-to-arms',	'https://www.youtube.com/watch?v=N-gnY_yr3aY&ab_channel=ClassicMovies',	'https://m.media-amazon.com/images/M/MV5BMzM2ODc0NTY3OF5BMl5BanBnXkFtZTgwMjQwNzkzMjE@._V1_SX300.jpg',	1932,	'Frank Borzage',	'An American ambulance driver and an English nurse fall in love in Italy during World War I.'),
(46,	1,	NULL,	'A Matter of Life and Death',	'a-matter-of-life-and-death',	'https://www.youtube.com/watch?v=-t3Xv70vkY8&ab_channel=OrphanedEntertainment',	'https://m.media-amazon.com/images/M/MV5BZmQzZjIyN2EtOWI5Ni00ZDgyLTk4NGQtZmQ3ZWRhODIyZTVlXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_SX300.jpg',	1946,	'Michael Powell, Emeric Pressburger',	'A British wartime aviator who cheats death must argue for his life before a celestial court, hoping to prolong his fledgling romance with an American girl.'),
(48,	1,	NULL,	'Robinson Crusoe',	'robinson-crusoe',	'https://www.youtube.com/watch?v=q9XiaDmgB78&ab_channel=VintageMovieChannel',	'https://m.media-amazon.com/images/M/MV5BNjk2N2Y5YmUtYzMxYy00ZTRkLTlhN2ItOGI1M2Q0ODI4NGNjXkEyXkFqcGdeQXVyMDUyOTUyNQ@@._V1_SX300.jpg',	1954,	'Luis Bunuel',	'The classic story of Robinson Crusoe, a man who is dragged to a desert island after a shipwreck.'),
(49,	1,	NULL,	'Angel on My Shoulder',	'angel-on-my-shoulder',	'https://www.youtube.com/watch?v=08QKp0nH-sY&ab_channel=PizzaFlix',	'https://m.media-amazon.com/images/M/MV5BZDYwZTQzNTgtNTk1NS00YjdkLWFiODUtZjQwN2Q2NGFkNDZmXkEyXkFqcGdeQXVyMTMxMTY0OTQ@._V1_SX300.jpg',	1946,	'Archie Mayo',	'The Devil arranges for a deceased gangster to return to Earth as a well-respected judge to make up for his previous life.'),
(50,	1,	NULL,	'Becky Sharp',	'becky-sharp',	'https://www.youtube.com/watch?v=AYLDF9MK-9k&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BZjMxMjE0YTYtNjhiMi00ZDU4LTgwODctZWI4MjljYWE3YWM4XkEyXkFqcGdeQXVyNjc0MzMzNjA@._V1_SX300.jpg',	1935,	'Rouben Mamoulian',	'Set against the background of the Battle of Waterloo, Becky Sharp is the story of Vanity Fair by Thackeray. Becky and Amelia are girls at school together, but Becky is from a \"show biz\" family, or in other words, very low class. Beck'),
(52,	1,	NULL,	'Cyrano de Bergerac',	'cyrano-de-bergerac',	'https://www.youtube.com/watch?v=0J0RFoHGFtY&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BMmRkMTVlNTEtOWQxNC00OGY4LWIzMzQtMjY2MTZjNDU2N2ViXkEyXkFqcGdeQXVyNjMwMjk0MTQ@._V1_SX300.jpg',	1951,	'Michael Gordon',	'The charismatic swordsman-poet helps another woo the woman he loves in this straightforward version of the play'),
(53,	1,	NULL,	'The Ghost Train',	'the-ghost-train',	'https://www.youtube.com/watch?v=mcaGaAv8v8I&ab_channel=ChristopherMeeker',	'https://m.media-amazon.com/images/M/MV5BNTNjNjUwZGEtNGIyYy00M2E0LTg3MWYtZWUwMmY5N2VkZDdjXkEyXkFqcGdeQXVyNjE5MjUyOTM@._V1_SX300.jpg',	1941,	'Walter Forde',	'High jinks and chills ensue when a group of people become stranded at an isolated station and a legendary phantom train approaches.'),
(54,	1,	NULL,	'Great Expectations',	'great-expectations',	'https://www.youtube.com/watch?v=DJABptpYaJE&ab_channel=LiteratureisMyUtopia',	'https://m.media-amazon.com/images/M/MV5BZjA1YTQ1NGItZDI0OS00MTFiLTg1NTUtOWViMTg0ZDA4MWMyL2ltYWdlL2ltYWdlXkEyXkFqcGdeQXVyNjUwNzk3NDc@._V1_SX300.jpg',	1998,	'David Lean',	'A humble orphan suddenly becomes a gentleman with the help of an unknown benefactor'),
(55,	1,	NULL,	'Hell\'s Angels',	'hell-s-angels',	'https://www.youtube.com/watch?v=GhyNpM5FKNE&ab_channel=GlenFinnan',	'https://m.media-amazon.com/images/M/MV5BMzMwODM4MzE2MF5BMl5BanBnXkFtZTgwNTc0NTgyMjE@._V1_SX300.jpg',	1930,	'Howard Hughes, Edmund Goulding, James Whale',	'Brothers Monte and Ray leave Oxford to join the Royal Flying Corps. Ray loves Helen; Helen enjoys an affair with Monte; before they leave on their mission over Germany they find her in still another man\'s arms.'),
(56,	1,	NULL,	'Hell\'s House',	'hell-s-house',	'https://www.youtube.com/watch?v=FvRbFnPQDpI',	'https://m.media-amazon.com/images/M/MV5BNzEwZTIxMzItMTA2ZC00MDg2LWFlY2YtZmVkNjJjZjE1ZTBiXkEyXkFqcGdeQXVyMjUxODE0MDY@._V1_SX300.jpg',	1932,	'Howard Higgin',	'Jimmy idolizes bootlegger Matt, and when he refuses to implicate his friend, he is sent to reform school. He befriends Shorty, a boy with a heart condition, and escapes to let the world know about the brutal conditions.'),
(58,	1,	NULL,	'Hi Diddle Diddle',	'hi-diddle-diddle',	'https://www.youtube.com/watch?v=Nnr3BRjeqOY&ab_channel=TheFilmDetective',	'https://m.media-amazon.com/images/M/MV5BODRjOWY5MTQtODdmZC00NmFiLTgxZDYtZTZhMTg2ZGMzMTdhXkEyXkFqcGdeQXVyMzg1ODEwNQ@@._V1_SX300.jpg',	1943,	'Andrew L. Stone, Friz Freleng',	'When the bride\'s mother is supposedly swindled out of her money by a spurned suitor, the groom\'s father orchestrates a scheme of his own to set things right. He is aided by a cabaret singer, while placating a jealous wife.'),
(59,	1,	NULL,	'Indiscreet',	'indiscreet',	'https://www.youtube.com/watch?v=h26o52Oqbz0&ab_channel=DavidSwinson',	'https://m.media-amazon.com/images/M/MV5BMzlhMzJiODctNjdlYS00ZGIwLWExNzQtZWM2MTNjNGE2OTI5XkEyXkFqcGdeQXVyNjMwMjk0MTQ@._V1_SX300.jpg',	1958,	'Stanley Donen',	'An actress who has given up on love meets a suave banker and begins a flirtation with him...even though he\'s already married.'),
(60,	1,	NULL,	'Jungle Book',	'jungle-book',	'https://www.youtube.com/watch?v=-8EJ9uhsfQQ&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BZDhhNGU3ZmYtNjlkMy00Njc1LTgyZWUtYTlmOWVjODE0NGU0L2ltYWdlXkEyXkFqcGdeQXVyMjI4MjA5MzA@._V1_SX300.jpg',	1942,	'Zoltan Korda',	'A boy raised by wild animals tries to adapt to human village life.'),
(61,	1,	NULL,	'Murder in Harlem',	'murder-in-harlem',	'https://www.youtube.com/watch?v=rSi-iWGxtLY&ab_channel=reelblack',	'https://m.media-amazon.com/images/M/MV5BODk2MTg2MzAzN15BMl5BanBnXkFtZTgwNTY1NDg2NjE@._V1_SX300.jpg',	1935,	'Oscar Micheaux, Clarence Williams',	'A black night watchman at a chemical factory finds the body of a murdered white woman. After he reports it, he finds himself accused of the murder.'),
(62,	1,	NULL,	'Our Town',	'our-town',	'https://www.youtube.com/watch?v=k-ImAugEJzg&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BMTgxMWIwN2QtY2FkMi00YmM1LTg4NGEtMTQ4YTQwOTA2NWNkXkEyXkFqcGdeQXVyMTYzMTY1MjQ@._V1_SX300.jpg',	1940,	'Sam Wood',	'Change comes slowly to a small New Hampshire town in the early 20th century.'),
(63,	1,	NULL,	'Penny Serenade',	'penny-serenade',	'https://www.youtube.com/watch?v=ajutb8gwdH4&ab_channel=CinecurryHollywood',	'https://m.media-amazon.com/images/M/MV5BMGVjYzU4NjAtOWVkYi00OWQ3LWEwYzMtOTI2ZWY3YTQ1ZGM4L2ltYWdlXkEyXkFqcGdeQXVyNDQzMDg4Nzk@._V1_SX300.jpg',	1941,	'George Stevens',	'A couple\'s big dreams give way to a life full of unexpected sadness and unexpected joy.'),
(64,	1,	NULL,	'Pygmalion',	'pygmalion',	'https://www.youtube.com/watch?v=ygBkAcyYkW0&ab_channel=AllTimeClassicMovies',	'https://m.media-amazon.com/images/M/MV5BNTgzN2NkMTAtYTc0Yy00ODc1LWI5ZTktNDIzNGFjY2M3NDhlXkEyXkFqcGdeQXVyMzg1ODEwNQ@@._V1_SX300.jpg',	1938,	'Anthony Asquith, Leslie Howard',	'A phonetics and diction expert makes a bet that he can teach a cockney flower girl to speak proper English and pass as a lady in high society.'),
(66,	1,	NULL,	'Sherlock Holmes and the Secret Weapon',	'sherlock-holmes-and-the-secret-weapon',	'https://www.youtube.com/watch?v=CsZQNdMKbNs&ab_channel=FEATUREFILM',	'https://m.media-amazon.com/images/M/MV5BYzA5MWEwNzctMWYwOC00YTViLWFjYzMtM2MyNmY5NzNmNjRhXkEyXkFqcGdeQXVyMzUwMTgwMw@@._V1_SX300.jpg',	1942,	'Roy William Neill',	'Sherlock Holmes and Doctor Watson must protect a Swiss inventor of an advanced bomb sight from falling into German hands.'),
(67,	1,	NULL,	'Terror by Night',	'terror-by-night',	'https://www.youtube.com/watch?v=WBddAy-ZU-w&ab_channel=TCC-TimelessClassicsNowinColor',	'https://m.media-amazon.com/images/M/MV5BMTI2NzAzNzYwN15BMl5BanBnXkFtZTYwMTQyNzk4._V1_SX300.jpg',	1946,	'Roy William Neill',	'When the fabled Star of Rhodesia diamond is stolen on a London to Edinburgh train and the son of its owner is murdered, Sherlock Holmes must discover which of his suspicious fellow passengers is responsible.'),
(68,	1,	NULL,	'The Bigamist',	'the-bigamist',	'https://www.youtube.com/watch?v=c9SxWhURBYA&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BNTEyODQ5YWQtYTA3MS00ZmJkLWFjMTQtMDI4NmExN2QxYTM2XkEyXkFqcGdeQXVyMjA0MzYwMDY@._V1_SX300.jpg',	1953,	'Ida Lupino',	'A man secretly married to two women feels the pressure of his deceit.'),
(69,	1,	NULL,	'The Contender',	'the-contender',	'https://www.youtube.com/watch?v=SlxPipjaat8&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BM2VjMjI2MWYtMGRlNy00OGYxLWIxZmYtYWM2NmM2YTk1YjU2XkEyXkFqcGdeQXVyMDMxMjQwMw@@._V1_SX300.jpg',	1944,	'Sam Newfield',	'Widower Gary Farrell can\'t afford, on his $45-weekly salary as a truck driver, to send his young son, Mickey, to a high-priced military school and decides to enter heavyweight-boxing tournament in an effort to win the $500 prize mone'),
(70,	1,	NULL,	'The Divorce of Lady X',	'the-divorce-of-lady-x',	'https://www.youtube.com/watch?v=DUbMYeX47bc&ab_channel=Larrymovies',	'https://m.media-amazon.com/images/M/MV5BOTU3NWY0YjAtMzRkNC00MDUwLTlmNjYtZGU1YWUzMWM0MWE5XkEyXkFqcGdeQXVyNjc0MzMzNjA@._V1_SX300.jpg',	1938,	'Tim Whelan',	'Divorce lawyer Everard Logan thinks the woman who spent the night in his hotel room is the erring wife of his new client.'),
(72,	1,	NULL,	'The Jackie Robinson Story',	'the-jackie-robinson-story',	'https://www.youtube.com/watch?v=4UyeibL5yEc&ab_channel=reelblack',	'https://m.media-amazon.com/images/M/MV5BMTkxNGFhZTAtOTYxMC00MjAxLTk0YjYtMjYyMDk4NzgxMTI4XkEyXkFqcGdeQXVyNzE2NDk3NTY@._V1_SX300.jpg',	1950,	'Alfred E. Green',	'Biography of Jackie Robinson, the first black major league baseball player in the 20th century. Traces his career in the negro leagues and the major leagues. Restored in original Black and White.'),
(73,	1,	NULL,	'The Last Time I Saw Paris',	'the-last-time-i-saw-paris',	'https://www.youtube.com/watch?v=xYZW7eOZeuw&ab_channel=TimelessClassicFilms',	'https://m.media-amazon.com/images/M/MV5BMmY1MDkzODMtMGZiYS00Y2RjLTgyMWUtOTFhMGU2ZjQ2ZWFkXkEyXkFqcGdeQXVyMTMxMTY0OTQ@._V1_SX300.jpg',	1954,	'Richard Brooks',	'An American journalist returns to Paris - a city that gave him true love and deep grief.'),
(74,	1,	NULL,	'The Painted Desert',	'the-painted-desert',	'https://www.youtube.com/watch?v=vcqx9HktyRc&ab_channel=PizzaFlix',	'https://m.media-amazon.com/images/M/MV5BMDVmNmE1MWUtZjk4MC00MDA1LWFjM2UtMjhmY2ZhMWQyNjdjXkEyXkFqcGdeQXVyNjc0MzMzNjA@._V1_SX300.jpg',	1931,	'Howard Higgin, Tom Buckingham',	'Two men find an abandoned baby and fight over the ownership of the child resulting in lifelong rivalry.'),
(77,	1,	NULL,	'The Snows of Kilimanjaro',	'the-snows-of-kilimanjaro',	'https://www.youtube.com/watch?v=Yj_1qMF6rds&ab_channel=FEATUREFILM',	'https://m.media-amazon.com/images/M/MV5BNzkxOTZmMjUtYTFkYi00ZWM1LThlY2UtZjJiNDQ3NmEzNDUyXkEyXkFqcGdeQXVyNjc1NTYyMjg@._V1_SX300.jpg',	1952,	'Henry King, Roy Ward Baker',	'Writer Harry Street reflects on his life as he lies dying from an infection while on safari in the shadow of Mount Kilamanjaro.'),
(79,	1,	NULL,	'Das Testament des Dr. Mabuse',	'das-testament-des-dr-mabuse',	'https://www.youtube.com/watch?v=eiLXNS39aZs&ab_channel=gustavoanibalsicardi',	'https://m.media-amazon.com/images/M/MV5BMWU4MDA0OTktMDNlZS00NDE2LTk2NTYtNDQ3YjNmYjJjMjNiXkEyXkFqcGdeQXVyMzg1ODEwNQ@@._V1_SX300.jpg',	1933,	'Fritz Lang',	'A criminal mastermind uses hypnosis to rule the rackets after death.'),
(80,	1,	NULL,	'The Wild Ride',	'the-wild-ride',	'https://www.youtube.com/watch?v=9lAHvK4EoZE&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BMTQwMDUwOWYtMjdiZS00YTcxLTlkZTQtZWE3ZDM1MDVkZTc0XkEyXkFqcGdeQXVyNjUwNzk3NDc@._V1_SX300.jpg',	1960,	'Harvey Berman',	'A rebellious punk of the beat generation spends his days as an amateur dirt track driver in between partying and troublemaking. He eventually kidnaps his buddy\'s girlfriend, kills a few police officers, and finally sees his own life '),
(81,	1,	NULL,	'The Woman in Green',	'the-woman-in-green',	'https://www.youtube.com/watch?v=fIvV20oFTFY&ab_channel=TCC-TimelessClassicsNowinColor',	'https://m.media-amazon.com/images/M/MV5BMmNhYTVhNzQtY2I4Ni00YTEzLTg5OWEtYWIzYWNmNmUwNTc5XkEyXkFqcGdeQXVyMzg2MzE2OTE@._V1_SX300.jpg',	1945,	'Roy William Neill',	'Sherlock Holmes investigates when young women around London turn up murdered, each with a finger severed. Scotland Yard suspects a madman, but Holmes believes the killings to be part of a diabolical plot.'),
(82,	1,	NULL,	'Things to Come',	'things-to-come',	'https://www.youtube.com/watch?v=atwfWEKz00U&ab_channel=Lushscreamqueen-SchlockTreatment.',	'https://m.media-amazon.com/images/M/MV5BMDA2ZTZjMTctNmZiYi00MDA1LWEzZDQtN2JhYjRiNjMyMzEyXkEyXkFqcGdeQXVyNjQzNDI3NzY@._V1_SX300.jpg',	1936,	'William Cameron Menzies',	'The story of a century: a decades-long second World War leaves plague and anarchy, then a rational state rebuilds civilization and attempts space travel.'),
(83,	1,	NULL,	'Voyage to the Planet of Prehistoric Women',	'voyage-to-the-planet-of-prehistoric-women',	'https://www.youtube.com/watch?v=80Jahnv3t3w&ab_channel=HollywoodClassics',	'https://m.media-amazon.com/images/M/MV5BMTQ3MDk1MjM1MV5BMl5BanBnXkFtZTgwMjcwNDUzMzE@._V1_SX300.jpg',	1968,	'Peter Bogdanovich',	'Astronauts landing on Venus encounter dangerous creatures and almost meet some sexy Venusian women who like to sun-bathe in hip-hugging skin-tight pants and seashell brassieres.'),
(84,	2,	NULL,	'Zéro de conduite: Jeunes diables au collège',	'zéro-de-conduite-jeunes-diables-au-collège',	'https://www.youtube.com/watch?v=uXnSE4Gbo_o&ab_channel=LightPortal',	'https://m.media-amazon.com/images/M/MV5BNTAyY2YyZjUtOTBhYi00ZTE1LWJjZmQtODlmNzc2M2E5MGE1XkEyXkFqcGdeQXVyNjI5NTk0MzE@._V1_SX300.jpg',	1933,	'Jean Vigo',	'In a repressive boarding school with rigid rules of behavior, four boys decide to rebel against the direction on a celebration day.'),
(85,	1,	NULL,	'A Bucket of Blood',	'a-bucket-of-blood',	'https://www.youtube.com/watch?v=IQxFePQo6Ko&ab_channel=PizzaFlix',	'https://m.media-amazon.com/images/M/MV5BZWIxMWI3NTktMjkwYy00ZTc4LWFjMjktNDBkOTAzYjc1YjI4XkEyXkFqcGdeQXVyMTEwODg2MDY@._V1_SX300.jpg',	1959,	'Roger Corman',	'A dim-witted busboy finds acclaim as an artist for a plaster-covered dead cat that is mistaken as a skillful statuette. The desire for more praise soon leads to an increasingly deadly series of works.'),
(86,	1,	NULL,	'A Life at Stake',	'a-life-at-stake',	'https://www.youtube.com/watch?v=t4uDAaQB0ew&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BZWExMTg2NjItYjczMi00YjcwLTg1N2QtYmY5MWQ5OTNkNjI2XkEyXkFqcGdeQXVyMTQ3Njg3MQ@@._V1_SX300.jpg',	1955,	'Paul Guilfoyle',	'An out-of-work architect meets a married woman who has a business proposition for him. The architect begins to suspect the woman\'s interest in him is not just financial and may actually be deadly.'),
(87,	1,	NULL,	'Carnival of Souls',	'carnival-of-souls',	'https://www.youtube.com/watch?v=vNYg4YWkp0k&t=1030s&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BYjgxYjI1ODktNWYyNy00N2EyLWFhOWEtMmI1ZmU3ZmU5ZWFjXkEyXkFqcGdeQXVyNjc1NTYyMjg@._V1_SX300.jpg',	1962,	'Herk Harvey',	'After a traumatic accident, a woman becomes drawn to a mysterious abandoned carnival.'),
(88,	1,	NULL,	'Port of New York',	'port-of-new-york',	'https://www.youtube.com/watch?v=UIoxLlX4dmw&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BOGVlNDg1MGUtOTEwMi00OGRmLTlhNGYtMzgxNTBlODQ4MmJiXkEyXkFqcGdeQXVyMTQ3Njg3MQ@@._V1_SX300.jpg',	1949,	'Laslo Benedek',	'Two narcotics agents go after a gang of murderous drug dealers who use ships docking at the New York harbor to smuggle in their contraband.'),
(89,	1,	NULL,	'Guest in the House',	'guest-in-the-house',	'https://www.youtube.com/watch?v=4r5zk6MnFqA&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BMTgwODBiMjgtMDllMi00MjE1LTgzMTQtMDFhMGI2Njk4N2ZlXkEyXkFqcGdeQXVyMTMxMTY0OTQ@._V1_SX300.jpg',	1944,	'John Brahm, John Cromwell, André De Toth',	'A young manipulative woman moves in with her fiancé\'s family and turns a happy household against itself.'),
(90,	1,	NULL,	'Inner Sanctum',	'inner-sanctum',	'https://www.youtube.com/watch?v=6bUPoAqF86E&ab_channel=PizzaFlix',	'https://m.media-amazon.com/images/M/MV5BYTRlMjYzZjQtMDYxYS00NTcwLWI4N2YtM2ZjZWQwMDA2MmViXkEyXkFqcGdeQXVyMjI4MjA5MzA@._V1_SX300.jpg',	1948,	'Lew Landers',	'A man fleeing the police after having committed a murder hides out in a boarding house in a small town.'),
(91,	1,	NULL,	'Invisible Ghost',	'invisible-ghost',	'https://www.youtube.com/watch?v=b8zuKPcdVWE&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BMjIyNTIzODEzMV5BMl5BanBnXkFtZTgwNjg1ODgwMzE@._V1_SX300.jpg',	1941,	'Joseph H. Lewis',	'The town\'s leading citizen becomes a homicidal maniac after his wife deserts him.'),
(92,	1,	NULL,	'Jamaica Inn',	'jamaica-inn',	'https://www.youtube.com/watch?v=zxVkaXvU3Js&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BY2U4OGVhOGUtMWQzYS00OGMxLThiZGQtODUzNDkxYTI4NGZhXkEyXkFqcGdeQXVyMTMxMTY0OTQ@._V1_SX300.jpg',	1939,	'Alfred Hitchcock',	'In Cornwall, 1819, a young woman discovers she\'s living near a gang of criminals who arrange shipwrecks for profit.'),
(93,	2,	NULL,	'Judex',	'judex',	'https://www.youtube.com/watch?v=viitbTCMcck&ab_channel=FilmClassiqueComplet',	'https://m.media-amazon.com/images/M/MV5BYWEzNDEwYTktYjZhZS00ZGQwLWE3NTItYTg0ZjBhZGFlNTc3XkEyXkFqcGdeQXVyMzg1ODEwNQ@@._V1_SX300.jpg',	1963,	'Georges Franju',	'Favraux, an unscrupulous banker, receives a threatening note, signed by \"Judex\", demanding that he pay back the people he has swindled. He refuses, and apparently dies after a midnight toast at his masked ball. However, he is only dr'),
(94,	1,	NULL,	'Kansas City Confidential',	'kansas-city-confidential',	'https://www.youtube.com/watch?v=WGyEelzJaMs&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BZjFkNmQ4ODUtZTI4MC00MWViLTkyODktMjE1ZTcxNmVmYmQ3XkEyXkFqcGdeQXVyMjUxODE0MDY@._V1_SX300.jpg',	1952,	'Phil Karlson',	'An ex-con trying to go straight is framed for a million dollar armored car robbery and must go to Mexico in order to unmask the real culprits.'),
(95,	1,	NULL,	'Lady in the Death House',	'lady-in-the-death-house',	'https://www.youtube.com/watch?v=ZQyGoCLNWVY&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BMjM4MDUwODYwM15BMl5BanBnXkFtZTgwMzk0ODgwMzE@._V1_SX300.jpg',	1944,	'Steve Sekely',	'A young woman is on death row for the murder of a man who was blackmailing her family, although she claims she was framed. Her fiance, a doctor who is conducting experiments on reviving the dead, also happens to be the state\'s execut'),
(96,	1,	NULL,	'Please Murder Me!',	'please-murder-me-',	'https://www.youtube.com/watch?v=JCGs5qhGMqw&ab_channel=BiscootHollywoodMovies',	'https://m.media-amazon.com/images/M/MV5BOGMyYjM3M2UtOGZiMC00NTU3LWE0Y2EtZjUzNDk5NmMyNDIzXkEyXkFqcGdeQXVyMTE2NzA0Ng@@._V1_SX300.jpg',	1956,	'Peter Godfrey',	'A lawyer suffers a guilt complex after getting a murder acquittal for his client, and then finding out she did commit the crime.'),
(97,	1,	NULL,	'Silent Night, Bloody Night',	'silent-night-bloody-night',	'https://www.youtube.com/watch?v=nDNgb1O5L_U&ab_channel=CultCinemaClassics',	'https://m.media-amazon.com/images/M/MV5BYTIyYzU4ZmUtZGI3OS00ODkzLTgwZWUtOThmNzZjNTg5Nzg2XkEyXkFqcGdeQXVyMTQxNzMzNDI@._V1_SX300.jpg',	1972,	'Theodore Gershuny',	'A man inherits a mansion which once was a mental home. He visits the place and begins to investigate some crimes that happened in old times, scaring the people living in the region.'),
(101,	1,	NULL,	'Angel and the Badman',	'angel-and-the-badman',	'https://www.youtube.com/watch?v=GkIYolapTeg&ab_channel=TCC-TimelessClassicsNowinColor',	'https://m.media-amazon.com/images/M/MV5BYWI1NzdhYTMtZGE2ZS00ZjJjLThmZWQtNjY4ODcxNWM2YjQ3XkEyXkFqcGdeQXVyMTI1NDQ4NQ@@._V1_SX300.jpg',	1947,	'James Edward Grant',	'Quirt Evans, an all round bad guy, is nursed back to health and sought after by Penelope Worth, a Quaker girl. He eventually finds himself having to choose between his world and the world Penelope lives in.'),
(102,	1,	NULL,	'Billy the Kid Wanted',	'billy-the-kid-wanted',	'https://www.youtube.com/watch?v=T7JplstJNsY&ab_channel=Inter-Path%C3%A9',	'https://m.media-amazon.com/images/M/MV5BZWVhZmFlZDMtMDU4Yy00NGJhLTk0N2MtYTRlMTI1NzQ5MTJhXkEyXkFqcGdeQXVyNDk0MDM0Mzg@._V1_SX300.jpg',	1941,	'Sam Newfield',	'Billy the Kid (Buster Crabbe) and his pal Jeff (Dave O\'Brien) help their friend Fuzzy Jones (Al St. John) escape from jail, and the trio heads for Paradise Valley, where they find the Paradise Land Development Company, ran by Matt Br');

DROP TABLE IF EXISTS `movie_category`;
CREATE TABLE `movie_category` (
  `movie_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`movie_id`,`category_id`),
  KEY `IDX_DABA824C8F93B6FC` (`movie_id`),
  KEY `IDX_DABA824C12469DE2` (`category_id`),
  CONSTRAINT `FK_DABA824C12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_DABA824C8F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `movie_category` (`movie_id`, `category_id`) VALUES
(1,	2),
(2,	3),
(3,	4),
(3,	7),
(4,	8),
(5,	2),
(6,	7),
(7,	7),
(8,	7),
(15,	9),
(16,	9),
(17,	5),
(17,	7),
(17,	9),
(21,	4),
(21,	8),
(22,	7),
(22,	9),
(23,	9),
(27,	8),
(28,	2),
(28,	7),
(28,	8),
(29,	2),
(30,	8),
(31,	9),
(32,	9),
(34,	9),
(35,	9),
(36,	4),
(36,	9),
(37,	2),
(38,	2),
(40,	2),
(41,	2),
(41,	9),
(42,	2),
(42,	3),
(43,	2),
(44,	1),
(45,	1),
(46,	5),
(48,	1),
(49,	4),
(49,	9),
(50,	5),
(50,	7),
(52,	1),
(53,	9),
(54,	7),
(55,	1),
(55,	5),
(56,	2),
(58,	9),
(59,	9),
(60,	1),
(61,	4),
(62,	5),
(62,	7),
(63,	5),
(63,	7),
(64,	5),
(66,	4),
(67,	4),
(68,	4),
(68,	7),
(69,	1),
(69,	4),
(69,	7),
(70,	5),
(70,	9),
(72,	1),
(73,	5),
(73,	7),
(74,	6),
(77,	1),
(77,	5),
(79,	4),
(80,	7),
(81,	4),
(81,	8),
(82,	3),
(83,	1),
(83,	3),
(84,	9),
(85,	2),
(85,	9),
(86,	4),
(87,	2),
(88,	4),
(88,	7),
(89,	4),
(89,	7),
(90,	4),
(91,	2),
(91,	7),
(92,	4),
(92,	8),
(93,	4),
(93,	8),
(94,	4),
(94,	7),
(95,	7),
(96,	4),
(97,	2),
(101,	6),
(102,	6);

DROP TABLE IF EXISTS `movie_thematic`;
CREATE TABLE `movie_thematic` (
  `movie_id` int(11) NOT NULL,
  `thematic_id` int(11) NOT NULL,
  PRIMARY KEY (`movie_id`,`thematic_id`),
  KEY `IDX_A0EA44FF8F93B6FC` (`movie_id`),
  KEY `IDX_A0EA44FF2395FCED` (`thematic_id`),
  CONSTRAINT `FK_A0EA44FF2395FCED` FOREIGN KEY (`thematic_id`) REFERENCES `thematic` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A0EA44FF8F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `movie_thematic` (`movie_id`, `thematic_id`) VALUES
(2,	8),
(15,	1),
(16,	1),
(21,	2),
(27,	5),
(29,	6),
(30,	5),
(33,	7),
(34,	7),
(38,	8),
(39,	8),
(42,	8),
(43,	8),
(44,	9),
(45,	10),
(50,	10),
(55,	10),
(79,	2),
(92,	5);

DROP TABLE IF EXISTS `thematic`;
CREATE TABLE `thematic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `thematic` (`id`, `name`, `slug`) VALUES
(1,	'Charlie Chaplin',	'charlie-chaplin'),
(2,	'Fritz Lang',	'fritz-lang'),
(3,	'Howard Hawks',	'howard-hawks'),
(4,	'Georges Méliès',	'georges-melies'),
(5,	'Alfred Hitchcock',	'alfred-hitchcock'),
(6,	'Zombies',	'zombies'),
(7,	'Buster Keaton',	'buster-keaton'),
(8,	'Nanar',	'nanar'),
(9,	'Pirates',	'pirates'),
(10,	'War',	'war'),
(11,	'Kung-Fu',	'kung-fu');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(1,	'admin@admin.fr',	'[\"ROLE_ADMIN\"]',	'$2y$13$SlX5MaJKjFP9DR6GufK/D.xr.ADEBUsOktaJb1hFgpCvGyoxDNH6q');

DROP TABLE IF EXISTS `user_movie`;
CREATE TABLE `user_movie` (
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`movie_id`),
  KEY `IDX_FF9C0937A76ED395` (`user_id`),
  KEY `IDX_FF9C09378F93B6FC` (`movie_id`),
  CONSTRAINT `FK_FF9C09378F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_FF9C0937A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2021-10-26 09:19:51
