<?php

/**
 * AppserverIo\Storage\MemcachedStorageInterface
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2015 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://github.com/appserver-io/storage
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Storage;

/**
 * Interface for a Memcached storage implementations.
 *
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2015 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://github.com/appserver-io/storage
 * @link      http://www.appserver.io
 */
interface MemcachedStorageInterface
{

    /**
     * Adds an server to the internal list with servers this storage
     * is bound to, used by MemcachedStorage for example.
     *
     * @param string  $host   The server host
     * @param integer $port   The server port
     * @param integer $weight The weight the server has
     *
     * @return void
     */
    public function addServer($host, $port, $weight);

    /**
     * Returns the list with servers this storage is bound to.
     *
     * @return array The server list
     */
    public function getServers();
}
