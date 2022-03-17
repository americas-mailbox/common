<?php
declare(strict_types=1);

namespace AMB\Interactor\ShippingEvent;

final class SelectShippingEventSQL
{
    public function __invoke()
    {
        return <<<COLUMNS
SELECT
    e.is_active,
    e.id,
    e.start_date,     
    e.end_date,
    e.recurrence_type,
    e.member_id,
    e.daily,
    e.day_of_the_month,
    e.day_of_the_week,
    e.first_weekday_of_the_month,
    e.last_weekday_of_the_month,
    e.next_weekly,
    e.weeks_between,
    a.id as addressId,
    d.id AS deliveryMethodId,
    d.label AS deliveryMethod,
    d.label AS deliveryMethodLabel,
    d.group AS deliveryGroup,
    d.group AS deliveryMethodGroup,
    dc.active AS deliveryCarrierActive,
    dc.id AS deliveryCarrierId,
    dc.name AS deliveryCarrierName,
    a.addressee,    
    a.address AS address,       
    a.suite AS suite,       
    a.location_name AS locationName,       
    a.in_care_of AS inCareOf,       
    a.city,          
    a.state,         
    a.post_code AS postcode,      
    a.plus4,
    a.country        
FROM shipping_events AS e
LEFT JOIN delivery_methods AS d ON e.delivery_id = d.id
LEFT JOIN delivery_carriers AS dc ON d.company_id = dc.id
LEFT JOIN addresses AS a on e.address_id = a.id

COLUMNS;
    }
}
