<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\AppBundle;

class ArticleController extends Controller
{
    /**
     * @Route("/")
     */
    public function showAction()
    {
        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')
        ->findAll();
        return $this->render('Article/show.html.twig', array(
            'articles' => $articles,
        ));
    }

        /**
     * @Route("/{id}")
     */
    public function viewAction($id)
    {
        $article = $this->getDoctrine()->getRepository('AppBundle:Article')
        ->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Cet article n\'existe pas'
            );
        }

        return $this->render('Article/view.html.twig', array(
            'article' => $article,
        ));
    }

}
