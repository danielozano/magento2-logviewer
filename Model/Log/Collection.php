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
     * @var \Magento\Framework\Encryption\Encryptor
     */
    protected $encrypt;

    /**
     * Collection constructor.
     * @param EntityFactoryInterface $entityFactory
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Encryption\Encryptor $encrypt
     * @throws \Exception
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Encryption\Encryptor $encrypt
    ) {
        parent::__construct($entityFactory);
        $this->filesystem = $filesystem;
        $this->encrypt = $encrypt;
        $logDir = $this->filesystem->getDirectoryRead(DirectoryList::LOG);
        $this->addTargetDir(
            $logDir->getAbsolutePath()
        )->setDirsFirst(true);
    }

    /**
     * @param string $filename
     * @return array
     */
    protected function _generateRow($filename)
    {
        /** @var array $row */
        $row = parent::_generateRow($filename);
        $row['encoded_filename'] = $this->encrypt->encrypt($filename);
        return $row;
    }
}
