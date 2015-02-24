<?php

/**
 * AppserverIo\Storage\MemcachedStorage
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
 * A Memcached storage implementation.
 *
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2015 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://github.com/appserver-io/storage
 * @link      http://www.appserver.io
 */
class MemcachedStorage extends AbstractStorage implements MemcachedStorageInterface
{

    /**
     * Array that contains servers the storage is bound to.
     *
     * @var array
     */
    protected $servers = array();

    /**
     * Adds an server to the internal list with servers this storage
     * is bound to, used by MemcachedStorage for example.
     *
     * @param string  $host   The server host
     * @param integer $port   The server port
     * @param integer $weight The weight the server has
     *
     * @return void
     * @see \AppserverIo\Storage\StorageInterface::addServer()
     */
    public function addServer($host, $port, $weight)
    {
        $this->servers[] = array($host, $port, $weight);
    }

    /**
     * Returns the list with servers this storage is bound to.
     *
     * @return array The server list
     * @see \AppserverIo\Storage\StorageInterface::getServers()
     */
    public function getServers()
    {
        return $this->servers;
    }

    /**
     * (non-PHPdoc)
     *
     * @return void
     * @see AppserverIo\Storage\AbstractStorage::init();
     */
    public function init()
    {
        // inject the \Memcached storage
        $this->injectStorage(new \Memcached(__CLASS__));
        // initialize the storage
        $serverList = $this->storage->getServerList();
        if (empty($serverList)) {
            $this->storage->setOption(\Memcached::OPT_LIBKETAMA_COMPATIBLE, true);
            foreach ($this->getServers() as $server) {
                list ($host, $port, $weight) = $server;
                $this->storage->addServer($host, $port, $weight);
            }
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @param string  $entryIdentifier Something which identifies the data - depends on concrete cache
     * @param mixed   $data            The data to cache - also depends on the concrete cache implementation
     * @param array   $tags            Tags to associate with this cache entry
     * @param integer $lifetime        Lifetime of this cache entry in seconds. If NULL is specified,
     *                                 the default lifetime is used. "0" means unlimited lifetime.
     *
     * @return void
     * @see \AppserverIo\Storage\StorageInterface::set()
     */
    public function set($entryIdentifier, $data, array $tags = array(), $lifetime = null)
    {
        // add the passed value to the storage
        $this->storage->set($entryIdentifier, $data, $lifetime);

        // if tags has been set, tag the data additionally
        foreach ($tags as $tag) {
            $tagData = $this->get($tag);
            if (is_array($tagData) && in_array($entryIdentifier, $tagData, true) === true) {
                // do nothing here
            } elseif (is_array($tagData) && in_array($entryIdentifier, $tagData, true) === false) {
                $tagData[] = $entryIdentifier;
            } else {
                $tagData = array($entryIdentifier);
            }
            $this->storage->set($tag, $tagData);
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @param string $entryIdentifier Something which identifies the cache entry - depends on concrete cache
     *
     * @return mixed
     * @see \AppserverIo\Storage\StorageInterface::get()
     */
    public function get($entryIdentifier)
    {
        return $this->storage->get($entryIdentifier);
    }

    /**
     * (non-PHPdoc)
     *
     * @param string $entryIdentifier An identifier specifying the cache entry
     *
     * @return boolean TRUE if such an entry exists, FALSE if not
     * @see \AppserverIo\Storage\StorageInterface::remove()
     */
    public function remove($entryIdentifier)
    {
        $this->storage->delete($entryIdentifier);
    }

    /**
     * (non-PHPdoc)
     *
     * @return array
     * @see \AppserverIo\Storage\StorageInterface::getAllKeys()
     */
    public function getAllKeys()
    {
        $this->storage->getAllKeys();
    }
}
