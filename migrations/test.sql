CREATE TABLE `test` (
  id        INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(30) NOT NULL,
  lastname  VARCHAR(30) NOT NULL,
  email     VARCHAR(50),
  reg_date  TIMESTAMP
)