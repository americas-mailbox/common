<?php
declare(strict_types=1);

namespace AMB\Interactor\Parcel;

final class ParcelSQL
{
    public function __invoke(): string
    {
        return <<<SQL
SELECT
    parcels.id as parcel_id, parcels.entered_on AS parcel_entered_on, 
    parcels.barcode as parcel_barcode,
    administrators.first_name AS parcel_entered_by_first_name, 
    administrators.last_name AS parcel_entered_by_last_name,
    members.pmb AS member_pmb, members.first_name as member_first_name, 
    members.middle_name as member_middle_name, members.last_name as member_last_name, 
    members.suffix as member_suffix,
    parcels.back_image_file AS parcel_back_image_file,
    parcels.front_image_file AS parcel_front_image_file,
    rates_and_plans.group AS plan_group
FROM parcels
    LEFT JOIN members ON parcels.member_id = members.member_id
    LEFT JOIN amb_api.rates_and_plans ON members.level_id = rates_and_plans.id
    LEFT JOIN administrators on parcels.entered_by_id = administrators.id

SQL;
    }
}
