<?php

declare(strict_types=1);

namespace PhpInvest\Service\Analyzer;

use PhpInvest\Entity\Project;
//use PhpInvest\Process\PhpStan\AnalyseProcess;
use PhpInvest\Service\File\FileService;
use PhpInvest\Service\Git\GitService;

final class PhpStanAnalyzer
{
    private FileService $fileService;
    private GitService $gitService;

    public function __construct(FileService $fileService, GitService $gitService)
    {
        $this->fileService = $fileService;
        $this->gitService = $gitService;
    }

    public function analyze(Project $project): void
    {
        $directory = $this->gitService->getDirectory($project);
        $revision = $this->gitService->getRevision($project);

        $this->fileService->scan($directory, $revision);

        //$json = AnalyseProcess::init($directory, 7)->run()->getJson();
    }
}
