<?php
/**
 * @copyright Copyright © 2019 Daniel Lozano. All rights reserved.
 * @author    dn.lozano.m@gmail.com
 */

namespace Danielozano\LogViewer\Model;

use Magento\Framework\DataObject;

class File extends DataObject
{
    /**
     * To avoid memory peaks use generators when reading
     * large file contents.
     *
     * @return \Generator
     */
    public function getContentGenerator()
    {
        $path = $this->getData('filename');

        if ($path) {
            clearstatcache();
            $handler = fopen($path, 'r');

            while (!feof($handler)) {
                yield trim(fgets($handler));
            }

            fclose($handler);
        }
    }
}
