<?php

namespace Sedlmayr\Bundle\StaticContentBundle\Repository;

use Symfony\Component\Finder\Finder;
use Symfony\Component\DomCrawler\Crawler;

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

                    $posts[] = $this->_processFile($file);
                }
            }
        }

        return $posts;
    }

    public function getPost(\DateTIme $publishedAt, $title)
    {
        $post = false;
        foreach ($this->_fileDirectories as $dir) {
            if (is_dir(__DIR__.$dir)) {
                if ($files = $this->_finder->files()->in(__DIR__.$dir)->name('/'.$publishedAt->format('Y-m-d').'-'.$title.'/i')->files()) {

                    foreach ($files as $file) {
                        $post = $this->_processFile($file);
                        // exit both loops
                        break 2;
                    }
                }
            }
        }
        return $post;
    }

    private function _processFile(\SplFileInfo $file)
    {
        $fileName           = $file->getFilename();
        $parts              = explode('-', $fileName);

        // drop the first three parts, storing for later use (these are the date)
        $year               = array_shift($parts);
        $month              = array_shift($parts);
        $day                = array_shift($parts);

        // put the rest back together for the title
        $file->title        = implode(' ', $parts);
        $file->published_at = new \DateTime($year.'-'.$month.'-'.$day);

        // is there an excerpt hacked in to the content?
        $crawler            = new Crawler($file->getContents());
        if ( ($excerpt = $crawler->filter('p.data-excerpt')) && count($excerpt)) {
            $file->excerpt = $excerpt->text();
        }

        return $file;
    }
}
