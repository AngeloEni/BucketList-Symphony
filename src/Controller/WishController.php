<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
     /**
     * @Route("/wish", name="wish")
     */
    public function wish(WishRepository $req): Response
    {
        $lst = $req->findBy([],["dateCreated"=>"DESC"]);
      
        $wish = ['DANSER sur LA PLAGE','FAIRE DU BATEAU','FAIRE DU SOUS MARIN','VACANCES EN FAMILLE']; 
       
        
        return $this->render('wish/wish.html.twig', [
            'titre' => 'wish',
            'list' => $wish,
            'req' => $lst,
        ]);
    } 

      /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail(Wish $wish): Response
    {
       
        
       

         return $this->render('wish/detail.html.twig', [
            'titre' => 'detail',
            'wish' => $wish,
        ]);
    }

       /**
     * @Route("/about/", name="about")
     */
    public function about(): Response
    {
        return $this->render('wish/about.html.twig', [
            'titre' => 'Page about',
        ]);
    }
       /**
     * @Route("/", name="home")
     */
    public function hello(): Response
    {
        return $this->render('wish/about.html.twig', [
            'titre' => 'Page about',
        ]);
    }


     /**
     * @Route("/delete/{id}", name="delete")
     */
    public function add(EntityManagerInterface $em, Wish $wish): Response
    {
        
    
        //supprimer
        $em->remove($wish);
        $em->flush();//Save execute la requète Sql
        
        
        return $this->redirectToRoute('wish');

       
    }

    

     /**
     * @Route("/add", name="add")
     */
    public function delete(EntityManagerInterface $em): Response
    {
        
        $w = new Wish();
        $w->setTitle("add test");
        $w->setDescription("lolololo");
        $w->setAuthor("l'author de roro");
        //persist uniquement creation
        $em->persist($w);
        $em->flush();//Save execute la requète Sql
        
        
        return $this->redirectToRoute('wish');

    }

    
}
