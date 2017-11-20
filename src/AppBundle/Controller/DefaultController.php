<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        return $this->render('AppBundle:default:index.html.twig');
    }

    /**
     * @Route(
     *     "/products/{key}/{dir}",
     *     defaults={"key":"title", "dir": "asc"},
     *     name="show_products"
     * )
     */
    public function showProducts(Request $request, $key, $dir) {
        $products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findAllAsArray($key, $dir);
        return $this->render('AppBundle:default:products.html.twig', [
            'products' => $products,
            'key' => $key,
            'dir' => $dir,
        ]);
    }

    /**
     * @Route("/products/{id}", name="show_product", requirements={"id"="\d+"})
     */
    public function showProduct(Request $request, $id) {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Product');
        $product = $repo->find($id);
        return $this->render('AppBundle:default:product.html.twig', [
            'prd' => $product
        ]);
    }

    /**
     * @Route("/product_add", name="product_add")
     */
    public function addProducts(Request $request) {

        $product = new Product();
        $form = $this->createFormBuilder($product)
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('price', MoneyType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newProd = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($newProd);
            $em->flush();
        }

        return $this->render('AppBundle:default:product_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
