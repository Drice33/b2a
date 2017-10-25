<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     *     "/products.{_format}",
     *     name="show_products",
     *     defaults={"_format":"html"},
     *     requirements={"_format": "html|json"}
     * )
     */
    public function showProducts(Request $request) {
        $products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findAllAsArray();

        if ($request->getRequestFormat() === 'json') {
            return new JsonResponse($products);
        }
        return $this->render('AppBundle:default:products.html.twig', [
            'products' => $products
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
     * @Route("/admin/product/add", name="product_add")
     */
    public function addProducts(Request $request) {

        return $this->render('AppBundle:default:product_add.html.twig', [

        ]);
    }

}
