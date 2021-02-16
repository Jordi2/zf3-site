<?php

namespace Faq\Controller;

use Laminas\Mvc\Controller\AbstractActionController;


class FaqController extends AbstractActionController
{
    public function __construct()
    {

    }
    
    public function indexAction() 
    {
        return $this->redirect()->toRoute('faq', ['action' => 'faq']);
    }
    
    public function faqAction()
    {
        
    }
}