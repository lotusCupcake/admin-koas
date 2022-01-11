<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use Psr\Log\LoggerInterface;



/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $usersModel;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['auth'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    public function fetchMenu()
    {
        $this->usersModel = new UsersModel();
        $id_loggedin = user()->id;
        $usr = $this->usersModel->getSpecificUser(['users.id' => $id_loggedin])->getResult()[0]->name;
        // dd($usr);
        $data = file_get_contents(ROOTPATH . $this->getFile($usr));

        $data = json_decode($data, false);

        $titles = [];
        $parents = [];
        $childs = [];

        foreach ($data as $resource) {
            if ($resource->parent == 0 && $resource->level == 'title') {
                $titles[] = $resource;
            }

            if ($resource->parent != 0 && $resource->level == 'parent') {
                $parents[] = $resource;
            }

            if ($resource->parent != 0 && $resource->level == 'child') {
                $childs[] = $resource;
            }
        }

        $menu = "";
        foreach ($titles as $title) {
            $menu .= '<li class="menu-header">' . $title->nama . '</li>';

            foreach ($parents as $parent) {
                if ($title->id == $parent->parent) {
                    if ($parent->status) {
                        $menu .= '<li class="nav-item dropdown"><a href="' . $parent->pages . '" class="nav-link has-dropdown"><i class="' . $parent->icon . '"></i> <span>' . $parent->nama . '</span></a><ul class="dropdown-menu">';
                    } else {
                        $menu .= '<li class="nav-item dropdown"><a href="/maintenance" class="nav-link has-dropdown"><i class="' . $parent->icon . '"></i><span>' . $parent->nama . '</span></a><ul class="dropdown-menu">';
                    }

                    foreach ($childs as $child) {
                        if ($parent->id == $child->parent) {
                            if ($child->status) {
                                $menu .= '<li><a class="nav-link" href="' . $child->pages . '"><i class="' . $child->icon . '"></i><span>' . $child->nama . '</span></a></li>';
                            } else {
                                $menu .= '<li><a class="nav-link" href="/maintenance"><i class="' . $child->icon . '"></i><span>' . $child->nama . '</span></a></li>';
                            }
                        }
                    }
                    $menu .= '</ul></li>';
                }
            }
            foreach ($childs as $child) {
                if ($title->id == $child->parent) {
                    if ($child->status) {
                        $menu .= '<li><a class="nav-link" href="' . $child->pages . '"><i class="' . $child->icon . '"></i> <span>' . $child->nama . '</span></a></li>';
                    } else {
                        $menu .= '<li><a class="nav-link" href="/maintenance"><i class="' . $child->icon . '"></i><span>   ' . $child->nama . '</span></a><ul>';
                    }
                }
            }
        }

        return $menu;
    }

    public function getFile($usr)
    {
        switch ($usr) {
            case "superadmin":
                $file = "public/menu/menu.json";
                break;
            case "admin":
                $file = "public/menu/menuadmin.json";
                break;
            case "dosen":
                $file = "public/menu/menudosen.json";
                break;
            case "prodi":
                $file = "public/menu/menuprodi.json";
                break;
            case "koordik":
                $file = "public/menu/menukoordik.json";
                break;
            default:
                $file = "public/menu/menu.json";
        }
        return $file;
    }
}
