<?php
namespace SiteAPE\PlateformeBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="annonce_competence")
 */
class AnnonceCompetences
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="niveau", type="string", length=255)
     */
    private $niveau;

    /**
     * @ORM\ManyToOne(targetEntity="SiteAPE\PlateformeBundle\Entity\Annonce")
     * @ORM\JoinColumn(nullable=false)
     */
    private $annonce;

    /**
     * @ORM\ManyToOne(targetEntity="SiteAPE\PlateformeBundle\Entity\Competence")
     * @ORM\JoinColumn(nullable=false)
     */

    private $competence;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set niveau
     *
     * @param string $niveau
     *
     * @return AnnonceCompetence
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return string
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set annonce
     *
     * @param \SiteAPE\PlateformeBundle\Entity\Annonce $annonce
     *
     * @return AnnonceCompetence
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

    /**
     * Set competence
     *
     * @param \SiteAPE\PlateformeBundle\Entity\Competence $competence
     *
     * @return AnnonceCompetence
     */
    public function setCompetence(\SiteAPE\PlateformeBundle\Entity\Competence $competence)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get competence
     *
     * @return \SiteAPE\PlateformeBundle\Entity\Competence
     */
    public function getCompetence()
    {
        return $this->competence;
    }
}
