CREATE TABLE Musician (
  id SERIAL PRIMARY KEY,
  username varchar(200) NOT NULL,
  password varchar(255) NOT NULL
);

CREATE TABLE Tag(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL UNIQUE
);

CREATE TABLE Track(
  id SERIAL PRIMARY KEY,
  musician_id INTEGER REFERENCES Musician(id),
  title varchar(100) NOT NULL,
  url varchar(100) NOT NULL,
  description varchar(200) NOT NULL
);

CREATE TABLE Feedback(
  id SERIAL PRIMARY KEY,
  musician_id INTEGER REFERENCES Musician(id),
  track_id INTEGER REFERENCES Track(id),
  summary varchar(150),
  description varchar(1000)
);

CREATE TABLE TrackTag(
  track_id INTEGER REFERENCES Track(id),
  tag_id INTEGER REFERENCES Tag(id),
  PRIMARY KEY (track_id, tag_id)
);
