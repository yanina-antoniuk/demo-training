<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\UserAgent;
use Symfony\Component\Finder\Finder;

class UserAgentInfoVisitLogger
{
    /**
     * @var string
     */
    private $userFileDir;

    /**
     * @var string
     */
    private $userFileName;

    /**
     * @var Finder
     */
    private $finder;

    public function __construct(
        string $userFileDir,
        string $userFileName,
        Finder $finder
    ) {
        $this->userFileDir = $userFileDir;
        $this->userFileName = $userFileName;
        $this->finder = $finder;
    }

    public function writeUserAgentInfo(UserAgent $agent): void
    {
        $files = $this->finder->in($this->userFileDir);

        foreach ($files as $file) {
            if ($file->getFilename() === $this->userFileName) {
                $openedFile = $file->openFile('r+w');
                $openedFile->fwrite($file->getContents().'UserAgent with data: '
                    .$agent->getWriteInfo().' visited on '.time()."\n");
                $file->setFileClass();
            }
        }
    }
}
