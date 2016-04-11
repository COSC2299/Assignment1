CREATE TABLE IF NOT EXISTS `weatherdata` (
  `city_id` int(11) NOT NULL,
  `temp` float NOT NULL,
  `t_datetime` datetime NOT NULL,
   PRIMARY KEY (`city_id`,`t_datetime`)
) 