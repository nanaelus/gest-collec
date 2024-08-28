<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
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
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    protected $router;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $session;
    protected $start_session = true;



    protected $require_auth = true;


    /**
     * Page Title
     *
     * $title : title on the paghe
     * $title_prefix : automaticaly prefix added
     */
    protected $title = 'Home';

    protected $title_prefix = 'V17Mag';

    /**
     * Menu Management
     */
    protected $menus;

    protected $breadcrumb = [];
    protected $menu       = 'accueil';
    protected $mainmenu;

    /**
     * Messaging
     * messages : list of message to display
     * toastr : use js toaster to display messages
     */
    protected $messages = [];

    protected $toastr = true;

    protected function menus()
    {
        if (! $this->menus) {
            $this->menus = json_decode(file_get_contents(APPPATH . 'Menus/admin.json'), true);
        }

        return $this->menus;
    }

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        if ($this->start_session){
            log_message('debug','start session');
            $this->session = session();
            // Use flashdata for messages
            if (session()->has('messages')) {
                $this->messages = session()->getFlashdata('messages');
            }
        }
        $this->router  = service('router');

        // Vérifier l'authentification si nécessaire
        if ($this->require_auth) {
            $this->checkLogin();
        }
    }

    /**
     * Check if the user is authenticated.
     */
    protected function checkLogin($redirect = true)
    {
        if (!isset($this->session->user)) {
            if ($redirect) {
                $this->session->set('redirect_url', current_url(true)->getPath()); // Save the current URL for redirection after login
                return $this->redirect('/login');
            }
            return false;
        }
        return true;
    }

    public function logout()
    {
        if (isset($this->session->user)) {
            $this->session->remove('user');
        }

        $this->success('Déconnexion réussie.');

        // Rediriger l'utilisateur vers la page de connexion ou une autre page
        return $this->redirect('/login');
    }

    /**
     * Redirection
     * redirect to the page, every path component can be passed as au parameters
     * ex: $this->redirect('controller','methoid','param1', 'param2')
     *  => /controller/method/param1/param2
     */
    public function redirect(string $url, array $data = [])
    {
        //$url = implode('/', array_slice(func_get_args(), 1));
        $url = base_url($url);

        // Store messages in flashdata
        if (count($this->messages) > 0) {
            session()->setFlashdata('messages', $this->messages);
        }

        // Store additional data in flashdata
        if (!empty($data)) {
            session()->setFlashdata('data', $data);
        }
        header("Location: {$url}");
        exit; /** @phpstan-ignore-line */
    }
    /**
     * View
     * Efficient view system
     *
     * @param string|null $vue
     * @param array|null  $datas
     */
    public function view($vue = null, $datas = [], $admin = false)
    {
        $connected = isset($this->session->user);
        $template_dir = ($admin) ? "/templates/admin/" : "/templates/front/";

        // Merge flashdata with existing $datas
        $flashData = session()->getFlashdata('data');
        if ($flashData) {
            $datas = array_merge($datas, $flashData);
        }
        return view(
                $template_dir . 'head',
                [
                    'template_dir' => $template_dir,
                    'show_menu' => $connected,
                    'mainmenu' => $this->mainmenu,
                    'breadcrumb' => $this->breadcrumb,
                    'localmenu' => $this->menu,
                    'user' => ($this->session->user ?? null),
                    'menus' => $this->menus(),
                    'title' => sprintf('%s : %s', $this->title, $this->title_prefix)
                ]
            )
            . (($vue !== null) ? view($vue, $datas) : '')
            . view($template_dir . 'footer', ['messages' => $this->messages]);
    }


    public function success($txt)
    {
        log_message('debug', $txt);
        $this->messages[] = ['txt' => $txt, 'class' => 'alert-success', 'toast' => 'success'];
    }

    public function message($txt)
    {
        log_message('debug', $txt);
        $this->messages[] = ['txt' => $txt, 'class' => 'alert-info', 'toast' => 'info'];
    }

    public function warning($txt)
    {
        log_message('debug', $txt);
        $this->messages[] = ['txt' => $txt, 'class' => 'alert-warning', 'toast' => 'warning'];
    }

    public function error($txt)
    {
        log_message('debug', $txt);
        $this->messages[] = ['txt' => $txt, 'class' => 'alert-danger', 'toast' => 'error'];
    }
    protected function addBreadcrumb($text, $url, $info = '')
    {
        if ($this->breadcrumb === null) {
            $this->breadcrumb = [];
        }
        $this->breadcrumb[] = [
            'text' => $text,
            'url'  => (is_array($url) ? '/' . implode('/', $url) : $url),
            'info' => $info,
        ];
    }
}