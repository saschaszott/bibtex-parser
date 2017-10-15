<?php

/*
 * This file is part of the BibTex Parser.
 *
 * (c) Renan de Lima Barbosa <renandelima@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RenanBr\BibTexParser\Test\Listener;

use PHPUnit\Framework\TestCase;
use RenanBr\BibTexParser\Listener;
use RenanBr\BibTexParser\Parser;

class TagNameReadingTest extends TestCase
{
    public function testWhenFirstTagNameIsNullItMustBeInterpretedAsTypeTagContentInstead()
    {
        $listener = new Listener();

        $parser = new Parser();
        $parser->addListener($listener);
        $parser->parseFile(__DIR__ . '/../resources/valid/citation-key.bib');

        $entries = $listener->export();
        $this->assertCount(1, $entries);

        $entry = $entries[0];
        $this->assertSame('citationKey', $entry['type']);
        $this->assertSame('Someone2016', $entry['citation-key']);
        $this->assertSame('bar', $entry['foo']);
    }

    public function testMultipleNullTagNames()
    {
        $listener = new Listener();

        $parser = new Parser();
        $parser->addListener($listener);
        $parser->parseFile(__DIR__ . '/../resources/valid/no-tag-content.bib');

        $entries = $listener->export();
        $this->assertCount(1, $entries);

        $entry = $entries[0];
        $this->assertSame('noTagContent', $entry['type']);
        $this->assertSame('foo', $entry['citation-key']);
        $this->assertNull($entry['bar']);
    }
}
