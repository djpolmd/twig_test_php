<?php
/**
 * Created by PhpStorm.
 * User: dobos
 * Date: 11/23/18
 * Time: 2:53 PM
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Tests\Controller;


class BlogPostController extends Controller
{

    pubic function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $blogPosts = $em->GetRepository('AppBundle:BlogPost')->findAll();

        return $this->render('BlogPost/list.html.twig', ['blogPosts' => $blogPosts ]);
    }

/**
* @param Request $request
* @Route("/create", name="create")
*/

    public function createAction(Request $request)
{
    $form = $this->createForm(BlogPostType::class);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        /**
         * @var $blogPost BlogPost
         */
        $blogPost = $form->getData();

        $em = $this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();

        // for now
        return $this->redirectToRoute('edit', [
            'blogPost' => $blogPost->getId(),
        ]);

    }

    return $this->render('BlogPosts/create.html.twig', [
        'form' => $form->createView()
    ]);
}