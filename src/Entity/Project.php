<?php

declare(strict_types=1);

namespace PhpInvest\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Project
{
    private string $host;
    private UuidInterface $id;
    private string $name;
    private string $organizationName;
    private string $repositoryName;
    private Collection $gitRevisions;


    public function __construct(string $host, string $name, string $organizationName, string $repositoryName)
    {
        $this->id = Uuid::uuid4();
        $this->host = $host;
        $this->name = $name;
        $this->organizationName = $organizationName;
        $this->repositoryName = $repositoryName;
        $this->gitRevisions = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOrganizationName(): string
    {
        return $this->organizationName;
    }

    public function getRepositoryName(): string
    {
        return $this->repositoryName;
    }

    public function getSsh(): string
    {
        return sprintf('git@%s:%s/%s', $this->host, $this->organizationName, $this->repositoryName);
    }

    public function getUrl(): string
    {
        return sprintf('https://%s/%s/%s', $this->host, $this->organizationName, $this->repositoryName);
    }
}
