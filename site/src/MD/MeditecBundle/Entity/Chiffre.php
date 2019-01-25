<?php

namespace MD\MeditecBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chiffre
 *
 * @ORM\Table(name="chiffre")
 * @ORM\Entity(repositoryClass="MD\MeditecBundle\Repository\ChiffreRepository")
 */
class Chiffre
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
     * @var int
     *
     * @ORM\Column(name="chiffre", type="integer")
     */
    private $chiffre;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=255)
     */
    private $intitule;

    /**
     * @var int
     *
     * @ORM\Column(name="ordre", type="integer")
     */
    private $ordre;


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
     * Set chiffre
     *
     * @param integer $chiffre
     *
     * @return Chiffre
     */
    public function setChiffre($chiffre)
    {
        $this->chiffre = $chiffre;

        return $this;
    }

    /**
     * Get chiffre
     *
     * @return int
     */
    public function getChiffre()
    {
        return $this->chiffre;
    }

    /**
     * Set intitule
     *
     * @param string $intitule
     *
     * @return Chiffre
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return Chiffre
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return int
     */
    public function getOrdre()
    {
        return $this->ordre;
    }
}

