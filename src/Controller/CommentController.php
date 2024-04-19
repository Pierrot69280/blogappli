<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route('/comment/create/{id}', name: 'app_comment_create')]
    public function create(Request $request, EntityManagerInterface $manager, Article $article): Response
    {

        if(!$this->getUser()){return $this->redirectToRoute("app_articles");}

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser());
            $comment->setArticle($article);
            $comment->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($comment);
            $manager->flush();

        }
        return $this->redirectToRoute("app_article", ["id" => $article->getId()]);
    }

    #[Route('/comment/delete/{id}', name:'app_comment_delete')]
    public function delete(Comment $comment, EntityManagerInterface $manager):Response
    {
        $article = $comment->getArticle();
        if($this->getUser() === $comment->getAuthor()) {

            $manager->remove($comment);
            $manager->flush();

            return $this->redirectToRoute("app_article", ["id" => $article->getId()]);
        }else{
            return $this->redirectToRoute("app_articles");

        }
    }

    #[Route('/comment/edit/{id}', name: 'app_comment_edit')]
    public function edit(Request $request, EntityManagerInterface $manager, Comment $comment):Response
    {
        $article = $comment->getArticle();
        $form = $this->createForm(CommentType::class, $comment);
        if($this->getUser() === $comment->getAuthor()) {

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $manager->persist($comment);
                $manager->flush();

                return $this->redirectToRoute("app_article", ["id" => $article->getId()]);
            }
        }else{
            return $this->redirectToRoute('app_articles');
        }

        return $this->render('comment/edit.html.twig', [
            'controller_name' => 'ArticleController',
            "form" => $form->createView(),
        ]);
    }
}

