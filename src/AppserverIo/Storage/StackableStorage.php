<?php

/**
 * AppserverIo\Storage\StackableStorage
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
 * A storage implementation that uses a \Stackable to hold the data persistent
 * in memory.
 *
 * This storage will completely be flushed when the the object is destroyed,
 * there is no automatic persistence functionality available.
 *
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2015 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://github.com/appserver-io/storage
 * @link      http://www.appserver.io
 */
class StackableStorage extends GenericStackable implements StorageInterface
{

    /**
     * Register the trait that provides basic storage functionality.
     *
     * @var \Trait
     */
    use StorageTrait;

    /**
     * Passes the configuration and initializes the storage.
     *
     * The identifier will be set after the init() function has been invoked, so it'll overwrite the one
     * specified in the configuration if set.
     *
     * @param string $identifier Unique identifier for the cache storage
     */
    public function __construct($identifier = null)
    {
        // flush the storage
        $this->flush();
        // set the identifier
        $this->identifier = $identifier;
    }

    /**
     * (non-PHPdoc)
     *
     * @return void
     * @see \AppserverIo\Storage\StorageInterface::collectGarbage()
     */
    public function collectGarbage()
    {
        // nothing to do here, because gc is handled by memcache
    }

    /**
     * (non-PHPdoc)
     *
     * @param string $tag The tag to search for
     *
     * @return array An array with the identifier (key) and content (value) of all matching entries. An empty array if no entries matched
     * @see \AppserverIo\Storage\StorageInterface::getByTag()
     */
    public function getByTag($tag)
    {
        return $this->get($this->getIdentifier() . $tag);
    }

    /**
     * (non-PHPdoc)
     *
     * @return mixed The storage object itself
     * @see \AppserverIo\Storage\StorageInterface::getStorage()
     */
    public function getStorage()
    {
        return;
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
     *
     * @see \AppserverIo\Storage\StorageInterface::set()
     */
    public function set($entryIdentifier, $data, array $tags = array(), $lifetime = null)
    {
        // create a unique cache key and add the passed value to the storage
        $cacheKey = $this->getIdentifier() . $entryIdentifier;

        // set the data in the storage
        $this[$cacheKey] = $data;

        // if tags has been set, tag the data additionally
        foreach ($tags as $tag) {
            // assemble the tag data
            $tagData = $this->get($this->getIdentifier() . $tag);
            if (is_array($tagData) && in_array($cacheKey, $tagData, true) === true) {
                // do nothing here
            } elseif (is_array($tagData) && in_array($cacheKey, $tagData, true) === false) {
                $tagData[] = $cacheKey;
            } else {
                $tagData = array($cacheKey);
            }

            // tag the data
            $this[$tag] = $tagData;
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
        return $this[$this->getIdentifier() . $entryIdentifier];
    }

    /**
     * (non-PHPdoc)
     *
     * @param string $entryIdentifier An identifier specifying the cache entry
     *
     * @return boolean TRUE if such an entry exists, FALSE if not
     * @see \AppserverIo\Storage\StorageInterface::has()
     */
    public function has($entryIdentifier)
    {
        return isset($this[$this->getIdentifier() . $entryIdentifier]);
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
        if ($this->has($entryIdentifier)) {
            unset($this[$this->getIdentifier() . $entryIdentifier]);
            return true;
        }
        return false;
    }

    /**
     * (non-PHPdoc)
     *
     * @return array
     * @see \AppserverIo\Storage\StorageInterface::getAllKeys()
     */
    public function getAllKeys()
    {
        $keys = array();
        foreach ($this as $key => $value) {
            $keys[] = $key;
        }
        return $keys;
    }
}
