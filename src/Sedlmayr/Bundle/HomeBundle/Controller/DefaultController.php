<?php

namespace Sedlmayr\Bundle\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class DefaultController extends Controller
{
    /**
     * Lists posts
     *
     * @Route("/", name="post_list")
     * @Route("/feed", name="post_list_feed", defaults={"_format" = "atom"}, requirements={"_format" = "atom"})
     * @Template()
     * @Cache(maxage="15", smaxage="15")
     */
    public function listAction()
    {
        $repo = $this->get('sedlmayr_static_content.static_post_repository');
        $posts = $repo->getPosts();

        return array('posts' => $posts);
    }

    /**
     * @Route("/{publishedAt}/{title}.{format}", 
     * defaults={"format" = "html"}, 
     * requirements={"published_at" = "[0-9]{4}-[0-9]{2}-[0-9]{2}", "title" = "[a-zA-Z0-9\-_]+"},
     * name="post_view")
     * @Template()
     */
    public function viewAction(\DateTime $publishedAt, $title)
    {
        $repo = $this->get('sedlmayr_static_content.static_post_repository');
        $post = $repo->getPost($publishedAt, $title);

        return array('post' => $post);
    }
}
