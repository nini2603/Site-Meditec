<?php

namespace MD\MeditecBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Newsletter
 *
 * @ORM\Table(name="newsletter")
 * @ORM\Entity(repositoryClass="MD\MeditecBundle\Repository\NewsletterRepository")
 * 
 * @UniqueEntity(fields="mail", message="Vous êtes déjà inscrit à la newsletter.")
 */
class Newsletter
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
     * @ORM\Column(name="mail", type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(message="Un e-mail doit être renseigné!")
     * @Assert\Email(strict=true, message="Le format de l'email est incorrect")
     */
    private $mail;

	public function __construct(){
	}
	

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
     * Set mail
     *
     * @param string $mail
     *
     * @return Newsletter
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }	
}

