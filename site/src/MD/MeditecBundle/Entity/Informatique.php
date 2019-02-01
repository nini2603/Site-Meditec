<?php

namespace MD\MeditecBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Informatique
 *
 * @ORM\Table(name="informatique")
 * @ORM\Entity(repositoryClass="MD\MeditecBundle\Repository\InformatiqueRepository")
 */
class Informatique
{
    public function __construct() {
        $this->chemin1 = "#";
        $this->chemin2 = "#";
        $this->chemin3 = "#";
        $this->chemin4 = "#";
    }

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
     * @ORM\Column(name="image", type="string", length=500)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="lien", type="string", length=500)
     */
    private $lien;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=455)
     */
    private $text;
    
    /**
     * @var string
     *
     * @ORM\Column(name="icone1", type="string", length=50)
     */
    private $icone1;

    /**
     * @var string
     *
     * @ORM\Column(name="titre1", type="string", length=50)
     */
    private $titre1;

    /**
     * @var string
     *
     * @ORM\Column(name="chemin1", type="string", length=50)
     */
    private $chemin1;

    /**
     * @var string
     *
     * @ORM\Column(name="text1", type="string", length=255)
     */
    private $text1;

    /**
     * @var string
     *
     * @ORM\Column(name="icone2", type="string", length=50)
     */
    private $icone2;

    /**
     * @var string
     *
     * @ORM\Column(name="titre2", type="string", length=50)
     */
    private $titre2;

    /**
     * @var string
     *
     * @ORM\Column(name="chemin2", type="string", length=50)
     */
    private $chemin2;

    /**
     * @var string
     *
     * @ORM\Column(name="text2", type="string", length=255)
     */
    private $text2;

    
    /**
     * @var string
     *
     * @ORM\Column(name="icone3", type="string", length=50)
     */
    private $icone3;

    /**
     * @var string
     *
     * @ORM\Column(name="titre3", type="string", length=50)
     */
    private $titre3;

    /**
     * @var string
     *
     * @ORM\Column(name="chemin3", type="string", length=50)
     */
    private $chemin3;

    /**
     * @var string
     *
     * @ORM\Column(name="text3", type="string", length=255)
     */
    private $text3;


    /**
     * @var string
     *
     * @ORM\Column(name="icone4", type="string", length=50)
     */
    private $icone4;

    /**
     * @var string
     *
     * @ORM\Column(name="titre4", type="string", length=50)
     */
    private $titre4;

    /**
     * @var string
     *
     * @ORM\Column(name="chemin4", type="string", length=50)
     */
    private $chemin4;

    /**
     * @var string
     *
     * @ORM\Column(name="text4", type="string", length=255)
     */
    private $text4;

    /**
     * @var bool
     *
     * @ORM\Column(name="visible", type="boolean")
     */
    private $visible;

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
      return 'uploads/img_informatique';
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
     * Set image
     *
     * @param string $image
     *
     * @return Informatique
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
     * Get visible
     *
     * @return bool
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     *
     * @return Informatique
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Set lien
     *
     * @param string $lien
     *
     * @return Informatique
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
    public function getLien()
    {
        return $this->lien;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Informatique
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
     * Set titre
     *
     * @param string $titre
     *
     * @return Informatique
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
     * Set text
     *
     * @param string $text
     *
     * @return Informatique
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
    
    /**
     * Set icone1
     *
     * @param string $icone1
     *
     * @return Informatique
     */
    public function setIcone1($icone1)
    {
        $this->icone1 = $icone1;

        return $this;
    }

    /**
     * Get icone1
     *
     * @return string
     */
    public function getIcone1()
    {
        return $this->icone1;
    }

    /**
     * Set titre1
     *
     * @param string $titre1
     *
     * @return Informatique
     */
    public function setTitre1($titre1)
    {
        $this->titre1 = $titre1;

        return $this;
    }

    /**
     * Get titre1
     *
     * @return string
     */
    public function getTitre1()
    {
        return $this->titre1;
    }

    /**
     * Set chemin1
     *
     * @param string $chemin1
     *
     * @return Informatique
     */
    public function setChemin1($chemin1)
    {
        $this->chemin1 = $chemin1;

        return $this;
    }

    /**
     * Get chemin1
     *
     * @return string
     */
    public function getChemin1()
    {
        return $this->chemin1;
    }

    /**
     * Set text1
     *
     * @param string $text1
     *
     * @return Informatique
     */
    public function setText1($text1)
    {
        $this->text1 = $text1;

        return $this;
    }

    /**
     * Get text1
     *
     * @return string
     */
    public function getText1()
    {
        return $this->text1;
    }

    /**
     * Set icone2
     *
     * @param string $icone2
     *
     * @return Informatique
     */
    public function setIcone2($icone2)
    {
        $this->icone2 = $icone2;

        return $this;
    }

    /**
     * Get icone2
     *
     * @return string
     */
    public function getIcone2()
    {
        return $this->icone2;
    }

    /**
     * Set titre2
     *
     * @param string $titre2
     *
     * @return Informatique
     */
    public function setTitre2($titre2)
    {
        $this->titre2 = $titre2;

        return $this;
    }

    /**
     * Get titre2
     *
     * @return string
     */
    public function getTitre2()
    {
        return $this->titre2;
    }

    /**
     * Set chemin2
     *
     * @param string $chemin2
     *
     * @return Informatique
     */
    public function setChemin2($chemin2)
    {
        $this->chemin2 = $chemin2;

        return $this;
    }

    /**
     * Get chemin2
     *
     * @return string
     */
    public function getChemin2()
    {
        return $this->chemin2;
    }

    /**
     * Set text2
     *
     * @param string $text2
     *
     * @return Informatique
     */
    public function setText2($text2)
    {
        $this->text2 = $text2;

        return $this;
    }

    /**
     * Get text2
     *
     * @return string
     */
    public function getText2()
    {
        return $this->text2;
    }
    
    /**
     * Set icone3
     *
     * @param string $icone3
     *
     * @return Informatique
     */
    public function setIcone3($icone3)
    {
        $this->icone3 = $icone3;

        return $this;
    }

    /**
     * Get icone3
     *
     * @return string
     */
    public function getIcone3()
    {
        return $this->icone3;
    }

    /**
     * Set titre3
     *
     * @param string $titre3
     *
     * @return Informatique
     */
    public function setTitre3($titre3)
    {
        $this->titre3 = $titre3;

        return $this;
    }

    /**
     * Get titre3
     *
     * @return string
     */
    public function getTitre3()
    {
        return $this->titre3;
    }

    /**
     * Set chemin3
     *
     * @param string $chemin3
     *
     * @return Informatique
     */
    public function setChemin3($chemin3)
    {
        $this->chemin3 = $chemin3;

        return $this;
    }

    /**
     * Get chemin3
     *
     * @return string
     */
    public function getChemin3()
    {
        return $this->chemin3;
    }

    /**
     * Set text3
     *
     * @param string $text3
     *
     * @return Informatique
     */
    public function setText3($text3)
    {
        $this->text3 = $text3;

        return $this;
    }

    /**
     * Get text3
     *
     * @return string
     */
    public function getText3()
    {
        return $this->text3;
    }
    //-----------------------
    /**
     * Set icone4
     *
     * @param string $icone4
     *
     * @return Informatique
     */
    public function setIcone4($icone4)
    {
        $this->icone4 = $icone4;

        return $this;
    }

    /**
     * Get icone4
     *
     * @return string
     */
    public function getIcone4()
    {
        return $this->icone4;
    }

    /**
     * Set titre4
     *
     * @param string $titre4
     *
     * @return Informatique
     */
    public function setTitre4($titre4)
    {
        $this->titre4 = $titre4;

        return $this;
    }

    /**
     * Get titre4
     *
     * @return string
     */
    public function getTitre4()
    {
        return $this->titre4;
    }

    /**
     * Set chemin4
     *
     * @param string $chemin4
     *
     * @return Informatique
     */
    public function setChemin4($chemin4)
    {
        $this->chemin4 = $chemin4;

        return $this;
    }

    /**
     * Get chemin4
     *
     * @return string
     */
    public function getChemin4()
    {
        return $this->chemin4;
    }

    /**
     * Set text4
     *
     * @param string $text4
     *
     * @return Informatique
     */
    public function setText4($text4)
    {
        $this->text4 = $text4;

        return $this;
    }

    /**
     * Get text4
     *
     * @return string
     */
    public function getText4()
    {
        return $this->text4;
    }
}

