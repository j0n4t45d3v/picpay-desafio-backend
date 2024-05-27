CREATE TABLE IF NOT EXISTS transference
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    user_issurer CHAR(11) NOT NULL,
    user_destiny CHAR(11) NOT NULL,
    FOREIGN KEY (user_issurer) REFERENCES users (cpf),
    FOREIGN KEY (user_destiny) REFERENCES users (cpf)
);
