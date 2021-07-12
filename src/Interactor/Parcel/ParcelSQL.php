<?php
declare(strict_types=1);

namespace AMB\Interactor\Parcel;

final class ParcelSQL
{
    public function __invoke(): string
    {
        return <<<SQL
SELECT
{$this->selects()}
FROM parcels
{$this->joins()}
SQL;
    }

    public function joins(): string
    {
        return <<<SQL
    LEFT JOIN members AS parcel_members ON parcels.member_id = parcel_members.member_id
    LEFT JOIN amb_api.rates_and_plans ON parcel_members.level_id = rates_and_plans.id
    LEFT JOIN administrators AS entered_by on parcels.entered_by_id = entered_by.id
    LEFT JOIN administrators AS picked_by on parcels.picked_by_id = picked_by.id
    LEFT JOIN parcel_locations ON parcels.location_id = parcel_locations.id

SQL;
    }

    public function selects(): string
    {
        return <<<SQL
    parcels.id AS parcel_id, 
    parcels.barcode AS parcel_barcode,
    entered_by.first_name AS parcel_entered_by_first_name, 
    entered_by.last_name AS parcel_entered_by_last_name,
    parcels.entered_on AS parcel_entered_on, 
    picked_by.first_name AS parcel_picked_by_first_name, 
    picked_by.last_name AS parcel_picked_by_last_name,
    parcels.picked_on AS parcel_picked_on, 
    parcel_members.pmb AS member_pmb, 
    parcel_members.first_name AS member_first_name, 
    parcel_members.middle_name AS member_middle_name, 
    parcel_members.last_name AS member_last_name, 
    parcel_members.suffix AS member_suffix,
    parcel_members.comment AS member_comments,
    parcel_locations.id AS location_id,
    parcel_locations.label AS location_label,
    parcels.back_image_file AS parcel_back_image_file,
    parcels.front_image_file AS parcel_front_image_file,
    parcels.thumbnail_file AS parcel_thumbnail_file,
    rates_and_plans.group AS plan_group
SQL;

    }
}
