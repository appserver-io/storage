<?php

/**
 * AppserverIo\Storage\StorageTrait
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
 * A trait implementation providing basic storage functionality.
 *
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2015 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://github.com/appserver-io/storage
 * @link      http://www.appserver.io
 */
trait StorageTrait
{

    /**
     * (non-PHPdoc)
     *
     * @return void
     * @see \AppserverIo\Storage\StorageInterface::flush()
     */
    public function flush()
    {
        if ($allKeys = $this->getAllKeys()) {
            foreach ($allKeys as $key) {
                $this->remove($key);
            }
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @param string $tag The tag the entries must have
     *
     * @return void
     * @see \AppserverIo\Storage\StorageInterface::flushByTag()
     */
    public function flushByTag($tag)
    {
        $tagData = $this->get($tag);
        if (is_array($tagData)) {
            foreach ($tagData as $cacheKey) {
                $this->remove($cacheKey);
            }
            $this->remove($tag);
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @param string $tag A tag to be checked for validity
     *
     * @return boolean
     * @see \AppserverIo\Storage\StorageInterface::isValidTag()
     */
    public function isValidTag($tag)
    {
        return $this->isValidEntryIdentifier($tag);
    }

    /**
     * (non-PHPdoc)
     *
     * @param string $identifier An identifier to be checked for validity
     *
     * @return boolean
     * @see \AppserverIo\Storage\StorageInterface::isValidEntryIdentifier()
     */
    public function isValidEntryIdentifier($identifier)
    {
        if (preg_match('^[0-9A-Za-z_]+$', $identifier) === 1) {
            return true;
        }
        return false;
    }
}
