<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Tests\Sync\Gateway;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Persistence\Mapping\Driver\SymfonyFileLocator;
use Doctrine\ODM\MongoDB\Mapping\Driver\XmlDriver;
use Doctrine\ODM\MongoDB\Mapping\Driver\YamlDriver;
use Vespolina\Sync\Gateway\SyncDoctrineMongoDBGateway;


class SyncDoctrineODMGatewayTest extends SyncGatewayTestCommon
{
    protected function setUp()
    {
        $config = new \Doctrine\ODM\MongoDB\Configuration();
        $config->setHydratorDir(sys_get_temp_dir());
        $config->setHydratorNamespace('Hydrators');
        $config->setProxyDir(sys_get_temp_dir());
        $config->setProxyNamespace('Proxies');

        $locatorXml = new SymfonyFileLocator(
            array(
                __DIR__ . '/../../../../../lib/Vespolina/Sync/Mapping' => 'Vespolina\\Sync\\Entity',
            ),
            '.mongodb.xml'
        );

        $xmlDriver = new XmlDriver($locatorXml);

        $config->setMetadataDriverImpl($xmlDriver);
        $config->setMetadataCacheImpl(new ArrayCache());
        $config->setAutoGenerateProxyClasses(true);
        $doctrineODM = \Doctrine\ODM\MongoDB\DocumentManager::create(null, $config);
        $this->gateway = new SyncDoctrineMongoDBGateway($doctrineODM, 'Vespolina\Entity\Action\Action');

        parent::setUp();
    }
}