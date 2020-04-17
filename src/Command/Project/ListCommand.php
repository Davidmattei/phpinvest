<?php

declare(strict_types=1);

namespace PhpInvest\Command\Project;

use PhpInvest\Command\Command;
use PhpInvest\Entity\Project;
use PhpInvest\Service\Project\ProjectService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ListCommand extends Command
{
    public const NAME = 'pi:project:list';

    private ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        parent::__construct(self::NAME);
        $this->projectService = $projectService;
    }

    protected function configure(): void
    {
        $this->setDescription('List projects');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io->title('List projects');
        $this->io->table(
            ['Name', 'Url', 'Git Branch'],
            $this->projectService->getAll()->map(fn (Project $project) => [$project->getName(), $project->getUrl()])
        );

        return 1;
    }
}
