<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Sync\ServiceAdapter;

use Vespolina\Sync\Entity\EntityData;

/**
 * An interface to manage a remote service
 *
 * @author Daniel Kucharski <daniel@vespolina.org>
 */
interface ServiceAdapterInterface
{
    /**
     * Retrieve entities starting from $lastValue
     *
     * @param $entityName
     * @param $lastValue
     * @param $packageSize Max number of entities to retrieve
     * @return array EntityData
     */
    public function fetchEntities($entityName, $lastValue, $packageSize);

    /**
     * Fetch a specific remote entity
     *
     * @param $entityName
     * @param $remoteId
     * @return \Vespolina\Sync\Entity\EntityData
     */
    public function fetchEntity($entityName, $remoteId);

    /**
     * Retrieve the supported entities
     *
     * @return array
     */
    public function getSupportedEntities();

    /**
     * Does this service adapter support $entityName ?
     *
     * @param $entityName
     * @return mixed
     */
    public function supportsEntity($entityName);

    /**
     * Transform the entity data object into the real entity.
     * The method will be called by the sync manager when all dependencies have been resolved
     *
     * @param  EntityData $entityData
     * @return object
     */
    public function transformEntityData(EntityData $entityData);
}
