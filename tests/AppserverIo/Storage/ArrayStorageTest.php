<?php

/**
 * AppserverIo\Storage\ArrayStorageTest
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
 * Test for the default session settings implementation.
 *
 * @category  Library
 * @package   Storage
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://github.com/appserver-io/storage
 * @link      http://www.appserver.io
 */
class ArrayStorageTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The storage instance to test.
     *
     * @var \AppserverIo\Storage\ArrayStorage
     */
    protected $storage;

    /**
     * Initializes the storage instance to test.
     *
     * @return void
     */
    public function setUp()
    {
        $this->storage = new ArrayStorage(md5(__CLASS__));
    }

    /**
     * Test if the default session name is returned correctly.
     *
     * @return void
     */
    public function testGetAndSet()
    {
        $this->storage->set('key', $value = 'A value');
        $this->assertSame($value, $this->storage->get('key'));
    }
}
