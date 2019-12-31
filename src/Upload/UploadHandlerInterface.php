<?php

/**
 * @see       https://github.com/laminas/laminas-progressbar for the canonical source repository
 * @copyright https://github.com/laminas/laminas-progressbar/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-progressbar/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ProgressBar\Upload;

use Laminas\Stdlib\ArrayUtils;
use Traversable;

/**
 * Interface for Upload Progress Handlers
 */
interface UploadHandlerInterface
{
    /**
     * @param  string $id
     * @return array
     */
    public function getProgress($id);
}
