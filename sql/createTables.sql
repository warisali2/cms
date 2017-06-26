CREATE TABLE country
(
  countryID INT AUTO_INCREMENT NOT NULL,
  countryName VARCHAR(100) NOT NULL,

  PRIMARY KEY(countryID),
  UNIQUE (countryName)
);

CREATE TABLE city
(
  cityID INT NOT NULL,
  cityName VARCHAR(100) NOT NULL,
  countryID INT NOT NULL,

  PRIMARY KEY(cityID, countryID),
  FOREIGN KEY(countryID) REFERENCES country(countryID),
  UNIQUE (cityName)
);

#Inserting null country and city
INSERT INTO country VALUES(0,'NONE');
INSERT INTO city VALUES(0,'none',0);

CREATE TABLE teacher
(
  teacherID INT AUTO_INCREMENT NOT NULL,
  password VARCHAR(200) NOT NULL,
  firstName VARCHAR(50) NOT NULL,
  lastName VARCHAR(50) NOT NULL,
  gender VARCHAR(1) NOT NULL,
  cnic VARCHAR(15) NOT NULL,
  dob DATE NOT NULL,
  fatherFirstName VARCHAR(50) NOT NULL,
  fatherLastName VARCHAR(50) NOT NULL,
  hiredate DATE NOT NULL,
  email VARCHAR(200),
  phone VARCHAR(12) NOT NULL,
  houseNo VARCHAR(50) NOT NULL,
  streetNo VARCHAR(50) NOT NULL,
  cityID INT NOT NULL,
  countryID INT NOT NULL,

  PRIMARY KEY(teacherID),
  FOREIGN KEY(cityID, countryID) REFERENCES city(cityID, countryID)
);

#Inserting Admin
INSERT INTO teacher VALUES(0,'admin','ad','min','1234567890123',CURDATE(),'none','none',CURDATE(),'','123455678901','123','456',0,0);

CREATE TABLE student
(
  studentID INT AUTO_INCREMENT NOT NULL,
  password VARCHAR(200) NOT NULL,
  firstName VARCHAR(50) NOT NULL,
  lastName VARCHAR(50) NOT NULL,
  gender VARCHAR(1) NOT NULL,
  cnic VARCHAR(15) NOT NULL,
  dob DATE NOT NULL,
  fatherFirstName VARCHAR(50) NOT NULL,
  fatherLastName VARCHAR(50) NOT NULL,
  enrollDate DATE NOT NULL,
  email VARCHAR(200),
  phone VARCHAR(12) NOT NULL,
  houseNo VARCHAR(50) NOT NULL,
  streetNo VARCHAR(50) NOT NULL,
  cityID INT NOT NULL,
  countryID INT NOT NULL,

  PRIMARY KEY(studentID),
  FOREIGN KEY(cityID, countryID) REFERENCES city(cityID, countryID)
);

CREATE TABLE deptartment
(
  deptID INT AUTO_INCREMENT NOT NULL,
  deptName VARCHAR(50) NOT NULL,
  cityID INT NOT NULL,
  countryID INT NOT NULL,

  UNIQUE (deptName),
  PRIMARY KEY(deptID),
  FOREIGN KEY(cityID, countryID) REFERENCES city(cityID, countryID)
);

CREATE TABLE room
(
  roomID INT NOT NULL,
  roomName VARCHAR(50) NOT NULL,
  type VARCHAR(1) DEFAULT 'R', # R = ROOM, L = LAB
  deptID INT NOT NULL,
  capacity INT NOT NULL,

  UNIQUE (roomName),
  PRIMARY KEY(roomID, deptID),
  FOREIGN KEY(deptID) REFERENCES deptartment(deptID)
);

CREATE TABLE course
(
  courseID INT AUTO_INCREMENT NOT NULL,
  courseName VARCHAR(100) NOT NULL,
  maxStudents INT NOT NULL,
  startDate DATE NOT NULL,
  endDate DATE NOT NULL,
  description VARCHAR(1000),
  startTime TIME NOT NULL,
  endTime TIME NOT NULL,
  weekDays VARCHAR(14) NOT NULL,

  UNIQUE (courseName),
  PRIMARY KEY(courseID)
);

CREATE TABLE courseAssignment
(
  courseID INT NOT NULL,
  teacherID INT NOT NULL,
  roomID INT NOT NULL,
  day varchar(1) not null,
  startTime date not null,
  endTime date not null,

  PRIMARY KEY(courseID, teacherID, roomID, day, startTime, endTime),
  FOREIGN KEY (courseID) REFERENCES course(courseID),
  FOREIGN KEY (teacherID) REFERENCES teacher(teacherID),
  FOREIGN KEY (roomID) REFERENCES room(roomID)
);

CREATE TABLE courePreReq
(
  courseID INT NOT NULL,
  preReqID INT NOT NULL,

  PRIMARY KEY (courseID, preReqID),
  FOREIGN KEY (courseID) REFERENCES course(courseID),
  FOREIGN KEY (preReqID) REFERENCES course(courseID)
);

CREATE TABLE studentCourse
(
  studentID INT NOT NULL,
  courseID INT NOT NULL,
  enrollDate DATE NOT NULL,
  status VARCHAR(1) DEFAULT 'F', # P = Pass, F = Fail

  PRIMARY KEY (studentID, courseID),
  FOREIGN KEY (studentID) REFERENCES student(studentID),
  FOREIGN KEY (courseID) REFERENCES course(courseID)
);

CREATE TABLE attendance
(
  courseID INT NOT NULL,
  studentID INT NOT NULL,
  attendDate DATE NOT NULL,

  PRIMARY KEY (studentID, courseID, attendDate),
  FOREIGN KEY (studentID) REFERENCES student(studentID),
  FOREIGN KEY (courseID) REFERENCES course(courseID)
);

CREATE TABLE exam
(
  courseID INT NOT NULL,
  type VARCHAR(1) NOT NULL, # M = Mids, F = Finals
  totalMarks INT NOT NULL,
  examDate DATE NOT NULL,

  PRIMARY KEY (courseID, type),
  FOREIGN KEY (courseID) REFERENCES course(courseID)
);

CREATE TABLE examMarks
(
  courseID INT NOT NULL,
  examType VARCHAR(1) NOT NULL,
  studentID INT NOT NULL,
  obtainedMarks INT NOT NULL,

  PRIMARY KEY (courseID, examType, studentID),
  FOREIGN KEY (studentID) REFERENCES student(studentID),
  FOREIGN KEY (courseID, examType) REFERENCES exam(courseID, type)
);

CREATE TABLE sesActiv
(
  sesID INT NOT NULL,
  courseID INT NOT NULL,
  sesName VARCHAR(50) NOT NULL,
  type VARCHAR(1) DEFAULT 'Q', # Q = Quiz, A = Assignment, C = Class Activity
  sesDate DATE NOT NULL,
  totalMarks INT NOT NULL,
  weightage FLOAT NOT NULL,

  PRIMARY KEY (sesID, courseID),
  FOREIGN KEY (courseID) REFERENCES course(courseID)
);

CREATE TABLE sesActivMarks
(
  sesID INT NOT NULL,
  studentID INT NOT NULL,
  courseID INT NOT NULL,
  obtainedMarks INT NOT NULL,

  PRIMARY KEY (sesID, studentID, courseID),
  FOREIGN KEY (studentID) REFERENCES student(studentID),
  FOREIGN KEY (sesID) REFERENCES sesActiv(sesID),
  FOREIGN KEY (courseID) REFERENCES course(courseID)
);
