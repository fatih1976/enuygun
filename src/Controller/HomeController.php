<?php
/**
 * Created by PhpStorm.
 * User: fatihyilmaz
 * Date: 12/10/18
 * Time: 10:27 PM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Currency;

class HomeController extends AbstractController
{

    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Currency::class);
        $fx_rates = $repository->findOneBy([], ['id' => 'DESC'])->getDetay();

        return $this->render('home.html.twig', array('fx_rates' => $fx_rates));

        return new Response('En son pariteler: '. print_r($fx_rates,true));


    }

}