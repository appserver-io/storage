<?php

/**
 * AppserverIo\Storage\ApcuStorage
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
 * Class ApcuStorage
 *
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2015 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://github.com/appserver-io/storage
 * @link      http://www.appserver.io
 */
class ApcuStorage extends AbstractStorage
{

    /**
     * Initializes the storage when the instance is constructed and the __wakeup() method is invoked.
     *
     * @return void
     * @see AppserverIo\Storage\AbstractStorage::init();
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
     * @param integer $lifetime        Lifetime of this cache entry in seconds.
     *                                 If NULL is specified, the default lifetime is used. "0" means unlimited lifetime.
     *
     * @return void
     *
     * @see \AppserverIo\Storage\StorageInterface::set()
     */
    public function set($entryIdentifier, $data, array $tags = array(), $lifetime = null)
    {
        // add the passed value to the storage
        apc_store($entryIdentifier, $data, $lifetime);

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
            apc_store($tag, $tagData);
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
        return apc_fetch($entryIdentifier);
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
        return apc_exists($entryIdentifier);
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
        return apc_delete($entryIdentifier);
    }

    /**
     * (non-PHPdoc)
     *
     * @return array
     * @see \AppserverIo\Storage\StorageInterface::getAllKeys()
     */
    public function getAllKeys()
    {
        $iter = new \APCIterator('user');
        $keys = array();
        foreach ($iter as $item) {
            echo $keys[] = $item['key'];
        }
        return $keys;
    }
}
