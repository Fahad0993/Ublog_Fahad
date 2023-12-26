-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2023 at 03:48 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ublog_fahad`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `body` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `parent_id`, `post_id`, `user_id`, `username`, `body`, `created_at`) VALUES
(5, 0, 14, 17, 'Drishtant', 'Nice blog!', '2023-12-09 20:01:54'),
(6, 5, 14, 16, 'BibhuPrasad', '@Drishtant thank you', '2023-12-09 20:02:45');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `published` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `views` int(100) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `username`, `topic_id`, `title`, `image`, `body`, `published`, `created_at`, `views`) VALUES
(14, 16, 'BibhuPrasad', 7, 'Tech Talk: Exploring the Cutting Edge of Innovation', '1702132086_tech.jpg', '&lt;p&gt;In a world defined by rapid technological evolution, innovation is the compass guiding us into the future. Let\'s take a swift journey through the cutting edge of tech, exploring key trends shaping our tomorrow.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;1. Artificial Intelligence (AI):&lt;/strong&gt; Beyond sci-fi, AI infiltrates our daily lives, from virtual assistants to data analysis. Its potential to revolutionize industries is boundless.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;2. Quantum Computing:&lt;/strong&gt; Quantum principles redefine computing, promising unparalleled speeds and applications from cryptography to drug discovery.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;3. 5G Connectivity:&lt;/strong&gt; More than just faster downloads, 5G facilitates IoT and fuels technologies like AR and smart cities, reshaping our interconnected world.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;4. Biotechnology and CRISPR:&lt;/strong&gt; Gene editing technology like CRISPR offers groundbreaking possibilities in healthcare and beyond, sparking ethical discussions.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;5. Sustainable Tech:&lt;/strong&gt; Innovation now intertwines with responsibility. Sustainable tech focuses on eco-friendly practices, renewable energy, and a circular economy mindset.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;6. Augmented Reality (AR):&lt;/strong&gt; AR blurs digital and physical realms, transforming gaming, education, and industry interactions. The future holds seamless integration of virtual and real.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;Conclusion:&lt;/strong&gt; As we ride the wave of innovation, balancing progress with ethics and sustainability is crucial. Navigating tomorrow\'s tech landscape requires mindfulness, ensuring a future where the unimaginable becomes reality.&lt;/p&gt;', 1, '2023-12-09 19:58:06', 8),
(15, 16, 'BibhuPrasad', 8, 'Body and Soul: The Holistic Approach to Health and Fitness', '1702132600_fitness.jpg', '&lt;p&gt;In the pursuit of well-being, a holistic approach that nurtures both body and soul has gained prominence. It goes beyond mere physical fitness, delving into the interconnected realms of mental and spiritual health.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;Mindful Movement:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;Holistic health recognizes the power of mindful movement, encompassing exercises that not only strengthen the body but also engage the mind. Practices like yoga and tai chi foster a union of physical and mental well-being, promoting flexibility, balance, and inner calm.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;Nutrition as Nourishment:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;Fueling the body is not just about counting calories; it\'s about providing nourishment. A holistic approach to nutrition emphasizes whole, nutrient-dense foods that sustain energy, support immune function, and contribute to overall vitality. It\'s a conscious choice to eat with purpose, recognizing the profound impact on both physical and mental health.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;Mental Fitness Matters:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;True health extends beyond the physical. Mental fitness is a cornerstone of holistic well-being. Incorporating practices like meditation, mindfulness, and stress management techniques cultivates a resilient mind, fostering emotional balance and clarity.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;Soulful Connection:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;The holistic approach recognizes the intricate connection between body and soul. Cultivating a sense of purpose, engaging in activities that bring joy, and nurturing social connections contribute to a richer, more fulfilling life. Wellness is not just a physical state but a holistic experience that encompasses the soul\'s journey.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;Balancing Act:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;Holistic health is a delicate balance, acknowledging that each aspect &ndash; body, mind, and soul &ndash; influences the others. It\'s a personalized journey, understanding that what works for one may not work for another. By embracing this comprehensive approach, individuals can achieve a harmonious balance that promotes lasting health and vitality.&lt;/p&gt;&lt;p&gt;In the pursuit of a healthier and more fulfilling life, consider adopting a holistic approach to health and fitness. Nurture your body, engage your mind, and feed your soul &ndash; the synergy of these elements is the key to unlocking a truly vibrant and balanced life.&lt;/p&gt;', 1, '2023-12-09 20:06:40', 1),
(16, 16, 'BibhuPrasad', 9, 'Shivers Down the Spine: Exploring the Macabre in Dark Corners', '1702132827_horror.jpeg', '&lt;p&gt;Welcome to the realm where shadows come alive, and whispers of the unknown send shivers down the spine. In &quot;Shivers Down the Spine,&quot; we embark on a journey into the macabre, unraveling tales that lurk in the darkest corners of our imagination.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;1. Unveiling the Unseen:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;Dare to delve into the unknown as we unveil stories that defy explanation. From haunted houses to eerie encounters, explore the supernatural phenomena that linger in the shadows, waiting to be discovered.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;2. Legends of Lore:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;The blog unfolds the pages of chilling legends and folklore that have echoed through generations. These tales, rooted in the macabre, offer a glimpse into the mysterious and the inexplicable, blurring the lines between reality and the ethereal.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;3. Haunting Histories:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;History has its own ghosts, and we navigate through the haunted corridors of the past. From forgotten tragedies to unsolved mysteries, join us in uncovering the chilling histories that cast a spectral veil over time.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;4. Dark Arts and Entities:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;Venture into the world of dark arts and entities that defy comprehension. From malevolent spirits to entities that traverse the boundary between the living and the dead, we explore the supernatural forces that send a shiver down the bravest spine.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;5. Tales of Terror:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;Prepare for a collection of spine-tingling tales that will haunt your dreams. Each narrative is a carefully crafted journey into the macabre, igniting the imagination and awakening the primal fear that resides within us all.&lt;/p&gt;&lt;p&gt;In &quot;Shivers Down the Spine,&quot; the macabre takes center stage as we peer into the abyss of the unknown. Brace yourself for a riveting exploration of the mysterious, the eerie, and the downright terrifying. Join us on this odyssey into the dark corners where the line between reality and the supernatural blurs, leaving a lingering chill that echoes long after the tales are told.&lt;/p&gt;', 1, '2023-12-09 20:10:27', 0),
(17, 16, 'BibhuPrasad', 7, 'Breaking the Code: Decoding the Language of Technology', '1702133041_tech1.jpg', '&lt;p&gt;In the ever-evolving landscape of technology, where lines of code hold the keys to innovation, we embark on a journey to unravel the intricate language that powers our digital world. Welcome to &quot;Breaking the Code,&quot; where we delve into the heart of technology, decoding the language that shapes our present and defines our future.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;1. The Digital Cipher:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;At the core of technology lies a digital cipher, a language composed of zeros and ones. We\'ll explore the fundamentals of binary code, the building blocks of software and the language that computers use to process information. Understanding this foundation is like gaining entry to a secret chamber where the magic of computation happens.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;2. Programming Poetry:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;Programming languages are the verses in which software developers craft their symphonies. From the elegance of Python to the precision of C++, we\'ll traverse the diverse landscape of programming languages. Each has its syntax, its rhythm, and its purpose, and together they form the lexicon of technology.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;3. APIs: Bridging the Divide:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;Application Programming Interfaces (APIs) act as bridges between different software systems, enabling them to communicate and collaborate. We\'ll demystify the role of APIs, exploring how they facilitate seamless integration, fueling the interconnected digital experiences we take for granted.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;4. Machine Speak:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;Artificial Intelligence (AI) and Machine Learning (ML) have introduced a new dialect in the technological lexicon. We\'ll dissect the algorithms and models, understanding how machines learn and make decisions. It\'s a conversation with the future, where machines become fluent in understanding patterns and predicting outcomes.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;5. Cryptography: Secrets and Security:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;In the digital realm, secrets are guarded by cryptography. We\'ll uncover the algorithms that secure our data, ensuring privacy and integrity in a world where cyber threats are ever-present. From encryption to hashing, we\'ll decode the safeguards that keep our digital transactions and communications secure.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;6. The Language of the Internet:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;HTML, CSS, and JavaScript are the languages that give life to the web. We\'ll explore the syntax of web development, understanding how these languages work together to create the dynamic and interactive experiences we encounter while surfing the digital waves.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;Conclusion: The Technological Rosetta Stone:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;As we conclude our journey into &quot;Breaking the Code,&quot; we realize that the language of technology is a dynamic and ever-expanding tapestry. It\'s a conversation between humans and machines, a dialogue that propels us into a future where the boundaries between the digital and physical worlds continue to blur. Whether you\'re a seasoned developer or a curious enthusiast, decoding this language is the key to unlocking the full potential of the technological landscape that surrounds us. The code is broken, and the language of technology beckons us to explore, innovate, and shape the digital narratives of tomorrow.&lt;/p&gt;', 1, '2023-12-09 20:14:01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `cadmin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`id`, `name`, `description`, `cadmin_id`) VALUES
(7, 'Technology', '<p>tech</p>', 15),
(8, 'Health and Fitness', '<p>heath</p>', 13),
(9, 'Horror', '<p>horror</p>', 14);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'FahadShaikh', 'shaikhfahad1993@gmail.com', '$2y$10$vebKPZrB8X9ZsXoarpHmi.6OnSGe5ZU8QJxKVRMIeu/lhfBPeDJmq', '2023-08-04 07:00:38', '1'),
(13, 'Parveen', 'parveen123@gmail.com', '$2y$10$K5ewn.6DjEgPWgx38Wxww.0BXR6BNnWkG/Ro5eVbcy9qx4V2V98mS', '2023-12-09 14:10:31', '2'),
(14, 'AnweshMishra', 'anwesh123@gmail.com', '$2y$10$zR3nbFZ0.044xxEs2bINbOxNIK6mWOWFgRwFgEs5ksqdvC0vIzmNi', '2023-12-09 14:12:24', '2'),
(15, 'Venkat', 'venkat123@gmail.com', '$2y$10$Ekj6P4Q73UOWwaTZlK3pnOpUSjDntJYq/yOJan29BhxQRarDyCn0a', '2023-12-09 14:13:37', '2'),
(16, 'BibhuPrasad', 'Bibhu123@gmail.com', '$2y$10$IEFIIc4IC1WbuLs1Pgr8J..m1BckFgVLQPcgA8kVbfWhjPU75cGJS', '2023-12-09 14:19:34', '3'),
(17, 'Drishtant', 'drishtant123@gmail.com', '$2y$10$9U8Qx1P10.uSGgEV3VUXYeWExFcobUrYRAaMoeo0v4xPoORjbVgbO', '2023-12-09 14:24:21', '4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
