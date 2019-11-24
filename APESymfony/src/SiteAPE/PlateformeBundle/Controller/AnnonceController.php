<?php
//On se place dans le namespace des contrôleurs de notre Bundle
namespace SiteAPE\PlateformeBundle\Controller;

//Notre contrôleur va utiliser l'objet Response, il faut donc le charger grâce au use
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SiteAPE\PlateformeBundle\Entity\Annonce;
use SiteAPE\PlateformeBundle\Entity\Image;
use SiteAPE\PlateformeBundle\Entity\Candidature;
use SiteAPE\PlateformeBundle\Entity\Competence;

use SiteAPE\PlateformeBundle\Entity\AnnonceCompetence;
use SiteAPE\PlateformeBundle\Repository\AnnonceRepository;


use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use SiteAPE\PlateformeBundle\Form\AnnonceType;
use SiteAPE\PlateformeBundle\Form\AnnonceModificationType;

class AnnonceController extends Controller
{
    //Définition de la méthode indexAction() (Le suffixe Action est obligatoire).
    public function indexAction($page)
    {    
        if($page < 1)
        {
            throw new NotFoundHttpException('Page "' . $page . '" Inexisante');
        }

        //$listeAnnonce = array(
            //array(
            //    'titre'   => 'Recherche développeur Symfony',
            //    'id'      => 1,
            //    'auteur'  => 'Alexandre',
            //    'contenu' => 'Nous recherchons un développeur Symfony débutant sur Lyon. ',
            //    'date'    => new \DateTime()),
            //array(
            //    'titre'   => 'Mission de webmaster',
            //    'id'      => 2,
            //    'auteur'  => 'Hudo',
            //    'contenu' => 'Nous recherchons un webmaster capable de maintenir notre site internet. ',
            //    'date'    => new \DateTime()),
            //array(
            //    'titre'   => 'Offre de stage',
            //    'id'      => 3,
            //    'auteur'  => 'Mathieu',
            //    'contenu' => 'Nous proposons un poste pour webdesigner. ',
            //    'date'    => new \DateTime()),
            //array(
            //    'titre'   => 'Recherche développeur c#',
            //    'id'      => 4,
            //    'auteur'  => 'Isabelle',
            //    'contenu' => 'Nous proposons un poste pour un développeur C# sur Paris',
            // 'date'    => new \DateTime())
            //);

            $em = $this->getDoctrine()->getManager()->getRepository('SiteAPEPlateformeBundle:Annonce');
            $listeAnnonce = $em->findAll();
            

        $content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:index.html.twig', array('page'=>$page, 'listeAnnonces'=>$listeAnnonce));
        return new Response($content);


    }

    public function detailAction($id)
    {

        
        //$nomParam = $request->query->get('mission');
        //$annonce = array('titre'   => 'Recherche développeur Symfony',
        //'id'      => 1,
        //'auteur'  => 'Alexandre',
        //'contenu' => 'Nous recherchons un développeur Symfony débutant sur Lyon. ',
        //'date'    => new \DateTime());

        //Récuperation de l'EntityManager
        $em = $this->getDoctrine()->getManager();

        //On récupère l'annonce
        $annonce = $em->getRepository('SiteAPEPlateformeBundle:Annonce')->find($id);
        //$annonce est donc une instance de l'entité Annonce
        // ou null si l'id n'existe pas
        if($annonce === null)
        {
            throw new NotFoundHttpException("L'annonce d'id ".$id. " n'existe pas.");
        }

        $ListeCandidature = $em->getRepository('SiteAPEPlateformeBundle:Candidature')->findBy(array('annonce'=>$annonce));
        $listeCompetence = $em->getRepository('SiteAPEPlateformeBundle:AnnonceCompetence')->findBy(array('annonce'=>$annonce));
        $content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:annonce.html.twig', array('annonce'=>$annonce, 'candidature'=>$ListeCandidature, 'competence'=>$listeCompetence));
        return new Response($content);
        //return $this->redirectToRoute('SiteAPE_plateforme_accueil');
    }


   public function ajouterAction(Request $request)
   {
       
         //$annonce = array('titre'   => 'Recherche développeur Symfony',
        //'id'      => 1,
        //'auteur'  => 'Alexandre',
        //'contenu' => 'Nous recherchons un développeur Symfony débutant sur Lyon. ',
        //'date'    => new \DateTime());

                    //Création d'un objet Annonce
                    //$annonce = new Annonce();
                    //$annonce->setTitre('Recherche développeur Symfony');
                    //$annonce->setAuteur('Alexandre');
                    //$annonce->setContenu('Nous recherchons un développeur Symfony débutant sur Lyon.');
                    //On ne définit pas ici la date de l'annonce : elle sera définie automatiquement dans le constructeur

                    //Création de l'entité Image
                    //$image = new Image();
                    //$image->setUrl('../../../../web/img/logosymfony.png');
                    //$image->setTextealternatif('Developpeur symfony');

                    //Toujours avant la persistance de l'annonce
                    //Création de la premiere candidature
                    //$Candidature1 = new Candidature();
                    //$Candidature1->setCandidat('FIQUET');
                    //$Candidature1->setContenu('Je souhaite postuler à ce job...');
                    
                    //Création d'une deuxieme candidature
                    //$Candidature2 = new Candidature();
                    //$Candidature2->setCandidat('LACHENY');
                    //$Candidature2->setContenu('Je suis a la recherche d\'un stage');
                    
                    //On lie les candidatures à l'annonce
                    //$Candidature1->setAnnonce($annonce);
                    //$Candidature2->setAnnonce($annonce);

                    //On lie l'image à l'annonce
                    //$annonce->setImage($image);

                    //On récupère l'EntityManager
                    //$em = $this->getDoctrine()->getManager();

                    //$listeCompetence = $em->getRepository('SiteAPEPlateformeBundle:Competence')->findAll();

                    //foreach ($listeCompetence as $competence)
                    //{
                    //$annonceCompetence = new AnnonceCompetence();
                    //$annonceCompetence->setAnnonce($annonce);
                    //$annonceCompetence->setCompetence($competence);
                    //$annonceCompetence->setNiveau('Expert');
                    //$em->persist($annonceCompetence);
                    //}

                //$em = $this->getDoctrine()->getManager();

                    //Étape 1 : on "persiste" l'entité : à partir de maintenant cet objet est géré par Doctrine
                    //Ici aucune requête SQL n'est exécutée
                    //$em->persist($annonce);

                    //Pour cette relation pas de cascade, car elle est définie dans l'entité
                    //Candidature et non Annonce. On doit donc tout persister à la main ici
                    //$em->persist($Candidature1);
                    //$em->persist($Candidature2);

                    //Étape 2 : On "flush" tout ce qui a été persisté avant.
                    //Doctrine exécute effectivement les requêtes nécéssaires pour sauvegarder
                    //les objets (entités) qu'on lui as dit de persister
                    //Ici une requête de type "INSERT" va être exécutée
                    //$em->flush();

                    // On ajoute les champs de l'entité que l'on veut à notre formulaire
                    //$formBuilder
                    //    ->add('date',       DateType::class)
                    //    ->add('titre',      TextType::class)
                    //    ->add('contenu',    TextareaType::class)
                    //    ->add('auteur',     TextType::class)
                    //    ->add('publication', CheckboxType::class, array('required'=>false))
                    //    ->add('sauvegarde', SubmitType::class);

        
        //On crée un objet Annonce
        $annonce = new Annonce();


        //On créer le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->createBuilder(AnnonceType::class, $annonce);

        

        //Les candidatures, les catégories, etc seront gérées plus tard

        // A partir du formBuilder, on génére le formulaire
        $form = $formBuilder->getForm();

        //Reste de la méthode qu'on avait déjà ecrit
        if($request->isMethod('POST'))
        {
                            //$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée');
                            //Puis on redirige vers la page de visualisation de cette annonce
                            //En utilisant la route correspondant au détail d'un annonce
                            //L'annonce étant maintenant enregistré en base de données grâce au flush()
                            //Doctrine2 lui a attribué un id que l'on peut récupérer grâce a la méthode getId()
                            //return $this->redirectToRoute('SiteAPE_plateforme_detail', array('id',$annonce->getId()));
            $form->handleRequest($request);
            // On vérifie que les valeurs entrées sont correctes
            //(Nous verrons la validation des objets en détail dans le prochain chapitre)
            if ($form->isValid())
            {
                //On enregistre notre objet $annonce dans la base de données, par exemple
                $em = $this->getDoctrine()->getManager();
                $em->persist($annonce);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

                //On redirige vers la page de visualisation de l'annonce nouvellement créée
                return $this->redirectToROute('SiteAPE_plateforme_detail', array('id'=> $annonce->getId()));
            }
        
        
        }
        //$content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:ajout.html.twig', array('annonce'=>$annonce));
        
        //On passe la méthode createView() du formulaire à la vue
        //afin qu'elle puisse afficher le formulaire toute seule
        $content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:ajout.html.twig', array('form'=>$form->createView()));
        
        
        return new Response($content);
   }

   public function modifierAction($id, Request $request)
   {
    /*  
    if($request->isMethod('POST'))
    {
        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée');
        return $this->redirectToRoute('SiteAPE_plateforme_detail');
    }

        $annonce = array('titre'   => 'Recherche développeur Symfony',
        'id'      => 1,
        'auteur'  => 'Alexandre',
        'contenu' => 'Nous recherchons un développeur Symfony débutant sur Lyon. ',
        'date'    => new \DateTime());

        //$listeCategorie = $em->getRepository('SiteAPEPlateformeBundle:Categorie')->findAll();
                            //foreach ($listeCategorie as $categorie)
                            //{
                            //    $annonce->addCategory($categorie);
                            //}

       $content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:modifier.html.twig', array('id'=>$id, 'annonce'=>$annonce));
       return new Response($content);*/

       $em = $this->getDoctrine()->getManager();
       $annonce = $em->getRepository('SiteAPEPlateformeBundle:Annonce')->find($id);

        if ($annonce === null)
        {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas");

        }
        $form = $this->createForm(AnnonceModificationType::class, $annonce);
        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                $em->persist($annonce);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
                return $this->redirectToRoute('SiteAPE_plateforme_detail', array('id'=>$annonce->getId()));
            }

        }
        $content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:modifier.html.twig', array('form'=>$form->createView()));
        return new Response($content);
                            
       
   }

   public function supprimerAction(Request $request, $id)
   {
    //$content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:supprimer.html.twig', array('id'=>$id));
    //return new Response($content);

    $em = $this->getDoctrine()->getManager();
    $annonce = $em->getRepository('SiteAPEPlateformeBundle:Annonce')->find($id);
    //$listeCompetence = $em->getRepository('SiteAPEPlateformeBundle:AnnonceCompetence')->findBy(array('annonce'=>$annonce));
    if ($annonce === null)
    {
        throw new NotFoundHttpException("L'annonce d'id ".$id."n'existe pas.");
    }

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();

    if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
    {
        
        $em->remove($annonce);
        //$em->remove($listeCompetence);
        $em->flush();

        $request->getSession()->getFlashBag()->add('info', "l'annonce a bien été supprimée");

        return $this->redirectToRoute('SiteAPE_plateforme_accueil');
    }
    $content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:supprimer.html.twig', array('annonce'=>$annonce, 'form'=>$form->createView()));
    return new Response($content);
   }

   public function menuAction()
   {
       //$listeAnnonce = array(
       //    array('id'=>2, 'titre'=>'Recherche de développeur Symfony'),
       //    array('id'=>5, 'titre'=>'Mission de Webmaster'),
       //    array('id'=>9, 'titre'=>'Offre de stage webdesigner')
       //);
       $em = $this->getDoctrine()->getManager()->getRepository('SiteAPEPlateformeBundle:Annonce');
       $listeAnnonce = $em->findBy(array(),array('id'=>'desc'),3);
       $content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:menu.html.twig', array('listeAnnonces'=>$listeAnnonce));
       return new Response($content);
   }

   public function auteuralexandreAction()
   {
       $em = $this->getDoctrine()->getManager()->getRepository('SiteAPEPlateformeBundle:Annonce');
       $listeAnnonce = $em->findBy(array('auteur'=>'Alexandre'));
       $content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:index.html.twig', array('listeAnnonces'=>$listeAnnonce));
        return new Response($content);
   }

   public function auteurpierreAction()
   {
       $em = $this->getDoctrine()->getManager()->getRepository('SiteAPEPlateformeBundle:Annonce');
       $listeAnnonce = $em->findByAuteur('Pierre');
       $content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:index.html.twig', array('listeAnnonces'=>$listeAnnonce));
        return new Response($content);
   }

   public function touteslesannoncesAction()
   {
       $repository = $this->getDoctrine()->getManager()->getRepository('SiteAPEPlateformeBundle:Annonce')->maMethodeFindAll();
       $listeAnnonce = $repository;
       $content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:index.html.twig', array('listeAnnonces'=>$listeAnnonce));
       return new Response($content);
   }

   public function auteuretmotAction()
   {
    $repository = $this->getDoctrine()->getManager()->getRepository('SiteAPEPlateformeBundle:Annonce')->FindParAuteurEtMot('Alexandre', 'développeur');
    $listeAnnonce = $repository;
    $content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:index.html.twig', array('listeAnnonces'=>$listeAnnonce));
    return new Response($content);
   }

    public function categorieAction()
    {
        $em = $this->getDoctrine()->getManager()->getRepository('SiteAPEPlateformeBundle:Categorie');
        $listeCategorie = $em->findAll();

        $content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:categorie.html.twig', array('listeCategorie'=>$listeCategorie));
        return new Response($content);
        
    }
   
   public function categoriedetailAction($id)
   {
        //$em = $this->getDoctrine()->getManager()->getRepository('SiteAPEPlateformeBundle:Categorie');
        //$categorie = $em->findById($id);
        $repository = $this->getDoctrine()->getManager()->getRepository('SiteAPEPlateformeBundle:Annonce')->getAnnonceCategorie($id);
        $listeAnnonce = $repository;
        $content = $this->get('templating')->render('SiteAPEPlateformeBundle:Annonce:annoncecategorie.html.twig', array('listeAnnonce'=>$listeAnnonce));
        return new Response($content);

   }

   


}
?>