<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;

/**
 * Class IndexController
 */
class IndexController extends Controller
{

    /**
     * Main page action
     *
     * @return void
     */
    public function indexAction(): void
    {
        $this->set('title', 'Test shop');
        $this->renderLayout();
    }

    /**
     * Test action
     */
    public function testAction(): void
    {
        echo "hello from testAction";
    }

}
