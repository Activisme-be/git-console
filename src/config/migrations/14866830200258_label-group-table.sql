-- // Label group table
-- Migration SQL that makes the change goes here.
CREATE TABLE groups (
  id          INT(6)         UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(255)   NULL DEFAULT NULL,
  description TEXT,
  created_at  TIMESTAMP     NULL DEFAULT NULL,
  updated_at  TIMESTAMP     NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- @UNDO
-- SQL to undo the change goes here.
DROP TABLE groups;
