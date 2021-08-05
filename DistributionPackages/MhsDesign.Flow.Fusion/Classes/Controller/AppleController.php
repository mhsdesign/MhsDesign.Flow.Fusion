<?php
namespace MhsDesign\Flow\Fusion\Controller;

/*
 * This file is part of the MhsDesign.Flow.Fusion package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use MhsDesign\Flow\Fusion\Domain\Model\Apple;

class AppleController extends ActionController
{

    /**
     * @Flow\Inject
     * @var \MhsDesign\Flow\Fusion\Domain\Repository\AppleRepository
     */
    protected $appleRepository;

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('apples', $this->appleRepository->findAll());
    }

    /**
     * @param \MhsDesign\Flow\Fusion\Domain\Model\Apple $apple
     * @return void
     */
    public function showAction(Apple $apple)
    {
        $this->view->assign('apple', $apple);
    }

    /**
     * @return void
     */
    public function newAction()
    {
    }

    /**
     * @param \MhsDesign\Flow\Fusion\Domain\Model\Apple $newApple
     * @return void
     */
    public function createAction(Apple $newApple)
    {
        $this->appleRepository->add($newApple);
        $this->addFlashMessage('Created a new apple.');
        $this->redirect('index');
    }

    /**
     * @param \MhsDesign\Flow\Fusion\Domain\Model\Apple $apple
     * @return void
     */
    public function editAction(Apple $apple)
    {
        $this->view->assign('apple', $apple);
    }

    /**
     * @param \MhsDesign\Flow\Fusion\Domain\Model\Apple $apple
     * @return void
     */
    public function updateAction(Apple $apple)
    {
        $this->appleRepository->update($apple);
        $this->addFlashMessage('Updated the apple.');
        $this->redirect('index');
    }

    /**
     * @param \MhsDesign\Flow\Fusion\Domain\Model\Apple $apple
     * @return void
     */
    public function deleteAction(Apple $apple)
    {
        $this->appleRepository->remove($apple);
        $this->addFlashMessage('Deleted a apple.');
        $this->redirect('index');
    }
}
