<?php
/**
 * Test
 *
 * @copyright Copyright © 2019 Daniel Lozano. All rights reserved.
 * @author    dn.lozano.m@gmail.com
 */

namespace Danielozano\LogViewer\Console\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Test extends \Symfony\Component\Console\Command\Command
{
    protected $collection;
    public function __construct(\Danielozano\LogViewer\Model\Log\Collection $collection, $name = null)
    {
        parent::__construct($name);
        $this->collection = $collection;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->collection->toArray() as $folder) {
            print_r($folder);
        }
    }

    protected function configure()
    {
        return $this->setName('dlozano:test');
    }
}