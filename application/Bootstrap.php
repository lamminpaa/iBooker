<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initRoutes()
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $route = new Zend_Controller_Router_Route('/books/show/:id/',
                                                  array(
                                                      'controller' => 'books',
                                                      'action'     => 'show'
                                                        )
                                                  );
        $router->addRoute('books_show', $route);

        $route_edit = new Zend_Controller_Router_Route('/books/edit/:id/',
                                                  array(
                                                      'controller' => 'books',
                                                      'action'     => 'edit'
                                                        )
                                                  );
        $router->addRoute('books_edit', $route_edit);

        $route_return = new Zend_Controller_Router_Route('/books/return/:book_id/:loan_id',
                                                  array(
                                                      'controller' => 'books',
                                                      'action'     => 'return'
                                                        )
                                                  );
        $router->addRoute('books_return', $route_return);
        return $router;
    }
    

}
