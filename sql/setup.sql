
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `project` VALUES (1,'Project');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(16) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `work_type`;
CREATE TABLE `work_type` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `work_type` VALUES (1,'Project planning'),(2,'Project management'),(3,'Requirements specification'),(4,'Design'),(5,'Code'),(6,'Integration and testing'),(7,'Review'),(8,'Repair'),(9,'Other');

DROP TABLE IF EXISTS `worklog`;
CREATE TABLE `worklog` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `work_type_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `week` int(11) NOT NULL,
  `work_description` varchar(255) NOT NULL,
  `time_worked` decimal(5,2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
