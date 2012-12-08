<?php

namespace Infinity\Bundle\TwigExtensionsBundle\Tests\Twig;

use Infinity\Bundle\TwigExtensionsBundle\Twig\InfinityStringExtension;

/**
 * @author Chris Sedlmayr <chris.sedlmayr@infinity-tracking.com>
 */
class InfinityStringExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testSlugify()
    {
        $stringExtension = new InfinityStringExtension();
        $output = $stringExtension->slugify('This is?foo=bar !@£$ a.string_--with--spaces and &5things');
        $this->assertEquals('this-is-foo-bar-a-string_-with-spaces-and-5things', $output);
        // chinese character test
        $output = $stringExtension->slugify('This is汉语!@£$ a.string_--with--sPaces and &5things');
        $this->assertEquals('this-is汉语-a-string_-with-spaces-and-5things', $output);
    }
}
