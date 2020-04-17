<?php

declare(strict_types=1);

namespace PhpInvest\Service\Project;

use PhpInvest\Entity\Project;
use PhpInvest\Invest\Collection\ProjectCollection;
use PhpInvest\Repository\ProjectRepository;

final class ProjectService
{
    private ProjectRepository $repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): ProjectCollection
    {
        return new ProjectCollection(...$this->repository->findAll()->toArray());
    }

    public function getByName(string $name): ?Project
    {
        return $this->repository->findByName($name);
    }
}
