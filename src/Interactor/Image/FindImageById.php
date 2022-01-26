<?php
declare(strict_types=1);

namespace AMB\Interactor\Image;

use AMB\Entity\Image;
use AMB\Interactor\RapidCityTime;
use Doctrine\DBAL\Connection;

final class FindImageById
{
    public function __construct(
        private Connection $connection,
    ) {}

    public function find($id): ?Image
    {
        $data = $this->connection->fetchAssociative("SELECT * FROM images WHERE id = '{$id}'");
        $updatedAt = $data['updated_at'] ? new RapidCityTime($data['updated_at']) : null;

        return (new Image())
            ->setCreatedAt(new RapidCityTime($data['created_at']))
            ->setFilePath($data['filepath'])
            ->setId($id)
            ->setUpdatedAt($updatedAt);
    }
}
