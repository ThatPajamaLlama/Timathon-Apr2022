-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2022 at 10:04 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timathon`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `name`, `img`) VALUES
(1, 'Book an Escape Room', 'https://img.redbull.com/images/q_auto,f_auto/redbullcom/2017/09/29/7816b8f8-dcba-4509-ac09-bb5d5c8d56d8/escape'),
(2, 'Switchup your lunch', 'https://weelicious.com/imager/weelicious_com/wp-content/uploads/2015/09/School-Lunch-Inspiration_1b74faffbe944b0675f0e20473d3ad34.jpg'),
(3, 'Use a different method of transportation', 'https://www.rei.com/dam/content_team_071018_0071_htc_bike_hero_lg.jpg'),
(4, 'Listen to music you haven\'t heard for a while', 'https://www.liveabout.com/thmb/pwO4o_iDrZRTmmhs7eOfD25Qoqw=/1500x1125/smart/filters:no_upscale()/pop-music-57bce3863df78c87634ea806.jpg'),
(5, 'Watch a classic movie', 'https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/best-movies-1614634680.jpg'),
(6, 'Learn something new', 'https://www.clearlypayments.com/wp-content/uploads/2020/07/lean.jpg'),
(7, 'Bake something', 'https://funcakes.com/content/uploads/2019/11/Muffins-1000x750.png'),
(8, 'Go for a walk', 'https://i0.wp.com/post.healthline.com/wp-content/uploads/2020/08/women-exercising-at-the-beach-1296x728-header.jpg?w=1155&h=1528'),
(9, 'Make bread from scratch', 'https://images-gmi-pmc.edge-generalmills.com/da2abda1-fae1-4782-b65f-93868ca5bd40.jpg'),
(10, 'Draw something', 'https://archziner.com/wp-content/uploads/2020/01/baby-giraffe-wating-leaves-on-white-background-simple-easy-drawings-black-and-white-pencil-sketch.jpg'),
(11, 'Compliment a stranger', 'https://blog.vantagecircle.com/content/images/2020/07/compliments-for-coworkers.png'),
(12, 'Make a scrapbook of your photographs', 'https://cdn.shopify.com/s/files/1/1933/0091/articles/scrap_booking_f3cac5bd-4e2b-4d7f-a61d-b827ff236d0b_1024x1024.jpg?v=1563392776'),
(13, 'Watch a new sport', 'https://asweatlife.com/wp-content/uploads/2021/12/spikeball-and-women.png'),
(14, 'Learn and play a new card game', 'https://upload.wikimedia.org/wikipedia/commons/5/58/AcetoFive.JPG'),
(15, 'Go swimming', 'https://post.healthline.com/wp-content/uploads/2020/08/1763-female_swim_exercise_732x549-thumb-732x549.jpg'),
(16, 'Find chance to dance', 'https://images.pond5.com/carefree-guy-dancing-robot-dance-footage-122388784_iconl.jpeg'),
(17, 'Go to a car boot sale', 'https://i2-prod.grimsbytelegraph.co.uk/news/grimsby-news/article1485134.ece/ALTERNATES/s615b/car-boot-oak.jpg'),
(18, 'Go to a (free) museum', 'https://www.moneysavingexpert.com/content/dam/mse/editorial-image-library/guide-images/hero-images/hero-deals-free-museums.jpg'),
(19, 'See some animals', 'https://dmsimgs.visitblackpool.newmindmedia.com/wsimgs/_DSC8465_202728776.jpg'),
(20, 'Make some origami', 'https://i.ytimg.com/vi/VMnaXwivfDs/maxresdefault.jpg'),
(21, 'Play hopscotch', 'https://image1.masterfile.com/getImage/NjE0LTA3MjM1MDIwZW4uMDAwMDAwMDA=ANjY$X/614-07235020en_Masterfile.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bucket_list_item`
--

CREATE TABLE `bucket_list_item` (
  `id` int(11) NOT NULL,
  `item` varchar(50) NOT NULL,
  `completed` tinyint(1) NOT NULL,
  `user_id` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bucket_list_item`
--

INSERT INTO `bucket_list_item` (`id`, `item`, `completed`, `user_id`) VALUES
(22, 'Go skydiving', 0, 'adam'),
(34, 'See the Eiffel Tower', 1, 'MyNameIsShannon'),
(37, 'Ride a jetski', 1, 'MyNameIsShannon'),
(38, 'Solve a rubiks cube', 1, 'MyNameIsShannon'),
(39, 'Learn to code', 1, 'MyNameIsShannon'),
(49, 'Go to the North Pole', 0, 'MyNameIsShannon'),
(50, 'Drive a supercar', 0, 'MyNameIsShannon'),
(51, 'Control a plane', 0, 'MyNameIsShannon'),
(52, 'Publish an app/website', 0, 'MyNameIsShannon'),
(54, 'Climb a mountain', 0, 'MyNameIsShannon');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `text` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `post_id`, `user_id`, `text`, `datetime`) VALUES
(1, 15, 'adam', 'Oooh you can\'t go wrong there! Perfect start to the perfect day.', '2022-04-12 07:21:34'),
(2, 15, 'samantha_panther', 'Your post has just inspired me to make something different too - blueberry pancakes! The dog will be upset to know that I won\'t be sharing my toast though :(', '2022-04-12 07:22:44'),
(3, 15, 'x_RickyRoo_x', 'Sharing is caring :D', '2022-04-12 08:22:44'),
(18, 15, 'MyNameIsShannon', 'I\'m afraid I won\'t be sharing - much too delicious for that!\r\n', '2022-04-12 08:55:27');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `ext` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `post_id`, `ext`) VALUES
(7, 43, 'jpeg'),
(10, 15, 'jpg');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `text` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `user_id`, `text`, `timestamp`) VALUES
(15, 'MyNameIsShannon', 'I had something new for breakfast today - Waffles! Making the day different nice and early this morning...', '2022-04-12 07:17:16'),
(43, 'MyNameIsShannon', 'Well that was an unexpected, but great element of my day... stopped at a service station and a bunch of supercars started rolling in for a car meet', '2022-04-17 20:07:55'),
(45, 'samantha_panther', 'We went to the arcade today for a while - great fun!', '2022-04-17 20:13:31');

-- --------------------------------------------------------

--
-- Table structure for table `post_like`
--

CREATE TABLE `post_like` (
  `post_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post_like`
--

INSERT INTO `post_like` (`post_id`, `user_id`) VALUES
(15, 'adam'),
(15, 'MyNameIsShannon'),
(15, 'samantha_panther'),
(43, 'samantha_panther'),
(45, 'adam'),
(45, 'MyNameIsShannon');

-- --------------------------------------------------------

--
-- Table structure for table `style`
--

CREATE TABLE `style` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `feminine_img` varchar(255) NOT NULL,
  `masculine_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `style`
--

INSERT INTO `style` (`id`, `name`, `description`, `feminine_img`, `masculine_img`) VALUES
(1, 'Geek Chic', 'Embrace your inner geek!', 'http://fashiontasty.com/wp-content/uploads/2016/05/Geek-Chic-Outfit-With-Bowq.jpg', 'https://www.obsessory.com/blog/wp-content/uploads/2016/09/geek_chic_fashion_tips_for_men.jpg'),
(2, 'Rocker', 'Rock on! Be bold!', 'http://ladyfashioniser.com/wp-content/uploads/2020/01/rocker-tees-fashion.jpg', 'https://cdn.shopify.com/s/files/1/0189/8987/5300/files/Dude_-_Rocker_in_leather_jacket_1024x1024_crop_center.jpg?v=1632117838'),
(3, 'Sporty', 'You don\'t have to do any sports though... promise!', 'https://flyingcdn-e81424e1.b-cdn.net/wp-content/uploads/2018/09/Screen-Shot-2018-09-20-at-15.42.32.jpg?width=800', 'https://www.outfit-styles.com/wp-content/uploads/2020/04/Sporty-Outfit-Men.jpg'),
(4, 'Smart Casual', 'Going to a meeting? Meeting your mates? Who knows?!', 'https://www.maridfashion.com/wp-content/uploads/2020/06/f39fd5abc908cf8e41d12b183e60d87a.jpg', 'https://i0.wp.com/jaxsonmaximus.com/wp-content/uploads/2020/04/7efef912cb7205358c1f9614d76590bd-400x600.jpg'),
(5, 'E-Girl / E-Boy', 'Think gothic combined with trendy Japanese street fashion!', 'https://i.pinimg.com/550x/ee/97/3c/ee973c75bc95e6082a9d5f990428c8d0.jpg', 'https://onpointfresh.com/wp-content/uploads/2019/11/042ac2e2e713e8fea6dc2efd49155529.jpg'),
(6, 'Hip Hop', 'Ready to record that next track?', 'https://i.pinimg.com/originals/ad/e9/cf/ade9cf758941c5e90a0b357df581a200.jpg', 'https://www.toptrendsguide.com/wp-content/uploads/2020/07/Snapback-Hats.jpg'),
(7, 'Preppy', 'Very suave! Lots of plaid!', 'https://editorialist.com/wp-content/uploads/2020/10/1-Preppy-Style_hero-vertical_New-York-str-RS20-0107.jpg', 'https://www.ties.com/blog/wp-content/uploads/2018/10/Preppy-style-feature.jpg'),
(8, 'Summer / Vacation', 'Bit cold? Bring a jacket!', 'https://trulymajestic.com/wp-content/uploads/2018/06/2018-Summer-Lady-Sexy-Deep-V-neck-Flower-print-Dresses-Black-Print-Hem-folds-Bohemian-Style.jpg_640x640.jpg', 'https://www.ubuy.co.it/productimg/?image=aHR0cHM6Ly9tLm1lZGlhLWFtYXpvbi5jb20vaW1hZ2VzL0kvODFMYnBFVlpmUEwuX0FDX1VMMTUwMF8uanBn.jpg'),
(9, 'Flamboyant', 'The brightest colors you can find! Go!', 'http://www.prettydesigns.com/wp-content/uploads/2014/06/Bright-Colored-Outfit-for-Women.jpg', 'https://i.pinimg.com/originals/7d/c1/cc/7dc1cc061f3c5f07febbdb7e71cf0610.jpg'),
(10, 'Formal', 'Dress to impress!', 'https://ds393qgzrxwzn.cloudfront.net/resize/m600x500/cat1/img/images/0/v4MbkrAHcK.jpg', 'https://www.fashionhombre.com/wp-content/uploads/2019/11/Dashing-Formal-Outfit-Ideas-For-Men-8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`) VALUES
('adam', '$2a$10$xCK3dPzJF/gBsHAOAqtRuugj4jj0Ev/gpcAAzgv4onVOSmCuaja6.'),
('MyNameIsShannon', '$2a$10$vxrzwKB5V8USnHMkTlTwx.O58KXkngo.hdrmKIVmgqfZExVyVJWWi'),
('samantha_panther', '$2a$10$QWMAA576sRhs5GJR/6Fa.OmS8D0gV5zQpvQrcTn0GNEoe9LDGx6/.'),
('x_RickyRoo_x', '$2a$10$Qw.ErGbHo1qXaODvJXS8vexz86gVUMC4f2xiOkds1r4yj5wJrILDO');

-- --------------------------------------------------------

--
-- Table structure for table `vision_board`
--

CREATE TABLE `vision_board` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `user_id` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vision_board`
--

INSERT INTO `vision_board` (`id`, `name`, `user_id`) VALUES
(10, '2022', 'MyNameIsShannon'),
(15, 'test', 'adam'),
(18, '2021', 'MyNameIsShannon');

-- --------------------------------------------------------

--
-- Table structure for table `vision_board_image`
--

CREATE TABLE `vision_board_image` (
  `id` int(11) NOT NULL,
  `vision_board_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vision_board_image`
--

INSERT INTO `vision_board_image` (`id`, `vision_board_id`, `path`, `width`, `height`, `x`, `y`) VALUES
(321, 18, 'https://miro.medium.com/max/1400/1*qQB3wK0mrY_qo8Jd4JY2kw.jpeg', 350, 262, 642, 181),
(322, 18, 'https://parade.com/wp-content/uploads/2020/06/iStock-1203599963.jpg', 200, 123, 372, 66),
(323, 18, 'https://www.hilton.com/im/en/NoHotel/15196649/shutterstock-1041475570.jpg?impolicy=crop&cw=4541&ch=3333&gravity=NorthWest&xposition=229&yposition=0&rw=582&rh=427', 200, 146, 22, 264),
(324, 18, 'https://post.healthline.com/wp-content/uploads/2019/10/reading-book-732x549-thumbnail.jpg', 200, 150, 419, 336),
(325, 18, 'https://imageio.forbes.com/specials-images/imageserve/60663652dccb5695c574fa98/Growing-evidence-suggests-a-causal-link-between-knowledge-and-comprehension-/960x0.jpg', 200, 133, 99, 106),
(354, 10, 'https://content.tui.co.uk/adamtui/2021_12/7_13/878f7fde-84ca-4804-85a5-adf700e44176/LOC_MDV_shutterstock_1938868960WebOriginalCompressed.jpg', 300, 199, 205, 0),
(355, 10, 'https://a.loveholidays.com/sanity/production/dba45f84-a320-4d38-a73f-0fb0631db57e.jpg', 300, 188, 559, 87),
(356, 10, 'https://www.helpguide.org/wp-content/uploads/woman-exercising-on-yoga-mat-768.jpg', 200, 120, 825, 342),
(357, 10, 'https://techcrunch.com/wp-content/uploads/2021/12/FF8DDkpWYAAJc3Y.jpeg', 250, 137, 425, 356);

-- --------------------------------------------------------

--
-- Table structure for table `vision_board_text`
--

CREATE TABLE `vision_board_text` (
  `id` int(11) NOT NULL,
  `vision_board_id` int(11) NOT NULL,
  `text` varchar(25) NOT NULL,
  `font` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `colour` varchar(255) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vision_board_text`
--

INSERT INTO `vision_board_text` (`id`, `vision_board_id`, `text`, `font`, `size`, `colour`, `x`, `y`) VALUES
(355, 18, 'Read more', 'Times New Roman', 24, '#1B998B', 277, 456),
(356, 18, 'Travel', 'sans-serif', 35, '#7F0799', 469, 293),
(357, 18, 'Health', 'Courier New', 24, '#D52941', 601, 67),
(358, 18, 'Skincare', 'Verdana', 30, '#FF9B71', 515, 42),
(359, 18, 'Time with family/friends', 'sans-serif', 24, '#7F0799', 382, 235),
(388, 10, 'Travel', 'Verdana', 35, '#FF9F1C', 872, 118),
(389, 10, 'Freedom', 'serif', 30, '#7F0799', 196, 453),
(390, 10, 'Adventure', 'sans-serif', 35, '#2D3047', 462, 310),
(391, 10, 'Healthy Lifestyle', 'Arial', 24, '#7F0799', 303, 253);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bucket_list_item`
--
ALTER TABLE `bucket_list_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_user` (`user_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_post` (`post_id`),
  ADD KEY `comment_user` (`user_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_post` (`post_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_like`
--
ALTER TABLE `post_like`
  ADD PRIMARY KEY (`post_id`,`user_id`),
  ADD KEY `postlike_user` (`user_id`);

--
-- Indexes for table `style`
--
ALTER TABLE `style`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `vision_board`
--
ALTER TABLE `vision_board`
  ADD PRIMARY KEY (`id`),
  ADD KEY `board_user` (`user_id`);

--
-- Indexes for table `vision_board_image`
--
ALTER TABLE `vision_board_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `image_board` (`vision_board_id`);

--
-- Indexes for table `vision_board_text`
--
ALTER TABLE `vision_board_text`
  ADD PRIMARY KEY (`id`),
  ADD KEY `text_board` (`vision_board_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `bucket_list_item`
--
ALTER TABLE `bucket_list_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `style`
--
ALTER TABLE `style`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vision_board`
--
ALTER TABLE `vision_board`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `vision_board_image`
--
ALTER TABLE `vision_board_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=358;

--
-- AUTO_INCREMENT for table `vision_board_text`
--
ALTER TABLE `vision_board_text`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=392;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bucket_list_item`
--
ALTER TABLE `bucket_list_item`
  ADD CONSTRAINT `item_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`username`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`username`);

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);

--
-- Constraints for table `post_like`
--
ALTER TABLE `post_like`
  ADD CONSTRAINT `postlike_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `postlike_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`username`);

--
-- Constraints for table `vision_board`
--
ALTER TABLE `vision_board`
  ADD CONSTRAINT `board_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`username`);

--
-- Constraints for table `vision_board_image`
--
ALTER TABLE `vision_board_image`
  ADD CONSTRAINT `image_board` FOREIGN KEY (`vision_board_id`) REFERENCES `vision_board` (`id`);

--
-- Constraints for table `vision_board_text`
--
ALTER TABLE `vision_board_text`
  ADD CONSTRAINT `text_board` FOREIGN KEY (`vision_board_id`) REFERENCES `vision_board` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
