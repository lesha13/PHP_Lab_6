<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;

/**
 * Class ErrorController
 */
class ErrorController extends Controller
{

    /**
     * Not found action. Called when router did not find needed action to process.
     * 
     * @return void
     */
    public function error404Action(): void
    {
        $this->set('title', 'Error 404');
        header('HTTP/1.0 404 Not Found');
        $this->renderLayout();
    }
}
