DROP TABLE CustomerHistory;
DROP TABLE GameList;
DROP TABLE Customer;

CREATE TABLE IF NOT EXISTS`Customer` (
customerCode INT AUTO_INCREMENT UNIQUE PRIMARY KEY,
firstName VARCHAR(20) NOT NULL,
lastName VARCHAR(20) NOT NULL,
userName VARCHAR(20) NOT NULL,
password VARCHAR(20) NOT NULL,
pointsTotal INT
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS`GameList` (
gameCodes INT AUTO_INCREMENT UNIQUE KEY,
gameName VARCHAR(20) NOT NULL,
consoleName VARCHAR(20) NOT NULL,
pointsValue INT,
PRIMARY KEY(gameCodes,pointsValue)
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS`CustomerHistory` (
custCode INT,
purchaseDate VARCHAR(10),
gameCode INT,
points INT,
FOREIGN KEY (custCode) REFERENCES Customer (customerCode)
)ENGINE=INNODB;

ALTER TABLE `CustomerHistory`
    ADD FOREIGN KEY (gameCode)
    REFERENCES `GameList`(`gameCodes`);
    
INSERT INTO GameList (gameName,consoleName,pointsValue) VALUES ('Mario','Wii',5);
INSERT INTO GameList (gameName,consoleName,pointsValue) VALUES ('FIFA 12','Wii',7);
INSERT INTO GameList (gameName,consoleName,pointsValue) VALUES ('Wii Fit','Wii',10);
INSERT INTO GameList (gameName,consoleName,pointsValue) VALUES ('Mario','DSi',7);
INSERT INTO GameList (gameName,consoleName,pointsValue) VALUES ('Cooking','DSi',8);
INSERT INTO GameList (gameName,consoleName,pointsValue) VALUES ('Nintendogs','DSi',8);
INSERT INTO GameList (gameName,consoleName,pointsValue) VALUES ('Spiderman','DSi',9);

INSERT INTO Customer (firstName,lastName,userName,password) VALUES ('Charlie','Chops','CharlieC','chops');
INSERT INTO Customer (firstName,lastName,userName,password) VALUES ('Jack','Webster','JackW','webster');
INSERT INTO Customer (firstName,lastName,userName,password) VALUES ('Chris','Pollock','ChrisP','pollock');
INSERT INTO Customer (firstName,lastName,userName,password) VALUES ('Mark','Nutt','MarkN','nutt');
INSERT INTO Customer (firstName,lastName,userName,password) VALUES ('Rick','Astley','RickA','astley');
INSERT INTO Customer (firstName,lastName,userName,password) VALUES ('Shibe','Doge','ShibeD','doge');
INSERT INTO Customer (firstName,lastName,userName,password) VALUES ('Captain','Planet','CaptainP','planet');
INSERT INTO Customer (firstName,lastName,userName,password) VALUES ('Spider','Man','SpiderM','man');
INSERT INTO Customer (firstName,lastName,userName,password) VALUES ('John','Malkovich','JohnM','malkovic');
INSERT INTO Customer (firstName,lastName,userName,password) VALUES ('Average','McSamey','AverageM','mcsamey');
INSERT INTO Customer (firstName,lastName,userName,password) VALUES ('John','Doe','JohnD','doe');
INSERT INTO Customer (firstName,lastName,userName,password) VALUES ('Barack','Obama','BarackO','obama');

INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('1','18-02-14',7);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('2','12-02-14',2);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('5','12-02-14',2);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('3','07-02-14',4);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('2','02-02-14',1);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('8','01-02-14',6);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('4','28-01-14',3);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('11','24-01-14',5);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('7','23-01-14',7);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('11','23-01-14',1);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('9','21-01-14',7);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('1','21-01-14',1);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('6','20-01-14',7);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('2','17-01-14',3);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('10','12-01-14',3);
INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode) VALUES ('12','10-01-14',1);

-- Updates used for creating table values, will be handled by php in next stage

UPDATE CustomerHistory x LEFT JOIN GameList y
ON y.gameCodes=x.gameCode
SET x.points=y.pointsValue;

UPDATE Customer x LEFT JOIN(
SELECT custCode, SUM(points) pointSum
FROM CustomerHistory
GROUP BY custCode)
y ON x.customerCode = y.custCode
SET x.pointsTotal = y.pointSum;
