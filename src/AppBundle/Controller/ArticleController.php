<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;

class ArticleController extends Controller
{
    /**
     * Méthode permettant d'afficher toutes les données en base
     * @Route("/")
     */
    public function showAction()
    {
        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')->findArticlesOrderDesc();

        return $this->render('Article/show.html.twig', array(
            'articles' => $articles,
        ));
    } 

    /**
     * @Route("/article/{id}")
     */
    public function viewAction($id)
    {
        $article = $this->getDoctrine()->getRepository('AppBundle:Article')->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aie aie aie, pas trouvé'
            );
        }

        return $this->render('Article/view.html.twig', array(
            'article' => $article,
        ));
    }

    /**
     * @Route("/new")
     */
    public function createAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
            $article = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirect('/');
        }

        return $this->render('Article/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/edit/{id}")
     */

     public function editAction(Request $request, $id)
     {
         $em = $this->getDoctrine()->getManager();
         $article = $em->getRepository('AppBundle:Article')->find($id);
         $form = $this->createForm(ArticleType::class, $article);
         $form->handleRequest($request);

         if (!$article) {
             throw $this->createNotFoundException(
                 'Aie aie aie'
             );
         }

         if ($form->isSubmitted()&& $form->isValid()) {
             $article = $form->getData();
             $em->persist($article);
             $em->flush();

             return $this->redirect('/');
         }
         return $this->render('Article/new.html.twig', array(
             'form'=>$form->createView(),
         ));
     }

    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction($id)
    {
    $em = $this->getDoctrine()->getManager();
    $article = $em->getRepository('AppBundle:Article')->find($id);

    if (!$article) {
        throw $this->createNotFoundException(
            'Aie aie aie'
        );
    }

    $em->remove($article);
    $em->flush();

    return $this->redirect('/');
    }
}
