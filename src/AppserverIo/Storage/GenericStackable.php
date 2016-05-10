<?php

/**
 * AppserverIo\Storage\GenericStackable
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2015 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://github.com/appserver-io/storage
 * @link       http://www.appserver.io
 */

namespace AppserverIo\Storage;

/**
 * A generic stackable implementation that can be used as data container
 * in a thread context.
 *
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2015 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://github.com/appserver-io/storage
 * @link       http://www.appserver.io
 * @deprecated Use \AppserverIo\Storage\GenericThreaded instead
 */
class GenericStackable extends \Threaded
{
}
