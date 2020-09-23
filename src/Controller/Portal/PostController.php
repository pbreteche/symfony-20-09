<?php

namespace App\Controller\Portal;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", methods="GET")
 */
class PostController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function index(PostRepository $repository, SessionInterface $session)
    {
        $posts = $repository->findLast();

        $view = $this->renderView('post/index.html.twig', [
            'posts' => $posts,
        ]);

        $session->set('data_name', 'value');

        $response = new Response($view);

        $response->headers->set('Content-Type', 'text/html');
        $response->setStatusCode(Response::HTTP_ACCEPTED);

        return $response;
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"})
     * @Entity("post", expr="repository.findWithAuthor(id)")
     */
    public function show(Post $post)
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/new", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $newPost = new Post();
        $newPost->setPublishedAt(new \DateTime());

        $createForm = $this->createForm(PostType::class, $newPost);

        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $manager->persist($newPost);
            $manager->flush();

            $this->addFlash('Success', 'Votre post a bien été créé.');

            return $this->redirectToRoute('app_portal_post_show', [
                'id' => $newPost->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/create.html.twig', [
            'create_form' => $createForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", methods={"GET", "PUT"})
     */
    public function update(Post $post, Request $request, EntityManagerInterface $manager)
    {
        $editForm = $this->createForm(PostType::class, $post, [
            'method' => 'PUT',
            'keep_author' => true,
        ]);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $manager->flush();

            $this->addFlash('Success', 'Votre post a bien été modifié.');

            return $this->redirectToRoute('app_portal_post_show', [
                'id' => $post->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/update.html.twig', [
            'post' => $post,
            'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", methods="DELETE")
     */
    public function delete(Post $post, EntityManagerInterface $manager)
    {
        $manager->remove($post);
        $manager->flush();

        return $this->redirectToRoute('app_portal_post_index');
    }
}
