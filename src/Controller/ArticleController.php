<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('article/index.html.twig', [

            'articles' => $articles,
        ]);
    }

    #[Route ('/article/{id}', name: 'app_article')]
    public function show(Article $article):Response
    {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class,$comment);

        return $this->render('article/show.html.twig', [
            'article'=>$article,
            "form"=>$form
        ]);
    }

    #[Route('/create', name: 'app_create')]
    public function create(Request $request, EntityManagerInterface $manager):Response
    {

        $article = new Article();
        $form =  $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($article);

            $manager->flush();

            return $this->redirectToRoute('app_articles', ["id"=>$article->getId()]);
        }

        return $this->render('article/create.html.twig',[
            'formulaire'=>$form->createView()
        ]);
    }


    #[Route('/article/delete/{id}', name:'app_delete')]
    public function delete(Article $article, EntityManagerInterface $manager):Response
    {
        $manager->remove($article);
        $manager->flush();

        return $this->redirectToRoute("app_articles");
    }

    #[Route('/edit/{id}',name: 'app_edit')]
    public function edit(Request $request,EntityManagerInterface $manager,Article $article):Response
    {

        $formulaire = $this->createForm(ArticleType::class,$article);
        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted() && $formulaire->isValid())
        {
            $manager->persist($article);

            $manager->flush();

            return $this->redirectToRoute('app_article', ["id"=>$article->getId()]);
        }


        return $this->render("article/edit.html.twig",[
            "formulaire"=>$formulaire->createView()
        ]);
    }
}
