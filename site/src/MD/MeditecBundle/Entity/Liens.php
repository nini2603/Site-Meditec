<?php

namespace MD\MeditecBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Liens
 *
 * @ORM\Table(name="liens")
 * @ORM\Entity(repositoryClass="MD\MeditecBundle\Repository\LiensRepository")
 */
class Liens
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
     * @ORM\Column(name="Nom_Page", type="string", length=100)
     */
    private $nomPage;

    /**
     * @var bool
     *
     * @ORM\Column(name="Visible", type="boolean")
     */
    private $visible;


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
     * Set nomPage
     *
     * @param string $nomPage
     *
     * @return Liens
     */
    public function setNomPage($nomPage)
    {
        $this->nomPage = $nomPage;

        return $this;
    }

    /**
     * Get nomPage
     *
     * @return string
     */
    public function getNomPage()
    {
        return $this->nomPage;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     *
     * @return Liens
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return bool
     */
    public function getVisible()
    {
        return $this->visible;
    }
}

