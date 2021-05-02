<?php
declare(strict_types=1);

namespace AMB\Interactor\Parcel;

final class ParcelSQL
{
    public function __invoke(): string
    {
        return <<<SQL
SELECT
    p.id, p.entered_on AS enteredOn, p.barcode,
    a.first_name AS entered_by_first_name, a.last_name AS entered_by_last_name,
    m.pmb, m.first_name, m.middle_name, m.last_name, m.suffix,
    p.back_image_file AS backImageFile,
    p.front_image_file AS frontImageFile
FROM parcels AS p
    LEFT JOIN members AS m ON p.member_id = m.member_id
    LEFT JOIN administrators AS a on p.entered_by_id = a.id

SQL;
    }
}
