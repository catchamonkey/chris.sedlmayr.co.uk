<?php

namespace Infinity\Bundle\TwigExtensionsBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;

/**
 * @author Chris Sedlmayr <chris.sedlmayr@infinity-tracking.com>
 */
class InfinityStringExtension extends Twig_Extension
{
    public function getFilters()
    {
        return array(
            'slugify'   => new Twig_Filter_Method($this, 'slugify'),
        );
    }

    public function slugify($string)
    {
        $ret = $string;
        // remove html line break
        $ret = preg_replace("<br/>", '', $ret);
        // strip all non word chars
        $ret = preg_replace('/\W/u', ' ', $ret);
        // replace all white space sections with a dash
        $ret = preg_replace('/\ +/', '-', $ret);
        // trim dashes
        $ret = preg_replace('/\-$/', '', $ret);
        $ret = preg_replace('/^\-/', '', $ret);
        // convert to lower case
        $ret = strtolower($ret);

        return $ret;
    }

    public function getName()
    {
        return 'infinity_string_extension';
    }
}
