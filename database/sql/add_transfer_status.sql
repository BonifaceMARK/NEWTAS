-- Run in SQLyog against the ASI-INVENTORY database.
-- Existing records become Ongoing; new records default to Ongoing.

ALTER TABLE tbl_asset_transfers
    ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'Ongoing' AFTER asset_type;

ALTER TABLE tbl_gatepasses
    ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'Ongoing' AFTER description;

UPDATE tbl_asset_transfers
SET status = 'Ongoing'
WHERE status IS NULL OR status = '';

UPDATE tbl_gatepasses
SET status = 'Ongoing'
WHERE status IS NULL OR status = '';

-- Allowed application values:
-- Ongoing, Completed, Cancelled