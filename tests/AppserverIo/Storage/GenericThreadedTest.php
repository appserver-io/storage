<?php

/**
 * AppserverIo\Storage\GenericThreadedTest
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

use AppserverIo\Storage\Mock\MockThreadedContext;

/**
 * Test for generic threaded implementation.
 *
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2015 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://github.com/appserver-io/storage
 * @link      http://www.appserver.io
 */
class GenericThreadedTest extends \PHPUnit_Framework_TestCase
{

    /**
     * A key to bind a value to the threaded.
     *
     * @var string
     */
    const KEY = 'key';

    /**
     * A value bound to the stackable for testing purposes.
     *
     * @var string
     */
    const VALUE = 'value';

    /**
     * The instance we want to test.
     *
     * @var \AppserverIo\Storage\GenericThreaded
     */
    protected $storage;

    /**
     * Initializes the instance we want to test.
     *
     * @return void
     */
    public function setUp()
    {
        $this->storage = new GenericThreaded();
    }

    /**
     * Test if the default session name is returned correctly.
     *
     * @return void
     */
    public function testSetAndGetValue()
    {

        // create a mock context
        $context = new MockThreadedContext();
        $context->injectStorage($this->storage);

        // set/get the a value
        $context->setValue(GenericThreadedTest::KEY, GenericThreadedTest::VALUE);
        $this->assertSame(GenericThreadedTest::VALUE, $context->getValue(GenericThreadedTest::KEY));
    }
}
