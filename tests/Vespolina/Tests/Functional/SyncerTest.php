<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
 
namespace Vespolina\Tests\Functional;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\EventDispatcher\EventDispatcher;

use Vespolina\Sync\Entity\SyncState;
use Vespolina\Sync\Gateway\SyncMemoryGateway;
use Vespolina\Sync\ServiceAdapter\AbstractServiceAdapter;
use Vespolina\Sync\Manager\SyncManager;

/**
 */
class SyncerTest extends \PHPUnit_Framework_TestCase
{
    protected $manager;
    protected $dispatcher;
    protected $gateway;
    protected $remoteServiceAdapter;

    protected function setUp()
    {
        $this->dispatcher = new EventDispatcher();
        $this->gateway = new SyncMemoryGateway();
        $this->manager = new SyncManager($this->gateway, $this->dispatcher);
    }

    public function testSyncEntitiesFromOneRemoteService()
    {
        //Setup a remote service with some entities we want to locally sync
        $this->setupRemoteService();

        //Setup the synchonization configuration
        $this->setupConfiguration();

        //Setup the synchronization state
        $this->setSyncState();

        //Perform synchronization
        $this->manager->execute(array('product'));


        //Test if all requested entities have been synced
        $state = $this->manager->getState('product');

        $this->assertEquals($state->getLastValue(), 10);

    }

    protected function setupConfiguration()
    {
        $yamlParser = new Parser();
        $config = $yamlParser->parse(file_get_contents(__DIR__ . '/single_entity.yml'));

    }

    protected function setSyncState()
    {
        $syncState = new SyncState('product');
        $syncState->setLastValue(5);

        $this->manager->updateState($syncState);
    }

    protected function setupRemoteService()
    {
        //Create a remote service adapter which can deal with products
        $this->remoteServiceAdapter = new DummyRemoteServiceAdapter(array('product'));

        for ($i = 0; $i < 20;$i++) {
            $entity = new RemoteEntity();
            $entity->id = $i;
            $this->remoteServiceAdapter->add($entity);
        }

        $this->manager->addServiceAdapter($this->remoteServiceAdapter);
    }
}

class RemoteEntity{
    public $id;
}

class DummyRemoteServiceAdapter extends AbstractServiceAdapter
{
    protected $entities;
    protected $size;
    protected $lastValue;

    public function add(RemoteEntity $entity)
    {
        if (null == $this->entities) $this->entities = array();
        $this->entities[] = $entity;
    }

    public function fetchEntities($lastValue, $size)
    {
        $out = array();

        //Simple naive implementation comparing the entity id
        foreach ($this->entities as $entity) {

            if ($entity->id > $lastValue) {
                $out[] = $entity;
            }
        }

       return $out;
    }
}