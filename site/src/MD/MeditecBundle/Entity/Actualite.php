<?php

namespace MD\MeditecBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Actualite
 *
 * @ORM\Table(name="actualite")
 * @ORM\Entity(repositoryClass="MD\MeditecBundle\Repository\ActualiteRepository")
 */
class Actualite
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
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;
    
    /**
     * @var string
     *
     * @ORM\Column(name="lien", type="string", length=500)
     */
    private $lien;

    /**
     * @var bool
     *
     * @ORM\Column(name="publier", type="boolean")
     */
    private $publier;

    /**
     * @var int
     *
     * @Assert\Range(min = "0", minMessage  = "L'ordre doit être supérieur à 0!")
     * @ORM\Column(name="ordre", type="integer")
     */
    private $ordre;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;
    
    /**
     *
     * 
     */
    private $file;

  
    public function upload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
        if (null === $this->file) {
          return;
        }

        // On récupère le nom original du fichier de l'internaute
        $name = $this->file->getClientOriginalName();

        // On déplace le fichier envoyé dans le répertoire de notre choix
        $this->file->move($this->getUploadRootDir(), $name);

        // On sauvegarde le nom de fichier dans notre attribut $url
        $this->image = $name;
        $this->lien = $this->getUploadRootDir().'/'.$name;

        // On crée également le futur attribut alt de notre balise <img>
        //$this->alt = $name;
  }
  
  public function removeUpload()
  {
      if(NULL === $this->lien or !file_exists($this->lien)){
          return;
      }
      $unLien = $this->lien;
     
      unlink($unLien);
      
      return $this->lien;
  }

    public function getUploadDir()
    {
      // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
      return 'uploads/img_actualite';
    }

    protected function getUploadRootDir()
    {
      // On retourne le chemin relatif vers l'image pour notre code PHP 
       return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    public function getFile()
    {
      return $this->file;
    }

    public function setFile(UploadedFile $file = null)
    {
     $this->file = $file;
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
     * Set alt
     *
     * @param string $alt
     *
     * @return Actualite
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }
    
    /**
     * Set image
     *
     * @param string $image
     *
     * @return Actualite
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set lien
     *
     * @param string $lien
     *
     * @return Actualite
     */
    public function setLien($lien)
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * Get lien
     *
     * @return string
     */
    public function geLien()
    {
        return $this->lien;
    }
    
    /**
     * Set publier
     *
     * @param boolean $publier
     *
     * @return Actualite
     */
    public function setPublier($publier)
    {
        $this->publier = $publier;

        return $this;
    }

    /**
     * Get publier
     *
     * @return bool
     */
    public function getPublier()
    {
        return $this->publier;
    }
    
    /**
     * Get publier
     *
     * @return string
     */
    public function estPublie()
    {
        if($this->publier == 1){
            return "checked";
        }else{
            return "";
        }   
    }
    
    /**
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return Actualite
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

