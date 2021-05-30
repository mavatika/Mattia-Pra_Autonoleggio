-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 20, 2021 alle 12:08
-- Versione del server: 10.4.17-MariaDB
-- Versione PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `noleggio_auto`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `cars`
--

CREATE TABLE `cars` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `brand` varchar(40) NOT NULL,
  `model` varchar(40) NOT NULL,
  `image` tinytext DEFAULT NULL,
  `price` smallint(6) NOT NULL DEFAULT 0,
  `engine` smallint(6) NOT NULL,
  `seats` tinyint(4) NOT NULL DEFAULT 1,
  `transmission` varchar(40) NOT NULL,
  `short_description` text NOT NULL,
  `category` varchar(20) NOT NULL,
  `speed` smallint(6) NOT NULL,
  `gps` tinyint(1) NOT NULL DEFAULT 0,
  `tank` tinyint(4) NOT NULL,
  `description` text NOT NULL,
  `img1` tinytext DEFAULT NULL,
  `img2` tinytext DEFAULT NULL,
  `img3` tinytext DEFAULT NULL,
  `age` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `image`, `price`, `engine`, `seats`, `transmission`, `short_description`, `category`, `speed`, `gps`, `tank`, `description`, `img1`, `img2`, `img3`, `age`) VALUES
(00000000001, 'Tesla', 'Model S', '/img/pages/cars/cars/3770c4a4ce1b49f7f7598b40794ba73e.png', 30, 562, 5, 'Electric vehicle', 'The Tesla Model S is an all-electric five-door liftback sedan produced by Tesla, Inc., and was introduced on June 22, 2012.', 'Sport vehicle', 322, 1, 0, 'The Model S is notable for being designed from the ground up with an electric powertrain in mind, unlike other electric vehicles where the manufacturer has simply swapped out or supplanted an internal combustion engine with an electric motor. As a result, the Model S is able to offer features such as a front trunk (a \"frunk\") in addition to a large rear trunk space and an enlarged front crumple zone compared to the typical combustion engine powered vehicle.\r\n\r\nThe Model S exists in several versions, differing in energy capacity (battery size), power (motor size), and equipment. It is classified as a full-size luxury car in the US, or as a \"Large Car\" (greater than or equal to 120 cu ft or 3.4 m3) or \"Luxury Sedan\" by the EPA. The Euro Car Segment classification is S-segment (sports car) or \"Oberklasse\" (F-segment) in Germany.', 'https://cdn.dmove.it/images/12179/Smain.jpg', 'https://www.gelestatic.it/thimg/5imnQmY0RSi9A3gew6CPHIvQ-Fs=/fit-in/1280x1280/https%3A//www.lastampa.it/image/contentid/policy%3A1.39826605%3A1611751655/401933c21a6afcf7e5c27ac2e97681c2.jpg%3Ff%3Dlibero%26%24p%24f%3D92547fc', 'https://www.money.it/IMG/jpg/nuova_tesla_model_s_2020.jpg', 2),
(00000000002, 'Range Rover', 'Velar', '/img/pages/cars/cars/bed87c9b967b6aabdb32285f8002e6d5.png', 28, 550, 5, 'Automatic transmission - fuel', 'The Range Rover Velar is a compact luxury crossover SUV produced by British automotive company Jaguar Land Rover under their Land Rover marque.', 'SUV', 250, 1, 82, 'The Range Rover Velar ushers in a new design language for Land Rover that is influenced by Land Rover\'s previous design language that began with the Evoque and most recently was used in the Range Rover Sport. The new design language features smoother lines on the body, and emphasises sportiness and on-road ability, but more important is the new interior design language that begins with the Velar, which will later spread to other Range Rover models. The interior of the Velar is influenced by that of the I-Pace of 2018 and features 3 touchscreens, which control most of the interior features of the Velar. The cockpit of the Velar is more driver-focused and the seating position is lower than any other Land Rover before, as sportiness and on-road performance are top priorities.', 'https://images.carforyou.ch/2020/02/07/09/04/54/1-land-rover-velar-d180-460271-v5c7OI6uGMAJ.png', 'https://www.cheautocompro.it/sites/default/files/2020-07/Land%20Rover%20Velar%204.jpg', 'https://wheels.iconmagazine.it/content/uploads/2020/05/Land-Rover-Range-Rover-Velar-960x545.jpg', 2),
(00000000003, 'Tesla', 'Roadster', '/img/pages/cars/cars/e66a1b23d45ec795b348b81a33bf2b7d.png', 45, 1242, 2, 'Electric vehicle', 'The Tesla Roadster is a battery electric vehicle (BEV) sports car, based on the Lotus Elise chassis, that was produced by the electric car firm Tesla Motors (now Tesla, Inc.) in California from 2008 to 2012.', 'Hypercar', 400, 1, 0, 'The second-generation Tesla Roadster is a 2+2 coupé with a removable glass roof. It was designed by Franz von Holzhausen, Tesla\'s chief designer who has also been responsible for most earlier vehicles made by Tesla Motors. The Roadster has a 2+2 seating arrangements, with smaller rear seats for two passengers.\r\nThe Roadster has three electric motors, one in front and two at the rear, allowing for all-wheel drive, and torque vectoring during cornering. Tesla said that the vehicle had a 200 kWh (720 MJ) battery, twice the capacity of the largest battery in an existing Tesla car (in the Tesla Model S or Model X Performance or Long Range Plus). Tesla has said that the Roadster will have a 1,000 km (620 miles) range on a single charge at highway speeds. Tesla stated that the torque at wheels was 10,000 N⋅m (7,400 lb⋅ft). The rear wheels are larger than the front wheels.', 'https://images.everyeye.it/img-notizie/tesla-roadster-incredibile-hypercar-elettrica-arrivera-cybertruck-v3-444638.jpg', 'https://images.everyeye.it/img-notizie/la-tesla-roadster-hypercar-tutto-personalizzazione-v3-483569.jpg', 'https://www.sgommo.it/wp-content/uploads/2017/11/Tesla-Roadster-2020__07.jpg', 1),
(00000000004, 'Lamborghini', 'Urus', '/img/pages/cars/cars/f08b10021a3e7ecfb3de1345e51044b0.png', 50, 650, 5, 'Fuel - automatic transmission', 'The Lamborghini Urus is an SUV manufactured by Italian automobile manufacturer Lamborghini. The name comes from the Urus, the ancestor of modern domestic cattle, also known as the aurochs.', 'SUV', 305, 1, 85, 'The Lamborghini Urus concept was unveiled at the 2012 Beijing Auto Show on 23 April 2012. Later, the SUV was also shown at Pebble Beach in 2012. Powered by a 5.2 L V10 engine shared with the Gallardo, the engine generated a theoretical maximum power output of 600 PS (592 hp; 441 kW) and was accompanied with an all-wheel-drive system. The Urus was reported to have the lowest carbon emissions as compared to its stablemates (i.e. the Porsche Cayenne, Bentley Bentayga and the Audi Q7). The Urus was conceived as a perfect daily driver unlike the other offerings from the brand. The sharp-lined exterior design of the SUV takes heavy influence from the company\'s V12 flagship, the Aventador. The production version of the SUV was introduced in 2017 with major changes done to the exterior and featuring a different powertrain than that of the concept.', 'https://www.exclusiverent.com/media/djcatalog2/images/item/0/lamborghini-urus_l.jpg', 'https://images.everyeye.it/img-notizie/il-look-lamborghini-urus-820-cavalli-dir-estremo-v3-426374.jpg', 'https://i2.res.24o.it/images2010/Editrice/ILSOLE24ORE/ILSOLE24ORE/Online/Immagini/ArticleGallery/Motori/2019/03/Ritagli/09-lamborghini-urus-kh5G--835x437@IlSole24Ore-Web.jpg', 1),
(00000000005, 'Aston Martin', 'DB11', '/img/pages/cars/cars/857c45c77341e580cc6ad64bd380d385.png', 47, 639, 2, 'Fuel - automatic transmission', 'The Aston Martin DB11 is a grand tourer produced by British luxury car manufacturer Aston Martin since 2016.', 'Grand tourer', 334, 1, 78, 'New design features include new roof strakes that separate the body from the roof, available in black or body colour, and the \"Aeroblade\" intakes in the front strakes.\r\nThe bonnet is a \'clam-shell\' design made from a single piece of aluminium. The DB11 does not use the older Aston Martin VH platform but makes use of an all-new riveted and adhesive-bonded aluminium platform that shifts the emphasis from extrusions to stampings to create more cockpit space which would also underpin future Aston Martin models; including the Vantage.', 'https://immagini.alvolante.it/sites/default/files/styles/editor_1_colonna/public/news_galleria/2018/05/aston-martin-db11-amr-2018-05_26.jpg?itok=p8sT4zZ5', 'https://media.torque.com.sg/public/2019/04/db11-amr-interior.jpg', 'https://www.cheautocompro.it/sites/default/files/2020-12/db11-amr-mariana-blue-21..jpg', 2),
(00000000007, 'Tesla', 'Model X', '/img/pages/cars/cars/3a4387016d64fefeae6168efaa50c186.png', 37, 1023, 5, 'Electric vehicle', 'The Tesla Model X is a mid-size all-electric luxury crossover made by Tesla, Inc. The vehicle is notable in that it uses falcon-wing doors for passenger access.', 'Crossover SUV', 263, 1, 0, 'A series production vehicle was unveiled on September 29, 2015. It has a panoramic windshield. According to Tesla CEO Elon Musk, it is the safest SUV in terms of frontal and side impact crash, being more than twice as safe as the next closest SUV in rollover tests as well. The Model X does come with Autopilot as standard, and has an optional full self-driving system. The Model X has standard a collision avoidance system that uses radar-based autonomous emergency braking (AEB) and side-directed ultrasound detection that steers the car away from threats. Tesla uses a wide-band radar system to help prevent the falcon wing doors from hitting nearby objects when opening or closing.\r\n\r\nThe Model X has double-hinged falcon wing doors which open upwards, allowing the leading edge of the door to remain tucked close to the body, unlike traditional gull-wing doors. Tesla claims the falcon-wing (modified gull-wing) doors ease access to the vehicle by having the door raise up vertically, rather than swinging out hinged at the front, which tremendously reduces accessibility. The Model X offers room for seven adults and their luggage in three rows of seating and front and rear trunks.', 'http://motori.quotidiano.net/wp-content/uploads/2021/01/Restyling-Tesla-Model-S-e-Model-X-la-Plaid-accelera-da-0-a-100-in-21-secondi-8.jpeg', 'https://www.autoelettrica101.it/foto/tesla_model_x_performance_ludicrous_1200px.jpg', 'https://besthqwallpapers.com/Uploads/2-11-2017/26762/thumb2-tesla-model-x-2017-4k-electric-crossover-blue-model-x.jpg', 3),
(00000000008, 'BMW', 'i8', '/img/pages/cars/cars/e927f5ade820c669f528c9a92f2e2682.png', 27, 374, 2, 'Electric vehicle', 'The BMW i8 is a plug-in hybrid sports car developed by BMW. The i8 is part of BMW\'s electrified fleet and is marketed under the BMW i sub-brand.', 'Sport car', 250, 1, 0, 'The production BMW i8 was designed by Benoit Jacob. The production version was unveiled at the 2013 International Motor Show Germany, followed by 2013 Les Voiles de Saint-Tropez. Its design is heavily influenced by the BMW M1 Homage concept car, which in turn pays homage to BMW\'s last production mid-engined sports car prior to the i8: the BMW M1.\r\n\r\nThe BMW i8 features butterfly doors, head-up display, rear-view cameras and partially false engine noise. Series production of customer vehicles began in April 2014. The electric two-speed drivetrain is developed and produced by GKN. It was the first production car with laser headlights, reaching further than LED lights.\r\n\r\nThe i8 has a vehicle weight of 1,485 kg (3,274 lb) (DIN kerb weight) and a low drag coefficient (Cd) of 0.26. In all-electric mode the BMW i8 has a top speed of 120 km/h (75 mph). In Sport mode the i8 delivers a mid-range acceleration from 80 to 120 km/h (50 to 75 mph) in 2.6 seconds. The electronically controlled top speed is 250 km/h (155 mph).\r\n\r\nThe 20,000th i8 was produced in December 2019, one of the limited Ultimate Sophisto Edition models. The production cycle of the i8 ended in June 2020. In total, there were 20,465 units produced: 16,581 coupés and 3,884 roadsters.', 'https://wheels.iconmagazine.it/content/uploads/2019/04/BMW-i8-Roadster.jpg', 'https://www.bmw.it/content/dam/bmw/common/all-models/i-series/i8-coupe/2017/at-a-glance/bmw-i8-coupe-home-gallery-lines-01-ivory-white.jpg', 'https://cdn.prod.www.manager-magazin.de/images/a487db31-0001-0004-0000-000000531679_w1200_r1.33_fpx35.24_fpy49.87.jpg', 2),
(00000000009, 'Bentley', 'Continental GT', '/img/pages/cars/cars/cd07882d473e85cc16c38cdb8eadf941.png', 27, 550, 4, 'Fuel - automatic transmission', 'The Bentley Continental GT is a grand tourer manufactured and marketed by British automaker Bentley Motors since 2003.', 'Grand tourer', 335, 0, 90, 'In 1994, Rolls-Royce Motors who at that time owned the Bentley brand, previewed a convertible concept car at the Geneva Motor Show – the Concept Java. The car was designed to be a highly desirable Bentley, but smaller, more affordable, yet still exclusive in order to maintain the integrity of the brand. It was to appeal to a new range of potential buyers and generate increase sales volume for Rolls-Royce. At the time the current Bentley Continental R was an ultra-exclusive £180,000 in the UK, within reach of a very select market, selling only 2-300 units a year. The Concept Java never went into production in the form seen in 1994, although 13 cars were made for the Sultan of Brunei. However, the Bentley Continental GT realised the concept of the Java as a more affordable Bentley, manufactured in much larger volumes. Whilst external styling is different, the dashboard design was clearly influenced by the Java.\r\n\r\nThe Continental GT was marketed to new customers with an average age of just under 50 years old, with 75% upper luxury coupé buyer not from existing customer base.\r\n\r\nBreitling SA produced a limited edition (1000 units per colour) Breitling for Bentley Supersports chronograph wrist watches (based on Breitling Calibre 26B) inspired by the Bentley Continental Supersports car.\r\n\r\nBreitling SA produced a series of 1000-unit Bentley Supersports Light Body wrist watches (based on the Breitling Calibre 27B) to commemorate the Bentley Continental Supersports Convertible\'s ice speed record. The watch was unveiled at Baselworld in 2011.', 'https://statics.quattroruote.it/news/nuovi-modelli/2020/09/16/bentley_continental_gt_mulliner_caratteristiche_motore_interni_della_coupe/jcr:content/image.img2.social.jpg/1600247876342.jpg', 'https://www.autoscout24.it/assets/auto/images/model/bentley/bentley-continental-gt/bentley-continental-gt-l-04.jpg', 'https://www.lifersblog.com/novita-auto/wp-content/uploads/2020/09/bentley-continental-gt-mulliner_2.jpg', 6),
(00000000010, 'Rolls-Royce', 'Cullinan', '/img/pages/cars/cars/8a742f2639ea58221babf52fb66f9f1d.png', 45, 600, 7, 'Fuel - automatic transmission', 'The Rolls-Royce Cullinan is a full-sized luxury sport utility vehicle (SUV) produced by Rolls-Royce Motor Cars. The Cullinan is the first SUV to be launched by the Rolls-Royce marque, and is also the brand\'s first all-wheel drive vehicle. It is named after the Cullinan Diamond, the largest gem-quality rough diamond ever discovered.', 'SUV', 250, 1, 100, 'It was long rumoured that the car company would venture into making an SUV. Auto Express exclusively reported that a design was in the works and correctly that the name would be Cullinan. This was due to its competitors such as Bentley and Lamborghini venturing into the SUV business with the Bentayga and the Urus respectively. On 17 September 2015, it was confirmed by Rolls-Royce design chief Giles Taylor that the company was tinkering on it. At the 2015 Frankfurt Auto Show, Rolls Royce\'s CEO Torsten Müller-Ötvös said that the SUV will be revealed in 2018 and be on the market in 2019.\r\n\r\nA model was spotted testing on 23 December 2015 by Autocar.\r\n\r\nThe name \"Cullinan\" was confirmed by Rolls Royce on 13 February 2018. It is named after the Cullinan diamond, the largest diamond ever found at 3100 carats.\r\nThe Cullinan uses an aluminium spaceframe chassis; this is a version of Rolls-Royce\'s modular \"Architecture of Luxury\" platform. This platform made its debut in the Phantom VIII.\r\n', 'https://cdn.motor1.com/images/mgl/yL49b/s1/rolls-royce-cullinan.jpg', 'https://www.rolls-roycemotorcars.com/content/dam/rrmc/marketUK/rollsroycemotorcars_com/3-1-1-in-detail/components/rolls-royce-cullinan-in-detail-immersive-seating-verticle-scrolling-image-01.jpg/jcr:content/renditions/cq5dam.web.1920.webp', 'https://www.motorionline.com/wp-content/uploads/2018/05/Rolls-Royce-Cullinan-11-e1525955096114.jpg', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `cities`
--

CREATE TABLE `cities` (
  `code` char(2) NOT NULL,
  `name` varchar(40) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `cities`
--

INSERT INTO `cities` (`code`, `name`, `address`) VALUES
('CS', 'Cosenza', 'Strada statale 19 delle Calabrie, 2'),
('LA', 'Los Angeles', '1419 Westwood Blvd'),
('LV', 'Las Vegas', '129 E Fremont St'),
('MI', 'Milan', 'Via Amerigo Vespucci, 5'),
('MU', 'Munich', 'Franz-Joseph-Straße 41'),
('NY', 'New York', '865 Madison Ave'),
('RO', 'Rome', 'Via del Colosseo, 4'),
('TO', 'Turin', 'Via Roma, 118'),
('TV', 'Treviso', 'Calmaggiore, 44'),
('VE', 'Venice', 'Ramo de la Tana');

-- --------------------------------------------------------

--
-- Struttura della tabella `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `user_id` varchar(60) NOT NULL,
  `object` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `answered` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `object`, `message`, `answered`) VALUES
(0000000009, 'admin', 'Messaggio di prova', 'Questo è un messaggio di prova,\r\ncontiene degli \"a capo\".\r\n\r\nE anche di più spazi.\r\nMattia Prà\r\n', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `rents`
--

CREATE TABLE `rents` (
  `id` int(11) NOT NULL,
  `car_id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `user_id` varchar(60) NOT NULL,
  `city` char(2) NOT NULL,
  `startDate` date NOT NULL DEFAULT current_timestamp(),
  `duration` tinyint(4) UNSIGNED NOT NULL DEFAULT 1,
  `state` varchar(30) NOT NULL DEFAULT 'idle'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `rents`
--

INSERT INTO `rents` (`id`, `car_id`, `user_id`, `city`, `startDate`, `duration`, `state`) VALUES
(66, 00000000004, 'admin', 'TV', '2021-05-29', 8, 'canceled'),
(65, 00000000005, 'admin', 'MU', '2021-05-30', 14, 'idle'),
(57, 00000000008, 'admin', 'MU', '2021-05-27', 4, 'confirmed');

-- --------------------------------------------------------

--
-- Struttura della tabella `stock`
--

CREATE TABLE `stock` (
  `car_id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `quantity` smallint(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `stock`
--

INSERT INTO `stock` (`car_id`, `quantity`) VALUES
(00000000001, 1),
(00000000002, 13),
(00000000003, 7),
(00000000004, 2),
(00000000005, 6),
(00000000007, 4),
(00000000008, 0),
(00000000009, 0),
(00000000010, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `username` varchar(60) NOT NULL,
  `password` varchar(200) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `scope` varchar(20) NOT NULL DEFAULT 'user',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `surname` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `age` tinyint(3) UNSIGNED NOT NULL,
  `city` char(2) DEFAULT NULL,
  `fav_car` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`username`, `password`, `email`, `scope`, `name`, `surname`, `age`, `city`, `fav_car`) VALUES
('admin', '$2y$10$Y790ALV8VCgJa6uetHqzlOtWztrVPh9PhcfsJsM9Lcqggyivewa8q', 'admin@admin.it', 'admin', 'Admin', 'DotDot', 50, 'LV', 'Tesla');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`code`);

--
-- Indici per le tabelle `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`object`);

--
-- Indici per le tabelle `rents`
--
ALTER TABLE `rents`
  ADD PRIMARY KEY (`car_id`,`user_id`,`city`,`startDate`,`duration`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `rent_user` (`user_id`),
  ADD KEY `rent_city` (`city`);

--
-- Indici per le tabelle `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`car_id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `rents`
--
ALTER TABLE `rents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `user_msg` FOREIGN KEY (`user_id`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `rents`
--
ALTER TABLE `rents`
  ADD CONSTRAINT `rent_car` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rent_city` FOREIGN KEY (`city`) REFERENCES `cities` (`code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rent_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `car_stock` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
