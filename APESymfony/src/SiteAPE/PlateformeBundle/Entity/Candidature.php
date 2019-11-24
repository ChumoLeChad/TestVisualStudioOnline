<?php

namespace SiteAPE\PlateformeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidature
 *
 * @ORM\Table(name="candidature")
 * @ORM\Entity(repositoryClass="SiteAPE\PlateformeBundle\Repository\CandidatureRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Candidature
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
     * @ORM\Column(name="candidat", type="string", length=255)
     */
    private $candidat;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="SiteAPE\PlateformeBundle\Entity\Annonce", inversedBy="candidatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $annonce;


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
     * Set candidat
     *
     * @param string $candidat
     *
     * @return Candidature
     */
    public function setCandidat($candidat)
    {
        $this->candidat = $candidat;

        return $this;
    }

    /**
     * Get candidat
     *
     * @return string
     */
    public function getCandidat()
    {
        return $this->candidat;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Candidature
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Candidature
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
     * Set annonce
     *
     * @param \SiteAPE\PlateformeBundle\Entity\Annonce $annonce
     *
     * @return Candidature
     */
    public function setAnnonce(\SiteAPE\PlateformeBundle\Entity\Annonce $annonce)
    {
        $this->annonce = $annonce;

        return $this;
    }

    /**
     * Get annonce
     *
     * @return \SiteAPE\PlateformeBundle\Entity\Annonce
     */
    public function getAnnonce()
    {
        return $this->annonce;
    }

    public function __construct()
    {
        $this->date = new \Datetime();
    }

    /**
     * @ORM\PrePersist
     */
    public function incrementer()
    {
        $this->getAnnonce()->incrementerCandidature();
    }
    /**
     * @ORM\PreRemove
     */
    public function decrementer()
    {
        $this->getAnnonce()->decrementerCandidature();
    }
}
