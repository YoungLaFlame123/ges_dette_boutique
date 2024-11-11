<?php

// src/Controller/ClientController.php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client/new', name: 'client.new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($client);
            $entityManager->flush();

            // Rediriger vers la liste des clients après la création
            return $this->redirectToRoute('clients.list');
        }

        return $this->render('client/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/clients', name: 'clients.list', methods: ['GET'])]
    public function list(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $clients = $entityManager->getRepository(Client::class)->findAll();

        return $this->render('client/list.html.twig', [
            'clients' => $clients,
        ]);
    }

    #[Route('/client/edit/{id}', name: 'client.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $client->setUpdateAt(new \DateTime()); // Met à jour la date de mise à jour
            $entityManager->flush();

            // Rediriger vers la liste des clients après la modification
            return $this->redirectToRoute('clients.list');
        }

        return $this->render('client/edit.html.twig', [
            'form' => $form->createView(),
            'client' => $client,
        ]);
    }
}