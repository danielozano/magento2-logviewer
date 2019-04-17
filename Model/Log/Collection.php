<?php
/**
 * @copyright Copyright © 2019 Daniel Lozano. All rights reserved.
 * @author    dn.lozano.m@gmail.com
 */

namespace Danielozano\LogViewer\Model\Log;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Data\Collection\EntityFactoryInterface;

class Collection extends \Magento\Framework\Data\Collection\Filesystem
{
    /**
     * @var string
     */
    protected $_itemObjectClass = \Danielozano\LogViewer\Model\File::class;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    /**
     * @var \Magento\Framework\Encryption\Encryptor
     */
    protected $encrypt;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    protected $fileDriver;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $dateTime;

    /**
     * Collection constructor.
     * @param EntityFactoryInterface $entityFactory
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Encryption\Encryptor $encrypt
     * @param \Magento\Framework\Filesystem\Driver\File $fileDriver
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     * @throws \Exception
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Encryption\Encryptor $encrypt,
        \Magento\Framework\Filesystem\Driver\File $fileDriver,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
    ) {
        $this->filesystem = $filesystem;
        $this->encrypt = $encrypt;
        $this->fileDriver = $fileDriver;
        $this->dateTime = $dateTime;
        parent::__construct($entityFactory);
        $logDir = $this->filesystem->getDirectoryRead(DirectoryList::LOG);
        $this->addTargetDir(
            $logDir->getAbsolutePath()
        )->setDirsFirst(true);
    }

    /**
     * @param string $filename
     * @return array
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    protected function _generateRow($filename)
    {
        /** @var array $row */
        $row = parent::_generateRow($filename);
        /** @var array $fileData */
        $fileData = $this->fileDriver->stat($filename);

        $row['encoded_filename'] = $this->encrypt->encrypt($filename);
        $row['size'] = number_format(($fileData['size'] / (1024 * 2)), 2, '.', '');
        $row['modification_date'] = $this->dateTime->gmtDate(null, $fileData['mtime']);

        return $row;
    }
}
