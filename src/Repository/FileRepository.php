<?php

declare(strict_types=1);

namespace PhpInvest\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;
use PhpInvest\Entity\File;
use PhpInvest\Invest\Collection\FileCollection;

final class FileRepository extends ServiceEntityRepository
{
    private Connection $connection;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);

        $this->connection = $this->getEntityManager()->getConnection();
    }

    public function saveCollection(FileCollection $fileCollection): void
    {
        $json = json_encode($fileCollection->map(fn(File $file) => [
            'id' => $file->getId()->jsonSerialize(),
            'c_time' => $file->getCTime()->format(\DATE_ATOM),
            'filename' => $file->getFilename(),
            'relative_path' => $file->getRelativePath(),
            'size' => $file->getSize(),
        ]), JSON_THROW_ON_ERROR, 2);

        $query = <<<QUERY
            INSERT INTO tbl_file
            select * from json_populate_recordset(null::tbl_file, '$json');
QUERY;

        $this->connection->executeQuery($query);
    }
}
