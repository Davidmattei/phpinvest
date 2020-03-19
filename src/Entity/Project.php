<?php

declare(strict_types=1);

namespace PhpInvest\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Project
{
    private UuidInterface $id;
    private string $host;
    private string $organizationName;
    private string $repositoryName;

    public function __construct(string $host, string $organizationName, string $repositoryName)
    {
        $this->id = Uuid::uuid4();
        $this->host = $host;
        $this->organizationName = $organizationName;
        $this->repositoryName = $repositoryName;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return sprintf('%s/%s', $this->organizationName, $this->repositoryName);
    }

    public function getOrganizationName(): string
    {
        return $this->organizationName;
    }

    public function getRepositoryName(): string
    {
        return $this->repositoryName;
    }

    public function getSSH(): string
    {
        return sprintf('git@%s:%s/%s', $this->host, $this->organizationName, $this->repositoryName);
    }

    public function getURL(): string
    {
        return sprintf('https://%s/%s/%s', $this->host, $this->organizationName, $this->repositoryName);
    }
}
