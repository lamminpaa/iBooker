<?php
class Application_Plugin_AuthCheck extends Zend_Controller_Plugin_Abstract
{
	//This is one of the event methods. You can see all of them here: http://framework.zend.com/manual/en/zend.controller.plugins.html
	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
	{
		$publicControllers = array('login','feed');
		
		if(!in_array($request->getControllerName(), $publicControllers) && !Zend_Auth::getInstance()->hasIdentity())
		{
                    
                    $_SESSION['get_url'] =  getenv("REQUEST_URI");
                    
                  
			$request->setControllerName('login');
			$request->setActionName('index');
			// Set the module if you need to as well.
		}
	}
}
