<?php
/**
 * @copyright 2014 Integ S.A.
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author Javier Lorenzana <javier.lorenzana@gointegro.com>
 */

namespace GoIntegro\Json;

// Mocks.
use Codeception\Util\Stub;

class JsonCoderTest extends \PHPUnit_Framework_TestCase
{
    const JSON_SIMPLE_SAMPLE = <<<'JSON'
{"some_key":"This is so a test."}
JSON;

    public function testEncoding()
    {
        /* Given... (Fixture) */
        $coder = new JsonCoder;
        $data = ['some_key' => "This is so a test."];
        /* When... (Action) */
        $actual = $coder->encode($data);
        /* Then... (Assertions) */
        $expected = self::JSON_SIMPLE_SAMPLE;
        $this->assertSame($expected, $actual);
    }

    public function testDecodingToArray()
    {
        /* Given... (Fixture) */
        $coder = new JsonCoder;
        /* When... (Action) */
        $actual = $coder->decode(self::JSON_SIMPLE_SAMPLE);
        /* Then... (Assertions) */
        $expected = ['some_key' => "This is so a test."];
        $this->assertSame($expected, $actual);
    }

    public function testDecodingToObject()
    {
        /* Given... (Fixture) */
        $coder = new JsonCoder;
        /* When... (Action) */
        $actual = $coder->decode(self::JSON_SIMPLE_SAMPLE, TRUE);
        /* Then... (Assertions) */
        $expected = (object) ['some_key' => "This is so a test."];
        $this->assertEquals($expected, $actual);
    }

    public function testMatchingSchemaAgainstString()
    {
        /* Given... (Fixture) */
        $coder = new JsonCoder;
        $schema = (object) [
            "type" => "object",
            "properties" => [
                "some_key" => ["type" => "string"],
            ],
            "required" => ["some_key"]
        ];
        /* When... (Action) */
        $actual = $coder->matchSchema(self::JSON_SIMPLE_SAMPLE, $schema);
        /* Then... (Assertions) */
        $this->assertTrue($actual);
    }

    public function testMatchingSchemaAgainstObject()
    {
        /* Given... (Fixture) */
        $coder = new JsonCoder;
        $schema = (object) [
            "type" => "object",
            "properties" => [
                "some_key" => ["type" => "string"],
            ],
            "required" => ["some_key"]
        ];
        /* When... (Action) */
        $json = (object) ['some_key' => "This is so a test."];
        $actual = $coder->matchSchema($json, $schema);
        /* Then... (Assertions) */
        $this->assertTrue($actual);
    }
}
