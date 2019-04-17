<?php
/**
 * @copyright Copyright © 2019 Daniel Lozano. All rights reserved.
 * @author    dn.lozano.m@gmail.com
 */

namespace Danielozano\LogViewer\Controller\Adminhtml\Log;

use Magento\Backend\App\Action;
use Magento\Framework\Encryption\Encryptor;
use \Magento\Framework\App\ResponseInterface;

/**
 * Class Download
 * @package Danielozano\LogViewer\Controller\Adminhtml\Log
 */
class Download extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Danielozano_LogViewer::download';

    /**
     * @var Encryptor
     */
    protected $encrypt;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    protected $fileDriver;

    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $rawResultFactory;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * Download constructor.
     * @param Action\Context $context
     * @param Encryptor $encrypt
     * @param \Magento\Framework\Filesystem\Driver\File $fileDriver
     * @param \Magento\Framework\Controller\Result\RawFactory $rawResultFactory
     * @param \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        Action\Context $context,
        Encryptor $encrypt,
        \Magento\Framework\Filesystem\Driver\File $fileDriver,
        \Magento\Framework\Controller\Result\RawFactory $rawResultFactory,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
    ) {
        $this->encrypt = $encrypt;
        $this->fileDriver = $fileDriver;
        $this->rawResultFactory = $rawResultFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function execute()
    {
        $request = $this->getRequest();
        /** @var string $filePath */
        $filePath = $this->encrypt->decrypt($request->getParam('file'));
        /** @var string|null $basename */
        $basename = $request->getParam('basename', null);

        if ($this->fileDriver->isExists($filePath)) {
            $fileContent = $this->fileDriver->fileGetContents($filePath);
            /** @var \Magento\Framework\Controller\Result\Raw $result */
            $result = $this->rawResultFactory->create();
            $result->setContents($fileContent)
                ->setHeader('Pragma', 'public', true)
                ->setHeader('Content-Length', strlen($fileContent), true)
                ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
                ->setHeader('Content-Type', 'application/octet-stream')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $basename. '"', true);
        } else {
            $result = $this->resultRedirectFactory->create();
            $result->setPath('*/*/index');
        }

        return $result;
    }
}
