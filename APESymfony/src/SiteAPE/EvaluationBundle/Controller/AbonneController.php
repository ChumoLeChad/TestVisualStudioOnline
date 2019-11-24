<?php

namespace SiteAPE\EvaluationBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use SiteAPE\EvaluationBundle\Entity\Abonne;




class AbonneController extends Controller
{
    public function indexAction()
    {
        //On récupere tous les abonnés et on les passe a la vue
        $em = $this->getDoctrine()->getManager()->getRepository('SiteAPEEvaluationBundle:Abonne');
        $listeAbo = $em->findAll();

        $content = $this->get('templating')->render('SiteAPEEvaluationBundle:Abonne:listeabo.html.twig', array('listeAbo'=>$listeAbo));
        return new Response($content);
    }

    public function detailAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $abo = $em->getRepository('SiteAPEEvaluationBundle:Abonne')->find($id);

        if($abo === null)
        {
            throw new NotFoundHttpException("L'abonné d'id".$id." n'existe pas");
        }

        $content = $this->get('templating')->render('SiteAPEEvaluationBundle:Abonne:detailabo.html.twig', array('abo'=>$abo));
        return new Response($content);
    }

    public function letrombiAction()
    {
        //On recupere toutes les images de l'entitée ImageAbo
        $em = $this->getDoctrine()->getManager();
        $listeimage = $em->getRepository('SiteAPEEvaluationBundle:ImageAbo')->findAll();

        if($listeimage === null)
        {
            throw new NotFoundHttpException("L'abonné d'id".$id." n'existe pas");
        }

        $content = $this->get('templating')->render('SiteAPEEvaluationBundle:Abonne:trombinoscope.html.twig', array('listeimage'=>$listeimage));
        return new Response($content);

    }

    public function supprimerAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $abonne = $em->getRepository('SiteAPEEvaluationBundle:Abonne')->find($id);

        if ($abonne === null)
    {
        throw new NotFoundHttpException("L'abonné d'id ".$id."n'existe pas.");
    }

    $form = $this->get('form.factory')->create();

    if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
    {
        
        $em->remove($abonne);
        $em->flush();

        $request->getSession()->getFlashBag()->add('info', "l'abonné a bien été supprimée");

        return $this->redirectToRoute('SiteAPE_Evaluation_liste');
    }

    $content = $this->get('templating')->render('SiteAPEEvaluationBundle:Abonne:supprimer.html.twig', array('abo'=>$abonne, 'form'=>$form->createView()));
    return new Response($content);

    }


    public function modifierAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $abonne = $em->getRepository('SiteAPEEvaluationBundle:Abonne')->find($id);
 
         if ($abonne === null)
         {
             throw new NotFoundHttpException("L'abonné d'id ".$id." n'existe pas");
 
         }
         $form = $this->createForm(AbonneType::class, $abonne);
         if ($request->isMethod('POST'))
         {
             $form->handleRequest($request);
             if($form->isValid())
             {
                 $em->persist($abonne);
                 $em->flush();
                 $request->getSession()->getFlashBag()->add('notice', 'abonné bien enregistrée.');
                 return $this->redirectToRoute('SiteAPE_Evaluation_detail', array('id'=>$abonné->getId()));
             }
 
         }
         $content = $this->get('templating')->render('SiteAPEEvaluationBundle:Abonne:modifier.html.twig', array('form'=>$form->createView()));
         return new Response($content);

    }
}
