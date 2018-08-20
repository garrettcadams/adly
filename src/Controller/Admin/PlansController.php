<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppAdminController;
use Cake\Network\Exception\NotFoundException;

/**
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\PlansTable $Plans
 */
class PlansController extends AppAdminController
{
    public function index()
    {
        $query = $this->Plans->find();
        $plans = $this->paginate($query);

        $this->set('plans', $plans);
    }

    public function add()
    {
        $plan = $this->Plans->newEntity();

        if ($this->request->is('post')) {
            $this->request->data['monthly_price'] = price_database_format($this->request->data['monthly_price']);
            $this->request->data['yearly_price'] = price_database_format($this->request->data['yearly_price']);

            $plan = $this->Plans->patchEntity($plan, $this->request->data);

            if ($this->Plans->save($plan)) {
                $this->Flash->success(__('Plan has been added.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Oops! There are mistakes in the form. Please make the correction.'));
        }
        $this->set('plan', $plan);
    }

    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid Plan'));
        }

        if (isset($this->request->query['lang']) && isset(get_site_languages()[$this->request->query['lang']])) {
            //$post->_locale = $this->request->query['lang'];
            $this->Plans->locale($this->request->query['lang']);
        }

        $plan = $this->Plans->get($id);
        if (!$plan) {
            throw new NotFoundException(__('Invalid Plan'));
        }

        if ($this->request->is(['post', 'put'])) {
            if ($id == 1) {
                $this->request->data['enable'] = 1;
                $this->request->data['monthly_price'] = 0;
                $this->request->data['yearly_price'] = 0;
            }

            $this->request->data['monthly_price'] = price_database_format($this->request->data['monthly_price']);
            $this->request->data['yearly_price'] = price_database_format($this->request->data['yearly_price']);

            $plan = $this->Plans->patchEntity($plan, $this->request->data);

            if ($this->Plans->save($plan)) {
                $this->Flash->success(__('Plan has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Oops! There are mistakes in the form. Please make the correction.'));
        }
        $this->set('plan', $plan);
    }

    public function delete($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid Plan'));
        }

        if ($id == 1) {
            $this->Flash->error(__("Default plan can't be deleted."));
            return $this->redirect(['action' => 'index']);
        }

        $plan = $this->Plans->findById($id)->first();
        if (!$plan) {
            throw new NotFoundException(__('Invalid Plan'));
        }

        $plans = $this->Plans->find('list', [
            'keyField' => 'id',
            'valueField' => 'title'
        ])->where(['enable' => 1, 'id  <>' => $id])->toArray();

        if ($this->request->is(['post', 'put'])) {
            $this->loadModel('Users');

            $query = $this->Users->query()
                ->update()
                ->set(['plan_id' => $this->request->data['plan_replace']])
                ->where(['plan_id' => $id])
                ->execute();

            if ($this->Plans->delete($plan)) {
                $this->Flash->success(__('The plan with id: {0} has been deleted.', $plan->id));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set('plan', $plan);
        $this->set('plans', $plans);
    }
}
