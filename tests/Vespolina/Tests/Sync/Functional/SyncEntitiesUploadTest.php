<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Tests\Sync\Functional;

class SyncEntitiesUploadTest extends SyncBaseUploadTestCase
{
    public function testUploadSyncEntities()
    {
        $state = $this->manager->getState('product');
        $this->assertNull($state->getLastValue());

        // Perform synchronization
        $this->manager->execute(array('product'));

        // Verify that the log does not contain any issues
        $this->assertFalse($this->logHandler->hasErrorRecords(), 'Sync should not have any errors');
        // Test if all requested entities have been synced
        $state = $this->manager->getState('product');
        $this->assertEquals(20, $state->getLastValue());
    }
}
