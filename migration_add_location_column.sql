-- Run this ONLY if you already created the database from the old SQL file
-- and don't want to drop your existing data.
-- (If you're importing register_event_system.sql fresh, skip this file.)

ALTER TABLE `Events` ADD COLUMN `Location` VARCHAR(255) DEFAULT NULL AFTER `Date`;

-- Optional: backfill Location from the Locations table via LocationID,
-- if your existing rows have LocationID set.
UPDATE `Events` e
JOIN `Locations` l ON e.LocationID = l.LocationID
SET e.Location = l.LocationName
WHERE e.Location IS NULL;
