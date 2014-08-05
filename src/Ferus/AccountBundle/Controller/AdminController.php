<?php

namespace Ferus\AccountBundle\Controller;

use Braincrafted\Bundle\BootstrapBundle\Session\FlashMessage;
use Ferus\AccountBundle\Entity\Account;
use Ferus\AccountBundle\Form\AccountType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var FlashMessage
     */
    private $flash;

    /**
     * @Template
     */
    public function indexAction(Request $request)
    {
        if($request->query->has('search'))
        {
            $search = $request->query->get('search');

            // if search is an id we go directly to the view page
            if(preg_match('/^[0-9]+$/', $search))
                return $this->redirect($this->generateUrl('account_admin_view', array('student' => $search)));

            $query = $this->em
                ->getRepository('FerusAccountBundle:Account')
                ->querySearch($search);
        }
        else {
            $query = $this->em
                ->getRepository('FerusAccountBundle:Account')
                ->queryAll();
        }

        $accounts = $this->paginator->paginate(
            $query,
            $request->query->get('page', 1),
            50
        );

        return array(
            'accounts' => $accounts,
            'search' => $request->query->get('search', null),
        );
    }

    /**
     * @Template
     */
    public function addAction(Request $request)
    {
        $account = new Account;
        $form = $this->createForm(new AccountType, $account);

        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if($form->isValid()){

                // We check that there is no softdeleted account for this student
                $this->em->getFilters()->disable('softdeleteable');
                $deleted = $this->em->getRepository('FerusAccountBundle:Account')
                    ->findSoftDeleted($account->getStudent());

                if($deleted !== null){
                    $deleted->setBalance($account->getBalance());
                    $deleted->setDeletedAt(null);
                    $account = $deleted;
                }

                $this->em->persist($account);
                $this->em->flush();

                $this->flash->success('Compte créé.');
                return $this->redirect($this->generateUrl('account_admin_index'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Template
     */
    public function viewAction(Account $account, Request $request)
    {
        $this->em->getFilters()->disable('softdeleteable');

        $transactions = $this->paginator->paginate(
            $this->em
                ->getRepository('FerusTransactionBundle:Transaction')
                ->queryOfAccount($account),
            $request->query->get('page', 1),
            50
        );

        return array(
            'account' => $account,
            'transactions' => $transactions,
        );
    }

    /**
     * @Template
     */
    public function removeAction(Account $account, Request $request)
    {
        if($request->isMethod('POST') && $account->getBalance() == 0){

            // If account has no transactions attached then we remove the fuck out of it... fo real
            if($this->em->getRepository('FerusTransactionBundle:Transaction')->accountHasNoTransactions($account)){
                $this->em->getRepository('FerusAccountBundle:Account')
                    ->remove($account);
            }
            else{
                $this->em->remove($account);
                $this->em->flush();
            }

            $this->flash->success('Compte supprimé.');

            return $this->redirect($this->generateUrl('account_admin_index'));
        }

        return array(
            'account' => $account,
        );
    }
}
