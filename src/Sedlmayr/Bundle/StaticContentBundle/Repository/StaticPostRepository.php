<?php

namespace Sedlmayr\Bundle\StaticContentBundle\Repository;

use Symfony\Component\Finder\Finder;

/**
 * This class handles data access for static posts
 * @author Chris Sedlmayr <chris@sedlmayr.co.uk>
 */
class StaticPostRepository
{
    private $_finder;
    private $_fileDirectories;

    public function __construct(Finder $finder)
    {
        $this->_finder          = $finder;
        $this->_fileDirectories = array();
    }

    public function addFileDirectory($fileDirectory)
    {
        $this->_fileDirectories[] = $fileDirectory;
    }

    public function getPosts()
    {
        $posts = array();

        foreach ($this->_fileDirectories as $dir) {
            if (is_dir(__DIR__.$dir)) {
                $this->_finder->files()->in(__DIR__.$dir)->sortByName();

                foreach ($this->_finder as $file) {

                    $fileName           = $file->getFilename();
                    $parts              = explode('-', $fileName);
                    // drop the first three parts for later use (these were the date)
                    $year               = array_shift($parts);
                    $month              = array_shift($parts);
                    $day                = array_shift($parts);
                    // put back together with a space
                    $file->title        = implode(' ', $parts);
                    $file->published_at = new \DateTime($year.'-'.$month.'-'.$day);
                    $posts[] = $file;
                }
            }
        }

        return $posts;
    }
}
