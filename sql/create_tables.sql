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
  musician_id INTEGER REFERENCES Musician(id) ON DELETE CASCADE,
  title varchar(100) NOT NULL,
  url varchar(100) NOT NULL,
  description varchar(200) NOT NULL
);

CREATE TABLE Feedback(
  id SERIAL PRIMARY KEY,
  musician_id INTEGER REFERENCES Musician(id) ON DELETE CASCADE,
  track_id INTEGER REFERENCES Track(id) ON DELETE CASCADE,
  summary varchar(150),
  description varchar(1000)
);

CREATE TABLE TrackTag(
  track_id INTEGER REFERENCES Track(id) ON DELETE CASCADE,
  tag_id INTEGER REFERENCES Tag(id) ON DELETE CASCADE,
  PRIMARY KEY (track_id, tag_id)
);
