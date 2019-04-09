<?php

namespace Danielozano\LogViewer\Model\Log;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Data\Collection\EntityFactoryInterface;

class Collection extends \Magento\Framework\Data\Collection\Filesystem
{
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    /**
     * Collection constructor.
     * @param EntityFactoryInterface $entityFactory
     * @param \Magento\Framework\Filesystem $filesystem
     * @throws \Exception
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        \Magento\Framework\Filesystem $filesystem
    ) {
        parent::__construct($entityFactory);
        $this->filesystem = $filesystem;
        $logDir = $this->filesystem->getDirectoryRead(DirectoryList::LOG);
        $this->addTargetDir(
            $logDir->getAbsolutePath()
        )->setDirsFirst(true);
    }

    public function addFieldToSelect($field, $alias = null)
    {
        return $this;
    }
}
