<?php

namespace App\Entity;

use App\Repository\ProviderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProviderRepository::class)
 */
class Provider
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=40)
    */
   private $name;

   /**
    * @ORM\Column(type="string", length=40)
    */
   private $email;

    /**
    * @ORM\Column(type="integer")
    */
   private $phone;

    /**
    * @ORM\Column(type="string")
    */

   private $provider_type;

    /**
    * @ORM\Column(type="boolean")
    */

   private $active;

   public function getName()
   {
       return $this->name;
   }

   public function setName($name)
   {
       $this->name = $name;
   }

   public function getEmail()
   {
       return $this->email;
   }

   public function setEmail($email)
   {
       $this-> email = $email;
   }

   public function getPhone()
   {
       return $this->phone;
       
   }

   public function setPhone($phone)
   {
       $this->phone = $phone;
   }

   public function getProviderType()
   {
       return $this->provider_type;
   }

   public function setProviderType($provider_type)
   {
       $this->provider_type = $provider_type;
   }

   public function getActive()
   {
       return $this->active;
   }
   public function setActive($active)
   {
       $this->active = $active;
   }

   public function getId(): ?int
   {
       return $this->id;
   }

   public function setId($id)
   {
       $this -> id = $id;
   }
}
