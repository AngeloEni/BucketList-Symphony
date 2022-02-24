<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wish", name="wish")
     */
    public function wish(WishRepository $req): Response
    {
        $lst = $req->findBy([], ["dateCreated" => "DESC"]);

        $wish = ['DANSER sur LA PLAGE', 'FAIRE DU BATEAU', 'FAIRE DU SOUS MARIN', 'VACANCES EN FAMILLE'];


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
    public function delete(EntityManagerInterface $em, Wish $wish): Response
    {


        //supprimer
        $em->remove($wish);
        $em->flush(); //Save execute la requète Sql


        return $this->redirectToRoute('wish');
    }



    /**
     * @Route("/add", name="add")
     */
    public function add(EntityManagerInterface $em): Response
    {

        $w = new Wish();
        $w->setTitle("add test");
        $w->setDescription("lolololo");
        $w->setAuthor("l'author de roro");
        $w->setIsPublished(true);
        $w->setDatecreated(new \DateTime()); // l'antislash signifie ici que \DateTime est une classe native 
        //persist uniquement creation // pas de persiste quand on est dans l'update 
        $em->persist($w);
        $em->flush(); //Save execute la requète Sql


        return $this->redirectToRoute('wish');
    }

      /**
     * @Route("/addby", name="addby")
     */
    public function added(Request $req, EntityManagerInterface $em): Response
    {

       
       $w = new Wish();
       $w->setTitle( $req->get('title'));
       $w->setDescription( $req->get('Description'));
       $w->setAuthor($req->get('author'));
       $w->setIsPublished($req->get('radios'));
       $w->setDatecreated(new \DateTime());
       
       $em->persist($w);
       $em->flush();

       return $this->redirectToRoute('wish');

    }

     /**
     * @Route("/addeasy", name="addeasy")
     */
    public function addedeasy(Request $req, EntityManagerInterface $em): Response
    {

       $wish = new wish();
       $form = $this->createForm(WishType::class,$wish);

       $form->handleRequest($req);

       if($form->isSubmitted()){

            $em->persist($wish);
            $em->flush();
            return $this->redirectToRoute('home');

       }
       
       return $this->render('wish/ajouter.html.twig',['formulaire' => $form->createView()]);
     

      

    }

}
