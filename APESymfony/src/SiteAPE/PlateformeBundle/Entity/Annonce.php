<?php

namespace SiteAPE\PlateformeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="SiteAPE\PlateformeBundle\Repository\AnnonceRepository")
 * @ORM\HasLifecycleCallbacks()
 * 
 */
class Annonce
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     * @Assert\Length(min=10)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=100)
     * @Assert\Length(min=2)
     */
    private $auteur;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     * @Assert\NotBlank()
     */
    private $contenu;

    /**
     * @ORM\Column(name="publication", type="boolean")
     */
    private $publication = true;

    /**
     * @ORM\OneToOne (targetEntity ="SiteAPE\PlateformeBundle\Entity\Image", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $image;

    

    /**
     *  @ORM\ManyToMany(targetEntity="SiteAPE\PlateformeBundle\Entity\Categorie", cascade={"persist"})
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="SiteAPE\PlateformeBundle\Entity\Candidature", mappedBy="annonce")
     */
    private $candidatures;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="dateModification", type="datetime", nullable=true)
     */
    private $dateModification;

    /**
     * @ORM\Column(name="nbCandidatures", type="integer")
     */
    private $nbCandidatures;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Annonce
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Annonce
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Annonce
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Annonce
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set publication
     *
     * @param boolean $publication
     *
     * @return Annonce
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return boolean
     */
    public function getPublication()
    {
        return $this->publication;
    }

    public function __construct()
    {
        $this->date = new \Datetime();
        $this->categories = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
        $this->nbCandidatures = 0;
    }

    /**
     * Set image
     *
     * @param \SiteAPE\PlateformeBundle\Entity\Image $image
     *
     * @return Annonce
     */
    public function setImage(\SiteAPE\PlateformeBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \SiteAPE\PlateformeBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add category
     *
     * @param \SiteAPE\PlateformeBundle\Entity\Categorie $category
     *
     * @return Annonce
     */
    public function addCategory(\SiteAPE\PlateformeBundle\Entity\Categorie $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \SiteAPE\PlateformeBundle\Entity\Categorie $category
     */
    public function removeCategory(\SiteAPE\PlateformeBundle\Entity\Categorie $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add candidature
     *
     * @param \SiteAPE\PlateformeBundle\Entity\Candidature $candidature
     *
     * @return Annonce
     */
    public function addCandidature(\SiteAPE\PlateformeBundle\Entity\Candidature $candidature)
    {
        $this->candidatures[] = $candidature;

        $candidature->setAnnonce($this);
        return $this;
    }

    /**
     * Remove candidature
     *
     * @param \SiteAPE\PlateformeBundle\Entity\Candidature $candidature
     */
    public function removeCandidature(\SiteAPE\PlateformeBundle\Entity\Candidature $candidature)
    {
        $this->candidatures->removeElement($candidature);
    }

    /**
     * Get candidatures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCandidatures()
    {
        return $this->candidatures;
    }

    /**
     * Update date
     * 
     * @ORM\PreUpdate
     */
    public function majDateModification()
    {
        $this->dateModification = new \DateTime();
    }

    public function incrementerCandidature()
    {
        $this->nbCandidatures++;
    }

    public function decrementerCandidature()
    {
        $this->nbCandidatures--;
    }
}
