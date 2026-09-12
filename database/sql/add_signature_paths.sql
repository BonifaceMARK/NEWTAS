-- Run in SQLyog after selecting the ASI-INVENTORY database.

ALTER TABLE tbl_gatepasses
    ADD COLUMN signature_path VARCHAR(255) NULL AFTER status;

ALTER TABLE tbl_asset_transfers
    ADD COLUMN signature_path VARCHAR(255) NULL AFTER status;

-- Run once in the Laravel project after the database change if storage is not linked:
-- php artisan storage:link