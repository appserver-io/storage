<?php

/**
 * AppserverIo\Storage\StorageInterface
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category  Library
 * @package   Storage
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://github.com/appserver-io/storage
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Storage;

/**
 * Interface for all storage implementations.
 *
 * @category  Library
 * @package   Storage
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://github.com/appserver-io/storage
 * @link      http://www.appserver.io
 */
interface StorageInterface
{

    /**
     * Returns this cache's identifier
     *
     * @return string The identifier for this cache
     */
    public function getIdentifier();

    /**
     * Saves data in the cache.
     *
     * @param string  $entryIdentifier Something which identifies the data - depends on concrete cache
     * @param mixed   $data            The data to cache - also depends on the concrete cache implementation
     * @param array   $tags            Tags to associate with this cache entry
     * @param integer $lifetime        Lifetime of this cache entry in seconds. If NULL is specified,
     *                                 the default lifetime is used. "0" means unlimited lifetime.
     *
     * @return void
     */
    public function set($entryIdentifier, $data, array $tags = array(), $lifetime = null);

    /**
     * Finds and returns data from the cache.
     *
     * @param string $entryIdentifier Something which identifies the cache entry - depends on concrete cache
     *
     * @return mixed
     */
    public function get($entryIdentifier);

    /**
     * Finds and returns all cache entries which are tagged by the specified tag.
     *
     * @param string $tag The tag to search for
     *
     * @return array An array with the identifier (key) and content (value) of all matching entries. An empty array if no entries matched
     */
    public function getByTag($tag);

    /**
     * Checks if a cache entry with the specified identifier exists.
     *
     * @param string $entryIdentifier An identifier specifying the cache entry
     *
     * @return boolean TRUE if such an entry exists, FALSE if not
     */
    public function has($entryIdentifier);

    /**
     * Removes the given cache entry from the cache.
     *
     * @param string $entryIdentifier An identifier specifying the cache entry
     *
     * @return boolean TRUE if such an entry exists, FALSE if not
     */
    public function remove($entryIdentifier);

    /**
     * Removes all cache entries of this cache.
     *
     * @return void
     */
    public function flush();

    /**
     * Removes all cache entries of this cache which are tagged by the specified tag.
     *
     * @param string $tag The tag the entries must have
     *
     * @return void
     */
    public function flushByTag($tag);

    /**
     * Does garbage collection
     *
     * @return void
     */
    public function collectGarbage();

    /**
     * Checks the validity of an entry identifier. Returns true if it's valid.
     *
     * @param string $identifier An identifier to be checked for validity
     *
     * @return boolean
     */
    public function isValidEntryIdentifier($identifier);

    /**
     * Checks the validity of a tag. Returns true if it's valid.
     *
     * @param string $tag A tag to be checked for validity
     *
     * @return boolean
     */
    public function isValidTag($tag);

    /**
     * Returns the keys for all values stored.
     *
     * @return array
     */
    public function getAllKeys();

    /**
     * Returns the internal storage object that
     * handles data persistence.
     *
     * @return object The storage object itself
     */
    public function getStorage();

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
