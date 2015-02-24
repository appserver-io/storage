<?php

/**
 * AppserverIo\Storage\ArrayStorage
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
 * A simple array storage implementation.
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
class ArrayStorage extends AbstractStorage
{

    /**
     * Injects the \Stackable storage handler into the instance.
     */
    public function __construct()
    {
        // inject the stackable storage
        $this->injectStorage(array());
        // call the parent constructor to initialize + flush the storage
        parent::__construct();
    }

    /**
     * (non-PHPdoc)
     *
     * @return void
     * @see \AppserverIo\Storage\AbstractStorage::init()
     */
    public function init()
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

        // set the data in the storage
        $this->storage[$entryIdentifier] = $data;

        // if tags has been set, tag the data additionally
        foreach ($tags as $tag) {
            // assemble the tag data
            $tagData = $this->get($tag);
            if (is_array($tagData) && in_array($entryIdentifier, $tagData, true) === true) {
                // do nothing here
            } elseif (is_array($tagData) && in_array($entryIdentifier, $tagData, true) === false) {
                $tagData[] = $entryIdentifier;
            } else {
                $tagData = array($entryIdentifier);
            }

            // tag the data
            $this->storage[$tag] = $tagData;
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
        return $this->storage[$entryIdentifier];
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
        return isset($this->storage[$entryIdentifier]);
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
            unset($this->storage[$entryIdentifier]);
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
        foreach ($this->storage as $key => $value) {
            $keys[] = $key;
        }
        return $keys;
    }
}
