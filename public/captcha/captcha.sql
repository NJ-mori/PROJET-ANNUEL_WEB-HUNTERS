DROP TABLE IF EXISTS captcha_images;

CREATE TABLE captcha_images (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    filename   VARCHAR(255) NOT NULL,
    image_data MEDIUMBLOB,
    mime_type  VARCHAR(50),
    active     BOOLEAN DEFAULT TRUE,
    completed  INT DEFAULT 0,
    reseted    INT DEFAULT 0,
    failed     INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);