<?php

namespace Danielozano\LogViewer\ViewModel\Adminhtml;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class LogList implements ArgumentInterface
{
    protected $logCollection;

    public function __construct(
        \Danielozano\LogViewer\Model\Log\Collection $logCollection
    ) {
        $this->logCollection = $logCollection;
    }
}
