<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class defines our entity: Provider with the corresponent attributes and 
 * getters/setters. In addition, I have builded a database thanks to Doctrine ORM that 
 * supports mysql db manager. My database is called provider, it's primary
 * key is 'Id' and contains all those Provider's created by the user. 
 * @author  Marc Roigé
 * @version 14/5/2022
 * @ORM\Entity(repositoryClass="App\Repository\ProviderRepository")
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
    * @ORM\Column(type="integer", length=12)
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

   /**
    * Name getter
    */
   public function getName()
   {
       return $this->name;
   }

   /**
    * Name setter
    * @param name Provider's name
    */
   public function setName($name)
   {
       $this->name = $name;
   }

   /**
    * Email getter
    */
   public function getEmail()
   {
       return $this->email;
   }

   /**
    * Email setter
    * @param email Provider's email
    */
   public function setEmail($email)
   {
       $this-> email = $email;
   }

   /**
    * Phone getter
    */
   public function getPhone()
   {
       return $this->phone;
       
   }

   /**
    * Phone setter
    * @param phone Provider's phone
    */
   public function setPhone($phone)
   {
       $this->phone = $phone;
   }

   /**
    * ProviderType getter
    */
   public function getProviderType()
   {
       return $this->provider_type;
   }

   /**
    * ProviderType setter
    * @param provider_type Provider's type
    */
   public function setProviderType($provider_type)
   {
       $this->provider_type = $provider_type;
   }

   /**
    * Active getter
    */
   public function getActive()
   {
       return $this->active;
   }

   /**
    * Active setter
    * @param active Provider's active
    */
   public function setActive($active)
   {
       $this->active = $active;
   }

   /**
    * Id getter
    */
   public function getId(): ?int
   {
       return $this->id;
   }

   /**
    * Id setter
    * @param id Provider's id
    */
   public function setId($id)
   {
       $this -> id = $id;
   }

}
