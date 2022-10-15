CREATE TABLE Users (
    username VARCHAR NOT NULL UNIQUE,
    user_password VARCHAR NOT NULL,
    firstName VARCHAR,
    lastName VARCHAR,
    PRIMARY KEY (user_password, username)
);

CREATE TABLE Post (
    username VARCHAR,
    timeframe TIMESTAMP,
    title VARCHAR,
    post_desc VARCHAR,
    PRIMARY KEY (username, timeframe),
    FOREIGN KEY (username) REFERENCES Users(username)
);

CREATE TABLE Comment (
    username VARCHAR,
    timeframe TIMESTAMP,
    post_desc VARCHAR,
    PRIMARY KEY (username, timeframe),
    FOREIGN KEY (username) REFERENCES Users(username)
);