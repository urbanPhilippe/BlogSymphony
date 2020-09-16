<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Articles;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;



/**
 * Class ArticlesController
 * @package App\Controller
 * @Route("/actualites", name="actualites_")
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="articles")
    */    
    public function index(Request $request, PaginatorInterface $paginator)
    {
        
        $donnees = $this->getDoctrine()->getRepository(Articles::class)->findBy([],['created_at' => 'desc']);

        $articles = $paginator->paginate(
            $donnees, 
            $request->query->getInt('page', 1), 
        );
        
        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/{slug}", name="article")
     */
    public function article($slug) {
        $article = $this->getDoctrine()->getRepository(Articles::class)->findOneBy(['slug' => $slug]);
        if(!$article) {
            throw $this->createNotFoundException('L\'article n\'existe pas');
        }
        return $this->render('articles/article.html.twig', compact('article'));
    }

}
