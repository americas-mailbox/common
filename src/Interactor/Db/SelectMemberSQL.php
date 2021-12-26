<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

final class SelectMemberSQL
{
    public function __invoke()
    {
        return <<<COLUMNS
SELECT 
    m.member_id, account_id, active, alt_email, alt_phone, comment, email, level_id,
    first_name, middle_name, last_name, suffix,
    m.renewal_frequency, phone,
    pmb, renewDate, shipinst, startDate, suspended,
    return_to_sender_date,
    alternate_name, pin,
    p.title as planTitle,
    a.auto_renew, 
    a.auto_top_up, 
    a.custom_auto_top_up,
    a.custom_critical_balance,
    a.custom_minimum_allowed_balance,
    a.critical_balance, 
    a.default_card_id, 
    a.minimum_allowed_balance,
    a.office_closed_delivery,
    a.notifications, 
    a.top_up_amount, 
    l.id as ledger_id, 
    l.balance 
FROM members m 
LEFT JOIN accounts a ON m.account_id = a.id 
LEFT JOIN ledgers l ON a.ledger_id = l.id 
LEFT JOIN rates_and_plans p ON m.level_id = p.id 

COLUMNS;
    }
}
