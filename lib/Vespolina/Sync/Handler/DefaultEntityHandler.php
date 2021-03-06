<?php

namespace Vespolina\Sync\Handler;

/**
 * Interface to determine and handle dependencies for a given entity type
 *
 * @author Daniel Kucharski <daniel@vespolina.org>
 */
class DefaultEntityHandler implements EntityHandlerInterface
{

    public function hasDependencies($entity)
    {
        return false;
    }

    function emit($entity)
    {

    }

    function merge(array $resolvedDependencies)
    {

    }
}