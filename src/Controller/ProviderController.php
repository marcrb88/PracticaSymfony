<?php
namespace App\Controller;

use App\Entity\Provider;
use App\Form\ProviderFormType;
use App\Form\OptionFormType;
use App\Form\IdFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This class implements all those methods to manage the HTTP petitions in order to 
 * process and answer them.  
 * @author  Marc Roigé
 * @version 14/5/2022
 */
class ProviderController extends AbstractController
{
   /**
    * This function generates the main menu where the user can select an option of the 
    * shown list 
    * @param request Allow us to handle the request
    * @Route("/", name ="main_menu")
    */
    public function main_menu(Request $request): Response
    {
        
        $defaultData = ['message' => 'Eleccio opcio'];
        $form = $this->createForm(OptionFormType::class, $defaultData);
        $form-> handleRequest($request);

        $data = $form->get('option')->getData();

        $min = $data >=1;
        $max = $data <=4;

        if ($form->isSubmitted() && $form->isValid() && $min && $max)
        {    
            if ($data == 1 )
            {
                return $this->redirectToRoute("new_provider");
            }

            else if ($data == 2 || $data == 3)
            {
                return $this->redirect($this->generateUrl("choice_edit_delete", array("data" => $data)));

            }

            else if ($data == 4)
            {
                return $this->redirect("providers_list");
            }

        }

        if ($min >=1 || $max <=4 ){
            $this->addFlash(
               'error',
               'La opcio escollida no es troba en el rang indicat. Torna a intentar-ho.'
            );
        }

        return $this->render('menu.html.twig', array('option_form'=> $form->createView()));
        
        
        exit();
    }

    /**
     * This function provides us the form fields to create a new provider.
     * @param request Allow us to handle the request
    * @Route("/new_provider",name ="new_provider")
    */
    public function new_provider(Request $request): Response
    {   
        
        $provider = new Provider();
        $provider_form = $this->createForm(ProviderFormType::class, $provider);
        $provider_form-> handleRequest($request);

        if ($provider_form->isSubmitted() && $provider_form->isValid())
        { 
            $time = date('H:i:s \O\n d/m/Y');
            $em = $this->getDoctrine()->getManager();
            $em->persist($provider);
            $em->flush();

            return new Response('El proveïdor amb id:'.$provider->getId().' sha guardat correctament a la BD amb les següents dades:'.'<br>'.
            'Nom: '.$provider->getName().'<br>'.'Email: '.$provider->getEmail().'<br>'.'Phone: '.$provider->getPhone().
            '<br>'.'TipusProveïdor(1-Hotel/2-Pista/3-Complement): '.$provider->getProviderType()
            .'<br>'.'Actiu (1-Activat/0-Desactivat): '.$provider->getActive().'<br>'.'Moment de creació: '.$time);

        }
        return $this->render('new_provider.html.twig', array(
            'provider_form'=> $provider_form->createView()
        ));
    }

   
    /**
    * This function allow us to edit a provider. It asks us again for the provider form
    * fields in order to generate the edition. 
    * @param request Allow us to handle the request
    * @param provider_id Id of the object we want to edit
    * @Route("/edit_provider/{provider_id}", name ="edit_provider")
    */
    public function edit_provider(Request $request, $provider_id): Response
    {
        $provider = new Provider();
        $provider_form = $this->createForm(ProviderFormType::class, $provider);
        $provider_form-> handleRequest($request);

        if ($provider_form->isSubmitted() && $provider_form->isValid())
        {   
            $time = date('H:i:s \O\n d/m/Y');
            $name = $provider_form->get('name')->getData();
            $email = $provider_form->get('email')->getData();
            $phone = $provider_form->get('phone')->getData();
            $provider_type = $provider_form->get('provider_type')->getData();
            $active = $provider_form->get('active')->getData();

            $em = $this->getDoctrine()->getManager();
            $provider = $em->getRepository(Provider::class)->find($provider_id);
            $provider->setName($name);
            $provider->setEmail($email);
            $provider->setPhone($phone);
            $provider->setProviderType($provider_type);
            $provider->setActive($active);
            $em->flush();

            return new Response('El proveïdor amb ID: '.$provider_id.' sha editat correctament'
            .'<br>'."Moment de l'edició: ".$time);
        }

        return $this->render('edit_provider.html.twig', array('provider_form'=> $provider_form->createView()));

    }

    /**
    * Removes the provider (ID) passed by parameter
    * @param provider_id ID of the object we want to remove of our system
    * @Route("/delete_provider/{provider_id}", name ="delete_provider")
    */
    public function delete_provider($provider_id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $provider = $em->getRepository(Provider::class)->find($provider_id);
        $em->remove($provider);
        $em->flush();

        return new Response('El proveïdor amb ID: '.$provider_id.' sha eliminat correctament');

    }

     /**
    * Show the providers list we have in our system
    * @Route("/providers_list"), name="providers_list")
    */
    public function providers_list():Response
    {
        $providers = $this->getDoctrine()
        ->getRepository(Provider::class)
        ->findAll();


    return $this->render(
        'providers_list.html.twig',
        array('providers' => $providers)
    );
    
    }

    /**
    * Generates an Integer field in order to allow the user to select the ID of the object
    * @param request Allow us to handle the request
    * @param data Specify if we are in the edit or delete option.
    * @Route("/choice_edit_delete/{data}", name ="choice_edit_delete")
    */
    public function choice_edit_delete(Request $request, $data): Response
    {
        $defaultData = ['message' => 'ID a cercar'];
        $id_form = $this->createForm(IdFormType::class, $defaultData);
        $id_form-> handleRequest($request);
        $provider_id = $id_form->get('provider_id')->getData();
        
        if ($id_form->isSubmitted() && $id_form->isValid())
        {   
            if ($data == 2)
            {
                return $this->redirect($this->generateUrl("edit_provider", array("provider_id" => $provider_id)));
            }
            else if ( $data == 3)
            {
                return $this->redirect($this->generateUrl("delete_provider", array("provider_id" => $provider_id)));
            }
        }

        return $this->render('provider_id.html.twig', array('id_form'=> $id_form->createView()));
    }
}