<?php
declare(strict_types=1);

namespace AMB\Entity\Shipping;

use MyCLabs\Enum\Enum;

/**
 * @method static RecurrenceType DAILY()
 * @method static RecurrenceType DOES_NOT_REPEAT()
 * @method static RecurrenceType FIRST_WEEKDAY_OF_MONTH()
 * @method static RecurrenceType INTERMITTENT()
 * @method static RecurrenceType LAST_WEEKDAY_OF_MONTH()
 * @method static RecurrenceType MONTHLY()
 * @method static RecurrenceType WEEKLY()
 */
final class RecurrenceType extends Enum
{
    const DAILY = 'daily';
    const DOES_NOT_REPEAT = 'does_not_repeat';
    const FIRST_WEEKDAY_OF_MONTH = 'first_weekday_of_month';
    const INTERMITTENT = 'intermittent';
    const LAST_WEEKDAY_OF_MONTH = 'last_weekday_of_month';
    const MONTHLY = 'monthly';
    const WEEKLY = 'weekly';
}
