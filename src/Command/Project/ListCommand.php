<?php

declare(strict_types=1);

namespace PhpInvest\Command\Project;

use PhpInvest\Entity\Project;
use PhpInvest\Service\GitService;
use PhpInvest\Service\ProjectService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ListCommand extends Command
{
    public const NAME = 'pi:project:list';
    private GitService $gitService;
    private ProjectService $projectService;

    public function __construct(GitService $gitService, ProjectService $gitProjectService)
    {
        parent::__construct(self::NAME);

        $this->gitService = $gitService;
        $this->projectService = $gitProjectService;
    }

    protected function configure(): void
    {
        $this->setDescription('List projects');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('List projects');

        $io->table(
            ['Name', 'Url', 'Branch'],
            $this->projectService->getAll()->map(fn (Project $project) => [
                $project->getName(),
                $project->getUrl(),
                $this->gitService->getBranch($project),
            ])->toArray()
        );

        return 1;
    }
}
