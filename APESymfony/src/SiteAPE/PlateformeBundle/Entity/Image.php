<?php

namespace SiteAPE\PlateformeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="SiteAPE\PlateformeBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="textealternatif", type="string", length=255)
     */
    private $textealternatif;


    
    private $fichier;


    
    private $tempFichierNom;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set textealternatif
     *
     * @param string $textealternatif
     *
     * @return Image
     */
    public function setTextealternatif($textealternatif)
    {
        $this->textealternatif = $textealternatif;

        return $this;
    }

    /**
     * Get textealternatif
     *
     * @return string
     */
    public function getTextealternatif()
    {
        return $this->textealternatif;
    }

    public function getfichier()
    {
        return $this->fichier;
    }

    public function setFichier(UploadedFile $fichier = null)
    {
        $this->fichier = $fichier;

        //On vérifie si on avait déjà un fichier pour cette entité
        if ($this->url !== null)
        {
            //On sauvegarde l'extension du fichier pour le supprimer plus tard
            $this->tempFichierNom = $this->url;
            //On réinitilise les valeurs des attributs url et texteAlternatif
            $this->url = null;
            $this->textalternatif = null;
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function Upload()
    {

        //On récupère le nom original du fichier de l'internaute
        //$nom = $this->fichier->getClientOriginalName();

        //On déplace le fichier envoyé dans le répertoire de notre choix
        //$this->file->move($this->getUploadedRootDir(), $nom);

        //On sauvegarde le nom de fichier dans notre attribut $url
        //$this->url = $nom;

        //On crée également le futur attribut alt de notre balise <img>
        //$this->alt = $nom;






        //Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
        if (null === $this->fichier)
        {
            return;
        }

        if($this->tempFichierNom !== null)
        {
            $ancienFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFichierNom;
            if(file_exists($ancienFile))
            {
                unlink($ancienFile);
            }
            
        }
        //On déplace le fichier envoyé dans le répertoire de notre choix
        $this->fichier->move(
            $this->getUploadRootDir(), //Le répertoire de desination
            $this->id.'.'.$this->url   //Le nom du fichier à créer, ici << id.extensions >>
                            );
        

    }

    public function getUploadedDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
        return 'img';
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadedDir();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        //Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
        if(null === $this->fichier)
        {
            return;
        }
            //Le nom du fichier est son id, on doit juste stocker également son extension
            //Pour faire propre, on devrait renommer cet attribut en << extension >>, plutot que << url >>
            $this->url = $this->fichier->guessExtension();

            //Et on génère l'attribut texteAlternatif de la balise <img>, à la valeur du nom
            // du fichier sur le PC de l'internaute
            $this->textealternatif = $this->fichier->getClientOriginalName();
    }

    /**
     * @ORM\PreRemove()
     * 
     */
    public function preRemoveupload()
    {
        //On sauvegarde temporairement le nom du fichier, car il dépend de l'id
        $this->tempFichier = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;

    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
        if(file_exists($this->tempFichierNom))
        {
            unlink($this->tempFichierNom);
        }
    }

    public function getChemin()
    {
        return $this->getUploadedDir().'/'.$this->getId().'.'.$this->getUrl();
    }

}

