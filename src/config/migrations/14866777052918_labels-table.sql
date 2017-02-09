-- // Labels table
-- Migration SQL that makes the change goes here.
CREATE TABLE labels (
  id          INT(6)        UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(30)   NULL DEFAULT NULL,
  hex_color   VARCHAR(30)   NULL DEFAULT NULL,
  created_at  TIMESTAMP     NULL DEFAULT NULL,
  updated_at  TIMESTAMP     NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- @UNDO
-- SQL to undo the change goes here.
DROP TABLE labels;