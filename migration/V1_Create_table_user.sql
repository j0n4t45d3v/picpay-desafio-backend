CREATE TABLE IF NOT EXISTS users
(
    full_name VARCHAR(20),
    email     VARCHAR(100) NOT NULL UNIQUE,
    cpf       CHAR(11)     NOT NULL PRIMARY KEY,
    passw     VARCHAR(20)  NOT NULL,
    type_user ENUM ("COMMON", "LOJISTA")
);
