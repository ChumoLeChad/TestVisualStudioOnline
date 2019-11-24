<?php
namespace SiteAPE\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
public function loginAction(Request $request)
{
    // Si le visiteur est déjà identifié, on le redirige vers l'accueil
    if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
    {
        return $this->redirectToRoute('SiteAPE_plateforme_accueil');
    }

    //Le service authetification_utils permet de récupérer le nom d'utilisateur
    //et l'erreur dans le cas ou le formulaire a déjà été soumis mais était invalide
    //(maivais mot de passe par exemple)

    $authentificationUtils = $this->get('security.authentication_utils');

    return $this->render('SiteAPEUserBundle:Security:login.html.twig', array('last_username'=>$authentificationUtils->getLastUsername(), 'error' => $authentificationUtils->getLastAuthenticationError()));
}

}

?>