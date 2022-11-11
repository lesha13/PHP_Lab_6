<?php

declare(strict_types=1);

namespace Core;

/**
 * Class Controller
 */
abstract class Controller
{

    /** @var array $data */
    protected $data = [];

    public function __construct()
    {
        $this->set('layoutPath', App::getLayoutDir() . DS . 'layout.php');
        $this->set('menuPath', App::getViewDir() . DS . 'menu.php');
    }

    /**
     * @param string $key
     * @param mixed $value
     * 
     * @return void
     */
    protected function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed 
     */
    protected function get(string $key)
    {
        return $this->data[$key];
    }

    public function renderLayout()
    {
        $this->set('menuCollection', $this->getMenuCollection());
        $menu = new View($this->data, $this->get('menuPath'));

        $content = new View($this->data);

        $this->set('menu', $menu);
        $this->set('content', $content);

        $view = new View($this->data, $this->get('layoutPath'));

        echo $view->render();
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getModel(string $name)
    {
        $name = '\\Models\\' . ucfirst($name);
        $model = new $name();

        return $model;
    }

    /**
     * @return mixed
     */
    private function getMenuCollection()
    {
        return $this->getModel('menu')
                        ->initCollection()
                        ->sort(['sort_order' => 'ASC'])
                        ->getCollection()
                        ->select();
    }

    /**
     * Runs provided route
     * 
     * @param string $route
     */
    protected function forward(string $route)
    {
        App::run($route);
    }

}
