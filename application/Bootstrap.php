<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        
        $view->doctype('XHTML1_STRICT');
        $view->headMeta()->appendHttpEquiv('Content-Type',
                                           'text/html; charset=UTF-8')
                         ->appendHttpEquiv('Content-Language', 'en-US');
        
        
        
        $view->headLink()->headLink(array('rel' => 'alternate',
                                  'href' => 'http://ibooker.lamminpaa.net/rss',
                                  'type' => 'application/rss+xml',
                                  'title'=> 'ibooker Rss'));
    }
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
