<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Like;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LikeController extends AbstractController
{
    #[Route('/like/article/{id}', name: 'app_like')]
    #[Route('/like/comment/{id}', name: 'comment_like')]
    public function like(Request $request, EntityManagerInterface $manager, LikeRepository $likeRepository, Article $article = null, Comment $comment = null): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json("no user connected", 400);
        }

        if ($article !== null) {
            $entity = $article;
        } elseif ($comment !== null) {
            $entity = $comment;
        } else {
            return $this->json("No article or comment trouvé", 400);
        }

        if ($entity->isLikedBy($user)) {
            $like = $likeRepository->findOneBy([
                'author' => $user,
                'article' => $article,
                'comment' => $comment
            ]);
            $manager->remove($like);
            $isLiked = false;
        } else {
            $like = new Like();
            if ($article !== null) {
                $like->setArticle($article);
            } elseif ($comment !== null) {
                $like->setComment($comment);
            }
            $like->setAuthor($user);
            $manager->persist($like);
            $isLiked = true;
        }

        $manager->flush();

        $data = [
            'liked' => $isLiked,
            'count' => $likeRepository->count(['article' => $article, 'comment' => $comment])
        ];

        return $this->json($data, 200);
    }
}