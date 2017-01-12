<?php
/**
 * Created by IntelliJ IDEA.
 * User: florentingarnier
 * Date: 12/01/2017
 * Time: 23:49
 */

namespace Yooway\Home\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class HomeController
{
    public function indexAction(Request $request, Application $app)
    {
        ob_start();
        require __DIR__ . '/../View/index.php';
        $view = ob_get_clean();
        return $view;
    }
}