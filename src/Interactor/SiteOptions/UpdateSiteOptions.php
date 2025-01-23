<?php
declare(strict_types=1);

namespace AMB\Interactor\SiteOptions;

use AMB\Factory\DbalConnection;
use AMB\Interactor\DbalConnectionTrait;
use AMB\Interactor\RapidCityTime;
use Exception;
use OLPS\Money\NumberToJson;

final class UpdateSiteOptions implements DbalConnection
{
    use DbalConnectionTrait;

    public function update($siteOptions): bool
    {
        if (is_array($siteOptions)) {
            $siteOptions = $this->prepareSiteOptions($siteOptions);
        } else {
            $siteOptions = $siteOptions->toArray();
        }
        $this->handleShippingProcessingTimes($siteOptions);

        $data = json_encode($siteOptions);

        try {
            $this->connection->executeQuery("UPDATE site_options SET data = '$data'");

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function handleShippingProcessingTimes(array $siteOptions)
    {
        $data = $this->connection->fetchColumn('SELECT data FROM site_options');
        $currentOptions = json_decode($data, true);

        if ($currentOptions['staffDailyEmailTime'] !== $siteOptions['staffDailyEmailTime']) {
 //           $this->setProcessShipmentsCronJob($siteOptions['staffDailyEmailTime']);
        }
    }

    private function prepareSiteOptions(array $siteOptions): array
    {
        if (isset($siteOptions['autoRenewalNotificationDays'])) {
            $siteOptions['autoRenewalNotificationDays'] = $this->prepareArrayData($siteOptions['autoRenewalNotificationDays']);
        }
        if (isset($siteOptions['bccEmailAddresses'])) {
            $siteOptions['bccEmailAddresses'] = $this->prepareArrayData($siteOptions['bccEmailAddresses']);
        }
        if (isset($siteOptions['convenienceBaseFee'])) {
            $siteOptions['convenienceBaseFee'] = $this->prepareMoney($siteOptions['convenienceBaseFee']);
        }
        if (isset($siteOptions['criticalBalanceAmount'])) {
            $siteOptions['criticalBalanceAmount'] = $this->prepareMoney($siteOptions['criticalBalanceAmount']);
        }
        if (isset($siteOptions['expirationWarningEmailDays'])) {
            $siteOptions['expirationWarningEmailDays'] = $this->prepareArrayData($siteOptions['expirationWarningEmailDays']);
        }
        if (isset($siteOptions['specialAccountPMBs'])) {
            $siteOptions['specialAccountPMBs'] = $this->prepareArrayData($siteOptions['specialAccountPMBs']);
        }
        if (isset($siteOptions['staffNotificationRecipients'])) {
            $siteOptions['staffNotificationRecipients'] = $this->prepareArrayData($siteOptions['staffNotificationRecipients']);
        }
        if (isset($siteOptions['systemFailureNotificationRecipients'])) {
            $siteOptions['systemFailureNotificationRecipients'] = $this->prepareArrayData($siteOptions['systemFailureNotificationRecipients']);
        }
        if (isset($siteOptions['topUpAmount'])) {
            $siteOptions['topUpAmount'] = $this->prepareMoney($siteOptions['topUpAmount']);
        }
        if (isset($siteOptions['vehicleWarningEmailDays'])) {
            $siteOptions['vehicleWarningEmailDays'] = $this->prepareArrayData($siteOptions['vehicleWarningEmailDays']);
        }
        $data = $this->connection->fetchColumn("SELECT data FROM site_options");

        return array_merge(json_decode($data, true), $siteOptions);
    }

    private function prepareMoney($amount): array
    {
        return json_decode((new NumberToJson())($amount), true);
    }

    private function prepareArrayData($incomingData): array
    {
        $data = [];
        $parts = explode(',', $incomingData);
        foreach ($parts as $datum) {
            $data[] = trim($datum);
        }

        return $data;
    }

    private function setProcessShipmentsCronJob($time)
    {
        $filename = '/etc/cron.d/processTodaysShipments';

        $res= unlink($filename);

        $time = new RapidCityTime($time);

        $cronTime = "{$time->minute} {$time->hour} * * *";

        $task = '/usr/bin/php ' . realpath(__DIR__ . '/../../../tasks') . ' process-todays-shipments';

        $fileContent = "$cronTime $task";

       $res = file_put_contents($filename, $fileContent);
    }
}
