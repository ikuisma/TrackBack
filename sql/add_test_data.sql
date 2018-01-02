-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Musician (username, password) VALUES ('qsma', 'qsmapassword');
INSERT INTO Musician (username, password) VALUES ('pekka', 'pekkapassword');
INSERT INTO Tag (name) VALUES ('electronic');
INSERT INTO Tag (name) VALUES ('instrumental');
INSERT INTO Track (musician_id, title, url, description) VALUES (1, 'Clementine', 'https://soundcloud.com/qsma/clementine', 'Short track that I wrote for a cat called Clementine. ');
INSERT INTO TrackTag (track_id, tag_id) VALUES (1, 1);
INSERT INTO TrackTag (track_id, tag_id) VALUES (1, 2);
INSERT INTO Feedback (musician_id, track_id, summary, description) VALUES (2, 1, 'This track sucks. ', 'My ears are bleeding. This sounds horrendous!');