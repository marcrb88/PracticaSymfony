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
use Doctrine\Persistence\ManagerRegistry;

class ProviderController extends AbstractController
{
   /**
    * @Route("/", name ="main_menu")
    */
    public function main_menu(Request $request): Response
    {
        
        $defaultData = ['message' => 'Eleccio opcio'];
        $form = $this->createForm(OptionFormType::class, $defaultData);
        $form-> handleRequest($request);

        $data = $form->get('option')->getData();

        $min = $data >=1;
        $max = $data <=5;

        if ($form->isSubmitted() && $form->isValid() && $min && $max)
        {    
            if ($data == 1 )
            {
                return $this->redirectToRoute("new_provider");
            }

            else if ($data == 2 || $data == 3)
            {
                #return $this->redirectToRoute("choice_id_edit");
                return $this->redirect($this->generateUrl("choice_edit_delete", array("data" => $data)));

            }

            else if ($data == 4)
            {
                return $this->redirect("providers_list");
            }

            else if ($data == 5)
            {
                return $this->redirect("provider_list");
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
    * @Route("/new_provider",name ="new_provider")
    */
    public function new_provider(Request $request): Response
    {
        $provider = new Provider();
        $provider_form = $this->createForm(ProviderFormType::class, $provider);
        $provider_form-> handleRequest($request);

        if ($provider_form->isSubmitted() && $provider_form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($provider);
            $em->flush();

            return new Response('El proveïdor amb id:'.$provider->getId().' sha guardat correctament a la BD amb les següents dades:'.'<br>'.
            $provider->getName().'<br>'.$provider->getEmail().'<br>'.$provider->getPhone().'<br>'.$provider->getProviderType()
            .'<br>'.$provider->getActive());

        }

        return $this->render('new_provider.html.twig', array('provider_form'=> $provider_form->createView()));
    }

   
/**
    * @Route("/edit_provider/{provider_id}", name ="edit_provider")
    */
    public function edit_provider(Request $request, $provider_id): Response
    {
        if (!$provider_id) {
            throw $this->createNotFoundException('No sha trobat cap proveïdor amb aquest ID');
        }

        $provider = new Provider();
        $provider_form = $this->createForm(ProviderFormType::class, $provider);
        $provider_form-> handleRequest($request);

        if ($provider_form->isSubmitted() && $provider_form->isValid())
        {   
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

            return new Response('El proveïdor amb ID: '.$provider_id.' sha editat correctament');
        }

        return $this->render('edit_provider.html.twig', array('provider_form'=> $provider_form->createView()));

    }

    /**
    * @Route("/delete_provider/{provider_id}", name ="delete_provider")
    */
    public function delete_provider($provider_id): Response
    {
        if (!$provider_id) {
            throw $this->createNotFoundException('No sha trobat cap proveïdor amb aquest ID');
        }
        $em = $this->getDoctrine()->getManager();
        $provider = $em->getRepository(Provider::class)->find($provider_id);
        $em->remove($provider);
        $em->flush();

        return new Response('El proveïdor amb ID: '.$provider_id.' sha eliminat correctament');

    }

    /**
    * @Route("/provider_list"), name="provider_list")
    */
    public function provider_list(ManagerRegistry $doctrine)
    {
        $provider = $doctrine->getRepository(Provider::class)->find(22);

        return new Response('Check out this great product: '.$provider->getName().$provider->getEmail());
    
    }


     /**
    * @Route("/providers_list"), name="providers_list")
    */
    public function providers_list(ManagerRegistry $doctrine)
    {
        $provider = $doctrine->getRepository(Provider::class)->find(22);

        return new Response();
    
    }



    /**
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