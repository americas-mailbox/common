<?php
declare(strict_types=1);

namespace AMB\Interactor\File;

use Doctrine\DBAL\Connection;
use League\Flysystem\Config;
use League\Flysystem\Visibility;
use Psr\Http\Message\UploadedFileInterface;
use Ramsey\Uuid\Uuid;
use Zestic\Flysystem\Files;

final class UploadScannedImage
{
    public function __construct(
        private Connection $connection,
        private Files $files,
    ) {}

    public function upload(UploadedFileInterface $file, $adminId, string $machineId)
    {
        $this->connection->beginTransaction();

        try {
            $content = $file->getStream()->getContents();
            $imageSize = getimagesizefromstring($content);
            $id = Uuid::uuid4();
            $filePath = "$id.jpg";
            $filename = $this->files->write(
                $filePath,
                $content,
                [Config::OPTION_VISIBILITY => Visibility::PUBLIC]
            );
            $imageData = [
                'file_id'         => $id,
                'filepath'        => $filePath,
                'machine_id'      => $machineId,
                'ratio'           => $imageSize[0] / $imageSize[1],
                'scanned_by_id'   => $adminId,
                'scanned_by_role' => 'admin',
            ];
            $response = $this->connection->insert('scanned_images', $imageData);
            if (1 !== $response) {
                throw new \Exception('There was a problem saving the image');
            }
        } catch (\Exception $e) {
            $this->connection->rollBack();

            throw $e;
        }
        $this->connection->commit();

        return $filePath;
    }
}
