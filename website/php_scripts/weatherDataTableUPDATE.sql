
DROP TABLE IF EXISTS `weatherdata`;
CREATE TABLE IF NOT EXISTS `weatherdata` (
  `city_id` int(11) NOT NULL,
  `temp` float NOT NULL,
  `t_datetime` datetime NOT NULL,
  `cloud` varchar(130) NOT NULL,
  `rain` float NOT NULL,
  `w_dir` varchar(6) NOT NULL,
  `w_speed` int(11) NOT NULL,
  `w_gust` int(11) NOT NULL,
  `pressure` float NOT NULL,
  `humiditiy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weatherdata`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `weatherdata`
--
ALTER TABLE `weatherdata`
 ADD PRIMARY KEY (`city_id`,`t_datetime`);
