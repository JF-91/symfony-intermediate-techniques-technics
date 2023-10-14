<?php

namespace App\Controller;

use App\DTO\ProductDto;
use App\Entity\Product;
use App\Factory\ProductFactory;
use App\Form\ProductBuilder;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationController extends AbstractController
{

    //autowired interfaces or classes
    private $manager;
    private ProductFactory $productFactory;
    private ProductRepository $productRepository;

    //constructor
    public function __construct(
        EntityManagerInterface $manager,
        ProductFactory $productFactory,
        ProductRepository $productRepository) {

        $this->manager = $manager; 
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
    }


    //my methods controllers 

    #[Route('/', name: 'app_application', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function index(Request $request): Response
    {

        $productDto = new ProductDto();
        //$product = $this->manager->getRepository(Product::class)->findAllOrderedByName();
        $keywordForm = $this->createForm(ProductBuilder::class, $productDto);
        $keywordForm->handleRequest($request);

        if($keywordForm->isSubmitted() && $keywordForm->isValid()) {

            $product = new Product();
            $product->setTitle($productDto->getTitle());
            $product->setPrice($productDto->getPrice());
            $product->setDescription($productDto->getDescription());
            $this->manager->persist($product);
            $this->manager->flush();
        }

        return $this->render('application/index.html.twig', [
            'keywordForm' => $keywordForm->createView(),
        ]);

    }

    #[Route(path: '/create', name: 'app_create', methods: ['POST'])]
    public function create(Product $product, Request $request): Response
    {
        $product = $this->productFactory->create();
        $productFrom = $this->createForm(ProductFormType::class, $product);
        $productFrom->handleRequest($request);

        if ($productFrom->isSubmitted() && $productFrom->isValid()) {
            $this->manager->persist($product);
            $this->manager->flush();
            return $this->redirectToRoute('app_application');
        }
    }

    




}
