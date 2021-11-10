<?php

namespace App\Service;

use App\Entity\UserAgent;
use Symfony\Component\Finder\Finder;

class UserAgentInfoHandler
{
    /**
     * @var string
     */
    private $productsFileDir;

    /**
     * @var string
     */
    private $userFileName;

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @param string $productsFileDir
     * @param string $userFileName
     * @param Finder $finder
     */
    public function __construct(
        string $productsFileDir,
        string $userFileName,
        Finder $finder
    ) {
        $this->productsFileDir = $productsFileDir;
        $this->userFileName = $userFileName;
        $this->finder = $finder;
    }

    /**
     * @param UserAgent $agent
     */
    public function writeUserAgentInfo(UserAgent $agent): void
    {
        $files = $this->finder->in($this->productsFileDir);

        foreach ($files as $file) {

            if ($file->getFilename() == $this->userFileName) {
                $openedFile = $file->openFile('r+w');
                $openedFile->fwrite($file->getContents() . 'UserAgent with data: '
                    . $agent->getWriteInfo() . ' visited on ' . time() . "\n");
                $file->setFileClass();
            }
        }
    }
}