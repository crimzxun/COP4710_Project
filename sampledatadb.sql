USE UniversityEventSite;

-- Universities
INSERT INTO `Universities` (`UniversityID`, `Name`, `Location`, `Description`, `StudentNum`, `ImageURL`)
VALUES (1, 'University of Central Florida', 'Orlando, Florida',
        'Largest Enrollment by University in Florida! Go  Charge On!',
        69000, 'https://www.ucf.edu/brand/wp-content/blogs.dir/13/files/2016/07/BrandAsset_athletics-stackedUCF.jpg'),
       (2, 'Florida State University', 'Tallahassee, Florida',
        'Public Institution founded in 1851', 42000,
        'https://upload.wikimedia.org/wikipedia/commons/3/33/Florida_State_Seminoles_Alternate_Logo.png'),
       (3, 'University of Florida', 'Gainesville, Florida',
        'Public research university founded in 1853',
        52000, 'https://1000logos.net/wp-content/uploads/2022/07/University-of-Florida-Logo.png'),
        (4, 'University of South Florida', 'Tampa, Florida',
        'Founded in 1956, USF is a young and vibrant university located in Tampa, Florida',
        57000, 'https://www.ucf.edu/brand/wp-content/blogs.dir/13/files/2016/07/BrandAsset_athletics-stackedUCF.jpg');

-- Users
INSERT INTO `Users` (`UserID`, `Email`, `Password`, `FullName`, `UniversityID`, `isAdmin`)
VALUES (1, 'EmilyP@ucf.edu', 'password', 'Emily Parker', 1, NULL),
       (2, 'JacobS@ucf.edu', 'password', 'Jacob Smith', 1, NULL),
       (3, 'EthanW@ucf.edu', 'password', 'Ethan Williams',1, NULL),
       (4, 'OliviaJ@ucf.edu', 'password', 'Olivia Johnson', 1, NULL),
       (5, 'AvaB@ucf.edu', 'password', 'Ava Brown',1, NULL),
       (6, 'LiamJ@ucf.edu', 'password', 'Liam Jones', 1, NULL),
       (7, 'SophiaD@ucf.edu', 'password', 'Sophia Davis', 1, NULL),
       (8, 'NoahM@ucf.edu', 'password', 'Noah Miller', 1, NULL),
       (9, 'IsabellaW@ucf.edu', 'password', 'Isabella Wilson', 1, NULL),
       (10, 'MasonT@ucf.edu', 'password', 'Mason Taylor', 1, NULL),
       (11, 'MiaM@ucf.edu', 'password', 'Mia Martinez', 2, NULL),
       (12, 'BenjyA@fsu.edu', 'password', 'Benjamin Anderson', 2, NULL),
       (13, 'CharlotteT@fsu.edu', 'password', 'Charlotte Thomas', 2, NULL),
       (14, 'JamesJ@fsu.edu', 'password', 'James Jackson', 2, NULL),
       (15, 'AmeliaW@fsu.edu', 'password', 'Amelia White', 2, NULL),
       (16, 'AlexH@fsu.edu', 'password', 'Alexander Harris', 2, NULL),
       (17, 'HarperT@fsu.edu', 'password', 'Harper Thompson', 2, NULL),
       (18, 'MichaelG@fsu.edu', 'password', 'Michael Garcia', 2, NULL),
       (19, 'EvelynR@fsu.edu', 'password', 'Evelyn Rodriguez', 2, NULL),
       (20, 'WilliamM@fsu.edu', 'password', 'William Martinez', 2, NULL),
       (21, 'AbigailC@ufedu', 'password', 'Abigail Clark', 3, NULL),
       (22, 'DanielH@uf.edu', 'password', 'Daniel Hernandez', 3, NULL),
       (23, 'ElizabthL@uf.edu', 'password', 'Elizabeth Lewis', 3, NULL),
       (24, 'ElijahG@uf.edu', 'password', 'Elijah Gonzalez', 3, NULL),
       (25, 'EvelynS@uf.edu', 'password', 'Evelyn Scott', 3, NULL),
       (26, 'Peter.P@uf.edu', 'password', 'Peter Parker', 3, NULL),
       (27, 'GraceHill@uf.edu', 'password', 'Grace Hill', 3, NULL),
       (28, 'AidenW@uf.edu', 'password', 'Aiden Walker', 3, NULL),
       (29, 'ChloeY@uf.edu', 'password', 'Chloe Young', 3, NULL),
       (30, 'SamK@uf.edu', 'password', 'Samuel King', 3, NULL),
       (31, 'ScarlettT@usf.edu', 'password', 'Scarlett Turner', 4, NULL),
       (32, 'HenryA@usf.edu', 'password', 'Henry Adams', 4, NULL),
       (33, 'LilyF@usf.edu', 'password', 'Lily Flores', 4, NULL),
       (34, 'SebastianC@usf.edu', 'password', 'Sebastian Carter', 4, NULL),
       (35, 'MadisonH@usf.edu', 'password', 'Madison Hall', 4, NULL),
       (36, 'DavidR@usf.edu', 'password', 'David Ramirez', 4, NULL),
       (37, 'ZoeA@usf.edu', 'password', 'Zoe Allen', 4, NULL),
       (38, 'GabrielC@usf.edu', 'password', 'Gabriel Cook', 4, NULL),
       (39, 'NatB@usf.edu', 'password', 'Natalie Brooks', 4, NULL),
       (40, 'JackR@usf.edu', 'password', 'Jackson Reed', 4, NULL);

-- RSOS
INSERT INTO `rsos` (`RSOID`, `Name`, `Description`, `UniversityID`, `ImageURL`)
VALUES (1, 'UCF KnightHacks', 'A club for students interested in coding and programming.', 1, ''),
       (2, 'UCF Rock Climbing', 'A club for rock climbers of all skills sets.', 1, ''),
       (3, 'UCF CASA', 'A culture club for Chinese American Student Association', 1, ''),
       (4, 'UCF Tennis Club ', 'A club for tennis players of all skill sets.', 1, ''),
       (5, 'UCF Esports', 'UCF Competitive Esports Team.', 1, ''),
       (6, 'FSU Coding Club', 'A club for students interested in coding and programming.', 2, ''),
       (7, 'FSU Robotics Society', 'A society dedicated to robotics and automation.', 2, ''),
       (8, 'FSU Tennis Club', 'A club for students who enjoy playing tennis.', 2, ''),
       (9, 'FSU Sailing Club', 'A club for those interested in sailing.', 2, ''),
       (10, 'FSU Engineering Society', 'A society for students pursuing engineering degrees.', 2, ''),
       (11, 'UF Engineering Society', 'A club for students interested in coding and programming.', 3, ''),
       (12, 'UF AI Club', 'A society dedicated to artificial intellegence.', 3, ''),
       (13, 'UF Chess Club', 'A club for students who enjoy playing chess.', 3, ''),
       (14, 'UF Art Club', 'A club for those interested in art.', 3, ''),
       (15, 'UF Esports', 'UF Comptitive Esports team.', 3, '');


INSERT INTO `rsomembers` (`UserID`, `RSOID`) VALUES
(1, 1),
(2, 1),
(2, 4),
(3, 4),
(5, 1),
(5, 2),
(7, 1),
(8, 1),
(31, 15),
(33, 15),
(34, 15),
(39, 15),
(40, 15),
(3, 1),
(24, 8),
(22, 8);

INSERT INTO `rsomembers` (`UserID`, `RSOID`) VALUES
(1, 2),
(2, 2),
(2, 5),
(3, 5),
(5, 4),
(7, 12),
(8, 12),
(24, 14),
(31, 14),
(33, 14),
(34, 13),
(39, 12),
(40, 11);


INSERT INTO `admin` (`UserID`, `RSOID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(11, 6),
(12, 7),
(13, 8),
(14, 9),
(15, 10),
(21, 11),
(22, 12),
(25, 13),
(27, 14),
(29, 15);




INSERT INTO `locations` (`LocationID`, `Place`, `Latitude`, `Longitude`)
VALUES (1, '4000 Central Florida Blvd, Orlando, FL 32816', 28.6024, -81.2001),
       (2, '12777 Gemini Blvd N, Orlando, FL 32816', 28.5960, -81.1918),
       (3, '5000 Colbourn Hall, Orlando, FL 32816', 28.6053, -81.1970),
       (4, '4110 Libra Dr, Orlando, FL 32816', 28.6017, -81.1944),
       (5, '12800 Pegasus Dr, Orlando, FL 32816', 28.6072, -81.1962),
       (6, '104 N Woodward Ave, Tallahassee, FL 32304', 30.4429, -84.2985),
       (7, '75 N Woodward Ave, Tallahassee, FL 32304', 30.4447, -84.2990),
       (8, '644 W Call St, Tallahassee, FL 32304', 30.4422, -84.2950),
       (9, '100 S Woodward Ave, Tallahassee, FL 32304', 30.4419, -84.2909),
       (10, '110 S Woodward Ave, Tallahassee, FL 32304', 30.4408, -84.2917),
       (11, '1515 Museum Rd, Gainesville, FL 32611', 29.6474, -82.3464),
       (12, '1558 Union Rd, Gainesville, FL 32611', 29.6475, -82.3495),
       (13, '1290 Newell Dr, Gainesville, FL 32611', 29.6402, -82.3416),
       (14, '1523 Union Rd, Gainesville, FL 32611', 29.6436, -82.3478),
       (15, '1370 Inner Rd, Gainesville, FL 32611', 29.6430, -82.3420);

-- Events
INSERT INTO `events` (`EventID`, `Name`, `Category`, `Description`, `Time`, `Date`, `LocationID`, `ContactPhone`,
                      `ContactEmail`, `EventType`, `RSOID`, `UniversityID`, `Approved`)
VALUES (1, 'UCF Coding Club Hackathon', 'Technology', 'A 24-hour coding competition.', '10:00:00', '2022-11-05', 1,
        '555-1234', 'ucfcc@example.com', 'RSO', 1, 1, 1),
       (2, 'UCF Robotics Society Workshop', 'Technology', 'A workshop on building robots.', '14:00:00', '2022-11-12', 2,
        '555-2345', 'ucfrobotics@example.com', 'RSO', 2, 1, 1),
       (3, 'UCF Chess Club Tournament', 'Games', 'A friendly chess tournament.', '13:00:00', '2022-11-19', 3,
        '555-3456', 'ucfchess@example.com', 'RSO', 3, 1, 1),
       (4, 'UCF Environmental Club Cleanup', 'Environment', 'A campus cleanup event.', '09:00:00', '2022-11-26', 4,
        '555-4567', 'ucfenv@example.com', 'RSO', 4, 1, 1),
       (5, 'FSU Coding Club Hackathon', 'Technology', 'A 24-hour coding competition.', '10:00:00', '2022-11-05', 6,
        '555-5678', 'fsucc@example.com', 'RSO', 6, 2, 1),
       (6, 'FSU Robotics Society Workshop', 'Technology', 'A workshop on building robots.', '14:00:00', '2022-11-12', 7,
        '555-6789', 'fsurobotics@example.com', 'RSO', 7, 2, 1),
       (7, 'FSU Chess Club Tournament', 'Games', 'A friendly chess tournament.', '13:00:00', '2022-11-19', 8,
        '555-7890', 'fsuchess@example.com', 'RSO', 8, 2, 1),
       (8, 'FSU Environmental Club Cleanup', 'Environment', 'A campus cleanup event.', '09:00:00', '2022-11-26', 9,
        '555-8901', 'fsuenv@example.com', 'RSO', 9, 2, 1),
       (9, 'UF Coding Club Hackathon', 'Technology', 'A 24-hour coding competition.', '10:00:00', '2022-11-05', 11,
        '555-9012', 'ufcc@example.com', 'RSO', 11, 3, 1),
       (10, 'UF Robotics Society Workshop', 'Technology', 'A workshop on building robots.', '14:00:00', '2022-11-12',
        12, '555-0123', 'ufrobotics@example.com', 'RSO', 12, 3, 1),
       (11, 'UF Chess Club Tournament', 'Games', 'A friendly chess tournament.', '13:00:00', '2022-11-19', 13,
        '555-1230', 'ufchess@example.com', 'RSO', 13, 3, 1),
       (12, 'UF Environmental Club Cleanup', 'Environment', 'A campus cleanup event.', '09:00:00', '2022-11-26', 14,
        '555-2340', 'ufenv@example.com', 'RSO', 14, 3, 1);


-- Comments
INSERT INTO `comments` (`CommentID`, `UserID`, `EventID`, `Context`, `Timestamp`, `Rating`)
VALUES (1, 1, 1, 'Great event! Learned a lot.', '2022-11-05 20:00:00', 5),
       (2, 2, 1, 'Had an amazing time!', '2022-11-05 21:00:00', 4),
       (3, 3, 2, 'The workshop was very informative.', '2022-11-12 17:00:00', 4),
       (4, 4, 2, 'Loved the hands-on experience.', '2022-11-12 18:00:00', 2),
       (5, 5, 3, 'Fun tournament!', '2022-11-19 16:00:00', 4),
       (6, 6, 3, 'Great atmosphere and friendly competition.', '2022-11-19 17:00:00', 4),
       (7, 12, 5, 'Amazing hackathon!', '2022-11-05 22:00:00', 1),
       (8, 13, 5, 'Met some talented people!', '2022-11-05 23:00:00', 4),
       (9, 14, 6, 'The workshop was very insightful.', '2022-11-12 18:30:00', 2),
       (10, 15, 6, 'Great hands-on experience with robots!', '2022-11-12 19:00:00', 4),
       (11, 16, 7, 'Fun and exciting chess games!', '2022-11-19 16:30:00',2),
       (12, 17, 7, 'Friendly competition and great atmosphere.', '2022-11-19 17:30:00',5),
       (13, 20, 9, 'The hackathon was a great learning experience!', '2022-11-05 20:30:00', 3),
       (14, 29, 9, 'Met some amazing coders!', '2022-11-05 21:30:00', 2),
       (15, 31, 10, 'The robotics workshop was fantastic!', '2022-11-12 17:30:00', 4),
       (16, 32, 10, 'Loved building robots!', '2022-11-12 18:30:00', 1),
       (17, 36, 11, 'The chess tournament was so much fun!', '2022-11-19 16:45:00', 4),
       (18, 37, 11, 'Great people and amazing competition.', '2022-11-19 17:45:00', 4);
