<?php

namespace App\Controller\Member;

use App\Controller\Member\AppMemberController;
use Cake\Network\Exception\NotFoundException;

/**
 * @property \App\Model\Table\LinksTable $Links
 * @property \App\Controller\Component\CaptchaComponent $Captcha
 */
class LinksController extends AppMemberController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    public function index()
    {
        $conditions = [];

        $filter_fields = ['id', 'alias', 'ad_type', 'title_desc'];

        //Transform POST into GET
        if (($this->request->is('post') || $this->request->is('put')) && isset($this->request->data['Filter'])) {
            $filter_url = [];

            $filter_url['controller'] = $this->request->params['controller'];

            $filter_url['action'] = $this->request->params['action'];

            // We need to overwrite the page every time we change the parameters
            $filter_url['page'] = 1;

            // for each filter we will add a GET parameter for the generated url
            foreach ($this->request->data['Filter'] as $name => $value) {
                if (in_array($name, $filter_fields) && strlen($value)) {
                    // You might want to sanitize the $value here
                    // or even do a urlencode to be sure
                    $filter_url[$name] = urlencode($value);
                }
            }
            // now that we have generated an url with GET parameters,
            // we'll redirect to that page
            return $this->redirect($filter_url);
        } else {
            // Inspect all the named parameters to apply the filters
            foreach ($this->request->query as $param_name => $value) {
                $value = urldecode($value);
                if (in_array($param_name, $filter_fields)) {
                    // You may use a switch here to make special filters
                    // like "between dates", "greater than", etc

                    $search_params = array('alias');

                    if (in_array($param_name, $search_params)) {
                        $conditions[] = array(
                            array('Links.' . $param_name . ' LIKE' => '%' . $value . '%')
                        );
                    } elseif ($param_name == 'title_desc') {
                        $conditions['OR'] = array(
                            array('Links.title LIKE' => '%' . $value . '%'),
                            array('Links.description LIKE' => '%' . $value . '%'),
                            array('Links.url LIKE' => '%' . $value . '%')
                        );
                    } else {
                        if (in_array($param_name, ['ad_type'])) {
                            $conditions['Links.' . $param_name] = $value;
                        }
                    }
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $query = $this->Links->find()
            ->where($conditions)
            ->where([
                'user_id' => $this->Auth->user('id'),
                'status' => 1
            ]);
        $links = $this->paginate($query);

        $this->set('links', $links);
    }

    public function hidden()
    {
        $conditions = [];

        $filter_fields = ['id', 'alias', 'title_desc'];

        //Transform POST into GET
        if (($this->request->is('post') || $this->request->is('put')) && isset($this->request->data['Filter'])) {
            $filter_url = [];

            $filter_url['controller'] = $this->request->params['controller'];

            $filter_url['action'] = $this->request->params['action'];

            // We need to overwrite the page every time we change the parameters
            $filter_url['page'] = 1;

            // for each filter we will add a GET parameter for the generated url
            foreach ($this->request->data['Filter'] as $name => $value) {
                if ($value) {
                    // You might want to sanitize the $value here
                    // or even do a urlencode to be sure
                    $filter_url[$name] = urlencode($value);
                }
            }
            // now that we have generated an url with GET parameters,
            // we'll redirect to that page
            return $this->redirect($filter_url);
        } else {
            // Inspect all the named parameters to apply the filters
            foreach ($this->request->query as $param_name => $value) {
                if (in_array($param_name, $filter_fields)) {
                    // You may use a switch here to make special filters
                    // like "between dates", "greater than", etc

                    $search_params = array('alias');

                    if (in_array($param_name, $search_params)) {
                        $conditions[] = array(
                            array('Links.' . $param_name . ' LIKE' => '%' . $value . '%')
                        );
                    } elseif ($param_name == 'title_desc') {
                        $conditions['OR'] = array(
                            array('Links.title LIKE' => '%' . $value . '%'),
                            array('Links.description LIKE' => '%' . $value . '%'),
                            array('Links.url LIKE' => '%' . $value . '%')
                        );
                    } else {
                        if (in_array($param_name, ['id'])) {
                            $conditions['Links.' . $param_name] = $value;
                        }
                    }
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $query = $this->Links->find()
            ->where($conditions)
            ->where([
                'user_id' => $this->Auth->user('id'),
                'status' => 2
            ]);
        $links = $this->paginate($query);

        $this->set('links', $links);
    }

    public function edit($alias = null)
    {
        if (!$alias) {
            throw new NotFoundException(__('Invalid link'));
        }

        $user = $this->Links->Users->find()->contain('Plans')->where(['Users.id' => $this->Auth->user('id')])->first();

        $edit_long_url = true;
        if ((bool)get_option('enable_premium_membership')) {
            if (!$this->logged_user_plan->edit_link) {
                $this->Flash->error(__('You must upgrade your plan so you can use this tool.'));
                return $this->redirect(['action' => 'index']);
            }

            if (!$this->logged_user_plan->edit_long_url) {
                $edit_long_url = false;
            }
        }

        $this->set('edit_long_url', $edit_long_url);

        $link = $this->Links->find()
            ->where([
                'alias' => $alias,
                'user_id' => $this->Auth->user('id'),
                'status <>' => 3
            ])
            ->first();

        if (!$link) {
            throw new NotFoundException(__('Invalid link'));
        }

        if ($this->request->is(['post', 'put'])) {
            $this->request->data['user_id'] = $this->Auth->user('id');

            $link = $this->Links->patchEntity($link, $this->request->data);

            if ($this->Links->save($link)) {
                $this->Flash->success(__('Your Link has been updated.'));
                return $this->redirect(['action' => 'edit', $alias]);
            } else {
                //debug( $link->errors() );
                $this->Flash->error(__('Oops! There are mistakes in the form. Please make the correction.'));
            }
        }
        $this->set('link', $link);
    }

    public function hide($alias)
    {
        $this->request->allowMethod(['post', 'delete']);

        $link = $this->Links->find()
            ->where([
                'alias' => $alias,
                'user_id' => $this->Auth->user('id'),
                'status' => 1
            ])
            ->first();

        $link->status = 2;

        if ($this->Links->save($link)) {
            $this->Flash->success(__('The Link with alias: {0} has been hidden.', $alias));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function unhide($alias)
    {
        $this->request->allowMethod(['post', 'delete']);

        $link = $this->Links->find()
            ->where([
                'alias' => $alias,
                'user_id' => $this->Auth->user('id'),
                'status' => 2
            ])
            ->first();

        $link->status = 1;

        if ($this->Links->save($link)) {
            $this->Flash->success(__('The Link with alias: {0} has been unhidden.', $alias));
            return $this->redirect(['action' => 'hidden']);
        }
    }
}
