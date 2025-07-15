SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `admin` (
  id int(11) NOT NULL AUTO_INCREMENT,
  UserName varchar(100) NOT NULL,
  Password varchar(100) NOT NULL,
  fullname varchar(255) NOT NULL,
  email varchar(55) NOT NULL,
  updationDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin` (`id`, `UserName`, `Password`, `fullname`, `email`, `updationDate`) VALUES
(1, 'admin', '0e7517141fb53f21ee439b355b5a1d0a', 'Admin', 'admin@nmit.ac.in', '2024-06-09 15:15:46'),
(2, 'hod', '0e7517141fb53f21ee439b355b5a1d0a', 'HOD', 'hod@nmit.ac.in', '2024-06-09 15:15:54');

CREATE TABLE `tblteachers` (
  id int(11) NOT NULL AUTO_INCREMENT,
  teacherid varchar(50) NOT NULL,
  FirstName varchar(150) NOT NULL,
  LastName varchar(150) NOT NULL,
  EmailId varchar(200) NOT NULL,
  Password varchar(100) NOT NULL,
  Gender varchar(100) NOT NULL,
  JoiningDate varchar(100) NOT NULL,
  Department varchar(255) NOT NULL,
  Designation varchar(255) NOT NULL,
  Status int(1) NOT NULL,
  RegDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblteachers` (`id`, `teacherid`,`FirstName`, `LastName`, `EmailId`, `Password`,`Gender`, `JoiningDate`, `Department`, `Designation`,`Status`,`RegDate`) VALUES
(1, 'T01','Archana', 'Naik', 'archana.naik@nmit.ac.in','202cb962ac59075b964b07152d234b70', 'Female', '2002-07-08', 'CSE', 'Associate Professor', 1, '2024-07-05 11:29:59'),
(2, 'T02','Bhoomika', 'S S', 'bhoomika.ss@nmit.ac.in','202cb962ac59075b964b07152d234b70','Female', '2023-02-27', 'CSE', 'Assistant Professor', 1, '2024-07-05 13:40:02'),
(3, 'T03','Chaitra', 'Nayak J','chaitra.nayak@nmit.ac.in','202cb962ac59075b964b07152d234b70','Female', '2023-08-21', 'CSE', 'Assistant Professor',1, '2024-07-06 07:24:17'),
(4, 'T04','Jagdeesh', 'Patil S','jagadish.patil@nmit.ac.in','202cb962ac59075b964b07152d234b70','Male', '2018-08-05', 'CSE', 'Professor',1, '2024-07-06 10:44:13'),
(5, 'T05','Sowmya', 'P', 'sowmya.p@nmit.ac.in','202cb962ac59075b964b07152d234b70', 'Female', '2022-07-01', 'CSE', 'Assistant Professor',1, '2024-07-07 17:14:48');

CREATE TABLE tblleaves (
  id int(11) NOT NULL AUTO_INCREMENT,
  LeaveType varchar(110) NOT NULL,
  ToDate varchar(120) NOT NULL,
  FromDate varchar(120) NOT NULL,
  Description mediumtext NOT NULL,
  PostingDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  AdminRemark mediumtext,
  AdminRemarkDate varchar(120) DEFAULT NULL,
  Status int(1) NOT NULL,
  IsRead int(1) NOT NULL,
  teacherid int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY UserEmail (teacherid)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO tblleaves (id, LeaveType, ToDate, FromDate, Description, PostingDate, AdminRemark, AdminRemarkDate, Status, IsRead, teacherid) VALUES
(6, 'Casual Leave', '30/06/2024', '29/06/2024', 'This is a demo description', '2024-06-19 13:11:21', 'A demo Admin Remarks', '2024-06-20 23:26:27 ', 2, 1, 1),
(7, 'Medical Leave', '21/05/2020', '25/05/2024', 'This is a demo description', '2024-05-20 11:14:14', 'A demo Admin Remarks', '2024-05-20 23:24:39 ', 1, 1, 1),
(8, 'Medical Leave', '08/04/2024', '12/04/2024', 'This is a demo description', '2024-04-02 18:26:01', 'A demo Admin Remarks', '2024-04-03 11:19:29 ', 1, 1, 2),
(9, 'Restricted Holiday', '25/06/2024', '25/06/2024', 'This is a demo description', '2024-06-03 08:29:07', 'A demo Admin Remarks', '2024-06-03 14:06:12 ', 1, 1, 1),
(10, 'Medical Leave', '02/12/2023', '06/12/2023', 'This is a demo description', '2023-12-29 15:01:14', 'A demo Admin Remarks', '2023-12-29 20:33:21 ', 1, 1, 1),
(11, 'Casual Leave', '02/02/2024', '03/03/2024', 'This is a demo description', '2024-01-30 08:11:11', 'A demo Admin Remarks', '2024-01-30 13:42:05 ', 1, 1, 1);

CREATE TABLE tblleavetype (
  id int(11) NOT NULL AUTO_INCREMENT,
  LeaveType varchar(200) DEFAULT NULL,
  Description mediumtext,
  CreationDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO tblleavetype (id, LeaveType, Description, CreationDate) VALUES
(1, 'Casual Leave', 'Provided for urgent or unforeseen matters', '2024-01-01 12:07:56'),
(2, 'Medical Leave', 'Related to Health Problems', '2024-01-06 13:16:09'),
(3, 'Restricted Holiday', 'Holiday that is optional', '2024-01-06 13:16:38'),
(4, 'Paternity Leave', 'To take care of newborns', '2024-03-03 10:46:31'),
(5, 'Bereavement Leave', 'Grieve their loss of losing loved ones', '2024-03-03 10:47:48'),
(6, 'Maternity Leave', 'Taking care of newborn ,recoveries', '2024-03-03 10:50:17'),
(7, 'Religious Holidays', 'Based on teacher\'s followed religion', '2024-03-03 10:51:26'),
(8, 'Adverse Weather Leave', 'In terms of extreme weather conditions', '2024-03-03 13:18:26'),
(9, 'Voting Leave', 'For official election day', '2024-03-03 13:19:06'),
(10, 'Personal Time Off', 'To manage some private matters', '2024-03-03 13:21:10');