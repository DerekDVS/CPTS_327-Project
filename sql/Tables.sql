CREATE TABLE Users (
    username VARCHAR(255) NOT NULL UNIQUE,
    user_password VARCHAR(255) NOT NULL,
    firstName VARCHAR(255),
    lastName VARCHAR(255),
    PRIMARY KEY (user_password, username)
);

CREATE TABLE Post (
    username VARCHAR(255) NOT NULL,
    timeframe VARCHAR(20) UNIQUE NOT NULL,
    title VARCHAR(255),
    post_desc VARCHAR(255),
    PRIMARY KEY (username, timeframe),
    FOREIGN KEY (username) REFERENCES Users(username)
);

CREATE TABLE COMMENT(
    -- post identifier
    post_username VARCHAR(255) NOT NULL,
    post_timeframe VARCHAR(20) NOT NULL,
    -- comment references
    comment_reply_username VARCHAR(255),
    comment_reply_timeframe VARCHAR(20),
    -- comment centric
    comment_username VARCHAR(255) NOT NULL,
    comment_timeframe VARCHAR(20) NOT NULL,
    post_desc VARCHAR(255),
    PRIMARY KEY(
        post_username,
        post_timeframe,
        comment_username,
        comment_timeframe
    ),
    FOREIGN KEY(post_username, post_timeframe) REFERENCES post(username, timeframe),
    FOREIGN KEY(comment_username) REFERENCES users(username) 
    
);