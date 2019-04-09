<?php

namespace Danielozano\LogViewer\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;

class LogListingDataProvider extends AbstractDataProvider
{
    protected $collection;

    public function __construct(
        \Danielozano\LogViewer\Model\Log\Collection $collection,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection;
    }

    /**
     * @return array
     */
    function getData()
    {
        return [
            'totalRecords' => $this->collection->getSize(),
            'items' => array_values($this->collection->toArray())
        ];
    }
}