<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Core\View;

/**
 * Class ProductController
 */
class ProductController extends Controller
{

    /**
     * Product index action that shows product list
     * 
     * @return void
     */
    public function indexAction(): void
    {
        $this->forward('product/list');
    }

    /**
     * Product list action
     * 
     * @return void
     */
    public function listAction(): void
    {
        $this->set('title', "Товари");

        $products = $this->getModel('Product')
                ->initCollection()
                ->sort($this->getSortParams())
                ->getCollection()
                ->select();
        $this->set('products', $products);

        $this->renderLayout();
    }

    /**
     * Single product view action
     * 
     * @return void
     */
    public function viewAction(): void
    {
        $this->set('title', 'Карточка товара');

        $product = $this->getModel('Product');
        $product->initCollection()
                ->filter(['id', $this->getId()])
                ->getCollection()
                ->selectFirst();
        $this->set('products', $product);

        $this->renderLayout();
    }

    /**
     * Shows product editing page
     * 
     * @return void
     */
    public function editAction(): void
    {
        $model = $this->getModel('Product');
        $this->set('saved', 0);
        $this->set("title", "Редагування товару");
        $id = filter_input(INPUT_POST, 'id');
        if ($id) {
            $values = $model->getPostValues();
            $this->set('saved', 1);
            $model->saveItem($id, $values);
        }
        $this->set('product', $model->getItem($this->getId()));

        $this->renderLayout();
    }

    /**
     * Shows product add page
     * 
     * @return void
     */
    public function addAction(): void
    {
        $model = $this->getModel('Product');
        $this->set("title", "Додавання товару");
        if ($values = $model->getPostValues()) {
            $model->addItem($values);
        }
        $this->renderLayout();
    }

    /**
     * @return array
     */
    public function getSortParams(): array
    {
        $params = [];
        $sortfirst = filter_input(INPUT_POST, 'sortfirst');
        if ($sortfirst === "price_DESC") {
            $params['price'] = 'DESC';
        } else {
            $params['price'] = 'ASC';
        }
        $sortsecond = filter_input(INPUT_POST, 'sortsecond');
        if ($sortsecond === "qty_DESC") {
            $params['qty'] = 'DESC';
        } else {
            $params['qty'] = 'ASC';
        }

        return $params;
    }

    /**
     * @return array
     */
    public function getSortParams_old(): array
    {
        /*
          if (isset($_GET['sort'])) {
          $sort = $_GET['sort'];
          } else
          {
          $sort = "name";
          }
         * 
         */
        $sort = filter_input(INPUT_GET, 'sort');
        if (!isset($sort)) {
            $sort = "name";
        }
        /*
          if (isset($_GET['order']) && $_GET['order'] == 1) {
          $order = "ASC";
          } else {
          $order = "DESC";
          }
         * 
         */
        if ((int) filter_input(INPUT_GET, 'order') === 1) {
            $order = "DESC";
        } else {
            $order = "ASC";
        }

        return [$sort, $order];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        /*
          if (isset($_GET['id'])) {

          return $_GET['id'];
          } else {
          return NULL;
          }
         */
        return filter_input(INPUT_GET, 'id');
    }

}
