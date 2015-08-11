<?php

namespace Education\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController {

    public function indexAction()
    {
    }

    public function bulkAction()
    {
        $service = $this->getExamService();
        $request = $this->getRequest();

        if ($request->isPost()) {
            // try uploading
            if ($service->tempUpload($request->getPost(), $request->getFiles())) {
                return new ViewModel(array(
                    'success' => true
                ));
            } else {
                $this->getResponse()->setStatusCode(500);
                return new ViewModel(array(
                    'success' => false
                ));
            }
        }

        return new ViewModel(array(
            'form' => $service->getTempUploadForm()
        ));
    }

    public function uploadAction()
    {
        $service = $this->getExamService();
        $request = $this->getRequest();

        if ($request->isPost()) {
            // try uploading
            if ($service->upload($request->getPost(), $request->getFiles())) {
                return new ViewModel(array(
                    'success' => true
                ));
            }
        }

        return new ViewModel(array(
            'form' => $service->getUploadForm()
        ));
    }

    /**
     * Get the exam service.
     */
    public function getExamService()
    {
        return $this->getServiceLocator()->get('education_service_exam');
    }
}
