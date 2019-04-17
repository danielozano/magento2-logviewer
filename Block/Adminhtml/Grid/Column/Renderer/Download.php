<?php
/**
 * @copyright Copyright © 2019 Daniel Lozano. All rights reserved.
 * @author    dn.lozano.m@gmail.com
 */

namespace Danielozano\LogViewer\Block\Adminhtml\Grid\Column\Renderer;

use Magento\Framework\DataObject;

class Download extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\Text
{
    public function _getValue(DataObject $row)
    {
        return '<a href="'
            . $this->getUrl(
                '*/*/download',
                ['file' => $row->getData('encoded_filename'), 'basename' => $row->getData('basename')]
            )
            . '">'
            . $this->getColumn()->getHeader()
            . '</a>';
    }
}
