<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddInternalLabelsToDeliveryMethods extends AbstractMigration
{
    public function change(): void
    {
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'Best Method')
            ->set('internal_short_label', 'BM')
            ->where(['id' => 5])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'Best Method - International')
            ->set('internal_short_label', 'BMI')
            ->where(['id' => 6])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'Customer Pick Up')
            ->set('internal_short_label', 'CP')
            ->where(['id' => 7])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'FedEx 2nd Day Air')
            ->set('internal_short_label', 'FX 2ND')
            ->where(['id' => 8])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'FedEx 3rd Day Air')
            ->set('internal_short_label', 'FX 3RD')
            ->where(['id' => 9])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'FedEx Ground')
            ->set('internal_short_label', 'FX GND')
            ->where(['id' => 10])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'FedEx International')
            ->set('internal_short_label', 'FXI')
            ->where(['id' => 11])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'FedEx Overnight')
            ->set('internal_short_label', 'FX ON')
            ->where(['id' => 12])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'USPS Express')
            ->set('internal_short_label', 'X')
            ->where(['id' => 14])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'USPS First Class')
            ->set('internal_short_label', 'FC')
            ->where(['id' => 15])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'USPS International')
            ->set('internal_short_label', 'USPSI')
            ->where(['id' => 16])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'USPS Priority')
            ->set('internal_short_label', 'P')
            ->where(['id' => 17])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('label', 'Saturday Delivery')
            ->set('internal_label', 'FedEx Saturday Delivery')
            ->set('internal_short_label', 'FX SAT')
            ->where(['id' => 18])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'UPS Ground')
            ->set('internal_short_label', 'UPS GND')
            ->where(['id' => 20])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'UPS Next Day Air')
            ->set('internal_short_label', 'UPS NEXT')
            ->where(['id' => 21])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'UPS 2nd Day Air')
            ->set('internal_short_label', 'UPS 2ND')
            ->where(['id' => 22])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'UPS 3 Day Select')
            ->set('internal_short_label', 'UPS 3DAY')
            ->where(['id' => 23])
            ->execute();
    }
}
