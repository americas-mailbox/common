<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddHtmlColorToPlansTable extends AbstractMigration
{
    public function change(): void
    {
        $plans = $this->getPlanData();
        foreach ($plans as $id => $plan) {
            $this->getQueryBuilder()
                ->update('plans')
                ->set($plan)
                ->where(['id' => $id])
                ->execute();
        }

    }

    private function getPlanData(): array
    {
        return [
            1 => [
                'html_color' => '#CD7F32',
            ],
            2 => [
                'html_color' => '#C0C0C0',
            ],
            3 => [
                'html_color' => '#FFD700',
            ],
            4 => [
                'html_color' => '#E5E4E2',
            ],
            6 => [
                'html_color' => '#19AFEE',
            ],
        ];
    }
}
