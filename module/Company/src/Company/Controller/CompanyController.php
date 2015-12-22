<?php

namespace Company\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CompanyController extends AbstractActionController
{
    /**
     *
     * Action to display a list of all nonhidden companies
     *
     */
    public function listAction()
    {
        $companyService = $this->getCompanyService();
        return new ViewModel([
            'companyList' => $companyService->getCompanyList(),
            'translator' => $companyService->getTranslator(),
        ]);

    }

    public function showAction()
    {
        $companyService = $this->getCompanyService();
        $companyName = $this->params('slugCompanyName');
        $companies = $companyService->getCompaniesBySlugName($companyName);
        if (count($companies) == 1) {
            return new ViewModel([
                'company' => $companies[0],
                'translator' => $companyService->getTranslator(),
            ]);
        }
        $this->getResponse()->setStatusCode(404);
    }

    /**
     *
     * Action that displays a list of all jobs (facaturebank)
     *
     */
    public function jobListAction()
    {
        $companyService = $this->getCompanyService();
        $companyName = $this->params('slugCompanyName');
        if (isset($companyName)) {
            // jobs for a single company
            return new ViewModel([
                'company' => $companyService->getCompaniesBySlugName($companyName)[0],
                'jobList' => $companyService->getJobsByCompanyName($companyName),
                'translator' => $companyService->getTranslator(),
            ]);
        }
        // all jobs
        return new ViewModel([
            'jobList' => $companyService->getJobList(),
            'translator' => $companyService->getTranslator(),
        ]);
    }

    /**
     *
     * Action to list jobs of a certain company
     *
     */
    public function jobsAction()
    {
        $companyService = $this->getCompanyService();
        $jobName = $this->params('slugJobName');
        $companyName = $this->params('slugCompanyName');
        if ($jobName != null) {
            $jobs = $companyService->getJobsBySlugName($companyName, $jobName);
            if (count($jobs) != 0) {
                return new ViewModel([
                    'job' => $jobs[0],
                    'translator' => $companyService->getTranslator(),
                ]);
            }
            return new ViewModel();
        }
        return new ViewModel([
            'activeJobList' => $companyService->getActiveJobList(),
            'translator' => $companyService->getTranslator(),
        ]);
    }

    /**
     * Method that returns the service object for the company module.
     *
     *
     */
    protected function getCompanyService()
    {
        return $this->getServiceLocator()->get('company_service_company');
    }
}
