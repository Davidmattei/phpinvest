<?php

declare(strict_types=1);

namespace PhpInvest\Service\Git;

use PhpInvest\Entity\Project;
use PhpInvest\Exception\Git\AlreadyExistsException;
use PhpInvest\Exception\Git\CheckoutNotFoundException;
use PhpInvest\Invest\Git\Checkout;
use PhpInvest\Process\ComposerProcess;
use PhpInvest\Process\Git\CheckoutProcess;
use PhpInvest\Process\Git\CloneProcess;
use PhpInvest\Process\Git\PullProcess;
use Symfony\Component\Filesystem\Filesystem;

final class GitService
{
    private Filesystem $filesystem;
    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->filesystem = new Filesystem();
        $this->projectDir = $projectDir;
    }

    public function checkout(Checkout $checkout, string $branch): void
    {
        $directory = $checkout->getDirectory();

        CheckoutProcess::init($branch, $directory)->run();
        PullProcess::init($directory)->run();
        ComposerProcess::update($directory)->run();
    }

    public function clone(string $branch, Project $project): void
    {
        $directory = $this->getDirectory($project);

        if ($this->filesystem->exists($directory)) {
            throw new AlreadyExistsException($this->getCheckout($project), $project);
        }

        CloneProcess::init($branch, $directory, $project)->run();
        ComposerProcess::install($directory)->run();
    }

    public function getCheckout(Project $project): Checkout
    {
        $directory = $this->getDirectory($project);

        if (!$this->filesystem->exists($directory)) {
            throw new CheckoutNotFoundException($directory, $project);
        }

        return CheckoutFactory::create($directory);
    }

    private function getDirectory(Project $project): ?string
    {
        return sprintf('%s/checkout/%s', $this->projectDir, $project->getName());
    }
}
