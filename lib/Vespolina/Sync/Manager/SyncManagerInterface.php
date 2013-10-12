<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Sync\Manager;

use Vespolina\Sync\Entity\SyncStateInterface;
use Vespolina\Sync\ServiceAdapter\ServiceAdapterInterface;

/**
 * An interface to manage the synchronization state
 *
 * @author Daniel Kucharski <daniel@vespolina.org>
 */
interface SyncManagerInterface
{

    /**
     * Register a local entity retriever
     *
     * @param string $entityName
     * @param $retriever  Manager or gateway to retrieve the entity
     * @param string $method The method which will be called to retrieve the entity when the id passed
     * @return mixed
     */
    function addLocalEntityRetriever($entityName, $retriever, $method = 'findId');

    /**
     * Register a service adapter
     *
     * @param ServiceAdapterInterface $serviceAdapter
     * @return mixed
     */
    function addServiceAdapter(ServiceAdapterInterface $serviceAdapter);

    /**
     * Execute synchronization for the given list of entities
     *
     * @param array $entityNames
     * @return mixed
     */
    function execute(array $entityNames = array(), $size = 0);

    /**
     * Retrieve the synchronisation state for the entity
     *
     * @param $entityName
     * @return SyncStateInterface
     */
    function getState($entityName);
}
