-- // Label group relation table
-- Migration SQL that makes the change goes here.
CREATE TABLE groups_labels (
  id          INT(6)        UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  groups_id   INT(6)        NULL DEFAULT NULL,
  labels_id   INT(6)        NULL DEFAULT NULL,
  created_at  TIMESTAMP     NULL DEFAULT NULL,
  updated_at  TIMESTAMP     NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- @UNDO
-- SQL to undo the change goes here.
DROP TABLE groups_labels;
