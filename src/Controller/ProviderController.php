<?php
namespace App\Controller;

use App\Entity\Provider;
use App\Form\ProviderFormType;
use App\Form\OptionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        $max = $data <=4;

        if ($form->isSubmitted() && $form->isValid() && $min && $max)
        {    
            if ($data == 1 )
            {
                return $this->redirectToRoute("new_provider");
            }

            else if ($data == 2 )
            {
                return $this->redirectToRoute('edit_provider');
            }

            else if ($data == 3 )
            {
                return $this->redirectToRoute('remove_provider');
            }

            else if ($data == 4)
            {
                return $this->redirectToRoute('list_providers');
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
        $provider_form-> handleRequest($request);
    }

    public function edit_provider(Request $request): Response
    {
        $provider = new Provider();
        $provider_form = $this->createForm(ProviderFormType::class, $provider);
        return $this->render('new_provider.html.twig', array('provider_form'=> $provider_form->createView()));
        $provider_form-> handleRequest($request);
    }

    public function remove_provider(Request $request): Response
    {
        $provider = new Provider();
        $provider_form = $this->createForm(ProviderFormType::class, $provider);
        return $this->render('new_provider.html.twig', array('provider_form'=> $provider_form->createView()));
        $provider_form-> handleRequest($request);
    }

    /**
    * @Route("/list_providers",name ="list_providers")
    */

    public function list_providers(ManagerRegistry $doctrine, int $id): Response
    {
        $provider = $doctrine->getRepository(Provider::class)->find($id);

        if (!$provider) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$provider->getName());
    }
}