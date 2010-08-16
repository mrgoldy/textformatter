<?php

namespace s9e\Toolkit\Acl\Tests;

use s9e\Toolkit\Acl\Builder;
use s9e\Toolkit\Acl\Reader;

include_once __DIR__ . '/../Builder.php';
include_once __DIR__ . '/../Reader.php';

class XMLTest extends \PHPUnit_Framework_TestCase
{
	public function testACLCanBeQueriedInXML()
	{
		$builder = new Builder;
		$builder->allow('foo', array('bar' => 123, 'baz' => 'xyz'));
		$builder->allow('foo', array('bar' => 456));
		$builder->deny('foo', array('bar' => 456, 'baz' => 'DENY'));

		$xml = $builder->getReaderXML();

		$dom = new \DOMDocument;
		$dom->loadXML($xml);

		$x = new \DOMXPath($dom);

		$this->assertSame('1', $x->evaluate('substring(/acl/space[@foo], 1 + concat("0", /acl/space[@foo]/scopes/bar/@_456), 1)'));

		$this->assertSame('0', $x->evaluate('substring(/acl/space[@foo], 1 + concat("0", /acl/space[@foo]/scopes/bar/@_456) + concat("0", /acl/space[@foo]/scopes/baz/@_DENY), 1)'));
	}
}