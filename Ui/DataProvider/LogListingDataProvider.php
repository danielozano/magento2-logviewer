<?php

namespace Danielozano\LogViewer\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;

class LogListingDataProvider extends AbstractDataProvider
{
    /**
     * @var \Danielozano\LogViewer\Model\Log\Collection
     */
    protected $collection;

    /**
     * LogListingDataProvider constructor.
     * @param \Danielozano\LogViewer\Model\Log\Collection $collection
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param array $meta
     * @param array $data
     */
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