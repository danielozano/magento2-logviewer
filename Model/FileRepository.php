<?php
/**
 * @copyright Copyright © 2019 Daniel Lozano. All rights reserved.
 * @author    dn.lozano.m@gmail.com
 */

namespace Danielozano\LogViewer\Model;

use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\DataObject;
use Magento\Framework\DataObjectFactory;
use Magento\Framework\Encryption\Encryptor;

class FileRepository
{
    /**
     * @var DataObjectFactory
     */
    private $dataObjectFactory;

    /**
     * @var FileFactory
     */
    private $fileFactory;

    /**
     * @var Encryptor
     */
    private $encryptor;

    /**
     * @var DataObject
     */
    private $file;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    protected $fileDriver;

    /**
     * FileRepository constructor.
     * @param DataObjectFactory $dataObjectFactory
     * @param FileFactory $fileFactory
     * @param Encryptor $encryptor
     * @param File $fileDriver
     */
    public function __construct(
        DataObjectFactory $dataObjectFactory,
        FileFactory $fileFactory,
        Encryptor $encryptor,
        File $fileDriver
    ) {
        $this->dataObjectFactory = $dataObjectFactory;
        $this->encryptor = $encryptor;
        $this->fileDriver = $fileDriver;
        $this->fileFactory = $fileFactory;
    }

    /**
     * @param string $encryptedPath
     * @return DataObject
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getByEncryptedPath($encryptedPath)
    {
        $filePath = $this->encryptor->decrypt($encryptedPath);

        return $this->getByPath($filePath);
    }

    /**
     * @param string $path
     * @return DataObject
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getByPath($path)
    {
        if (!$this->file) {
            if ($this->fileDriver->isExists($path)) {
                $this->file = $this->fileFactory->create([
                    'data' => [
                        'filename'      => $path,
                        'basename'      => basename($path)
                    ]
                ]);
            }
        }

        return $this->file;
    }
}
