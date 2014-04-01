<?php

/**
 * auth actions.
 *
 * @package    ecommerce
 * @subpackage auth
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class authActions extends sfActions
{
    public function executeLogin(sfWebRequest $request) 
    
    {
        
        $this->form = new LoginForm();
        
        if ($request->isMethod(sfRequest::POST)) {

            $this->processLoginForm($request, $this->form);

            $this->setTemplate('login');
        }
        else
        {
            if($this->getUser()->isAuthenticated())
            {
                $this->redirect('@homepage');
            }
        }
    }
    
    protected function processLoginForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $user = Auth::getCheckUser($form->getValue("username"), $form->getValue("password"));
            
            
            if ($user) {
                $this->getUser()->signIn($user);
                $this->getUser()->setFlash('alert', 'success');
                $this->getUser()->setFlash('message', 'Амжилттай нэвтэрлээ.');               
                $this->redirect("@homepage");
                
            } else {
                $this->getUser()->setFlash('error', 'Таны имэйл эсвэл нууц үг буруу байна');
                $this->getUser()->setFlash('username', $form->getValue("username"));
                $this->redirect("auth/login");
            }
        }
    }

    public function executeLogout(sfWebRequest $request) {
        $this->getUser()->setAuthenticated(false);
        $this->getUser()->shutdown();
        $this->redirect("@homepage");
    }
}
