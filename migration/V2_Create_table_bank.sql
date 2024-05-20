CREATE TABLE IF NOT EXISTS account_banks
(
    id             INT AUTO_INCREMENT PRIMARY KEY,
    account_number VARCHAR(30) NOT NULL,
    user_cpf       CHAR(11)    NOT NULL,
    balance        REAL,
    FOREIGN KEY (user_cpf) REFERENCES users (cpf)
);
