<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppAdminController;
use Cake\Network\Exception\NotFoundException;

/**
 * @property \App\Model\Table\LinksTable $Links
 * @property \App\Controller\Component\CaptchaComponent $Captcha
 */
class LinksController extends AppAdminController
{
    public function index()
    {
        $conditions = [];

        $filter_fields = ['user_id', 'alias', 'ad_type', 'title_desc'];

        //Transform POST into GET
        if ($this->request->is(['post', 'put']) && isset($this->request->data['Filter'])) {
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
                    if (in_array($param_name, ['alias'])) {
                        $conditions[] = [
                            ['Links.' . $param_name . ' LIKE' => '%' . $value . '%']
                        ];
                    } elseif (in_array($param_name, ['title_desc'])) {
                        $conditions['OR'] = [
                            ['Links.title LIKE' => '%' . $value . '%'],
                            ['Links.description LIKE' => '%' . $value . '%'],
                            ['Links.url LIKE' => '%' . $value . '%']
                        ];
                    } elseif (in_array($param_name, ['user_id', 'ad_type'])) {
                        $conditions['Links.' . $param_name] = $value;
                    }
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $query = $this->Links->find()
            ->contain(['Users'])
            ->where($conditions)
            ->where(['Links.status' => 1]);
        $links = $this->paginate($query);

        $this->set('links', $links);
    }

    public function hidden()
    {
        $conditions = [];

        $filter_fields = ['id', 'user_id', 'alias', 'title_desc'];

        //Transform POST into GET
        if ($this->request->is(['post', 'put']) && isset($this->request->data['Filter'])) {
            $filter_url = [];

            $filter_url['controller'] = $this->request->params['controller'];

            $filter_url['action'] = $this->request->params['action'];

            // We need to overwrite the page every time we change the parameters
            $filter_url['page'] = 1;

            // for each filter we will add a GET parameter for the generated url
            foreach ($this->request->data['Filter'] as $name => $value) {
                if (in_array($name, $filter_fields) && $value) {
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
                    if (in_array($param_name, ['alias'])) {
                        $conditions[] = [
                            ['Links.' . $param_name . ' LIKE' => '%' . $value . '%']
                        ];
                    } elseif (in_array($param_name, ['title_desc'])) {
                        $conditions['OR'] = [
                            ['Links.title LIKE' => '%' . $value . '%'],
                            ['Links.description LIKE' => '%' . $value . '%'],
                            ['Links.url LIKE' => '%' . $value . '%']
                        ];
                    } elseif (in_array($param_name, ['id', 'user_id'])) {
                        $conditions['Links.' . $param_name] = $value;
                    }
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $query = $this->Links->find()
            ->contain(['Users'])
            ->where($conditions)
            ->where(['Links.status' => 2]);
        $links = $this->paginate($query);

        $this->set('links', $links);
    }

    public function inactive()
    {
        $conditions = [];

        $filter_fields = ['id', 'user_id', 'alias', 'title_desc'];

        //Transform POST into GET
        if ($this->request->is(['post', 'put']) && isset($this->request->data['Filter'])) {
            $filter_url = [];

            $filter_url['controller'] = $this->request->params['controller'];

            $filter_url['action'] = $this->request->params['action'];

            // We need to overwrite the page every time we change the parameters
            $filter_url['page'] = 1;

            // for each filter we will add a GET parameter for the generated url
            foreach ($this->request->data['Filter'] as $name => $value) {
                if (in_array($name, $filter_fields) && $value) {
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
                    if (in_array($param_name, ['alias'])) {
                        $conditions[] = [
                            ['Links.' . $param_name . ' LIKE' => '%' . $value . '%']
                        ];
                    } elseif (in_array($param_name, ['title_desc'])) {
                        $conditions['OR'] = [
                            ['Links.title LIKE' => '%' . $value . '%'],
                            ['Links.description LIKE' => '%' . $value . '%'],
                            ['Links.url LIKE' => '%' . $value . '%']
                        ];
                    } elseif (in_array($param_name, ['id', 'user_id'])) {
                        $conditions['Links.' . $param_name] = $value;
                    }
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $query = $this->Links->find()
            ->contain(['Users'])
            ->where($conditions)
            ->where(['Links.status' => 3]);
        $links = $this->paginate($query);

        $this->set('links', $links);
    }

    public function edit($alias = null)
    {
        if (!$alias) {
            throw new NotFoundException(__('Invalid link'));
        }

        /**
         * @var \App\Model\Entity\Link $link
         */
        $link = $this->Links->findByAlias($alias)->first();
        if (!$link) {
            throw new NotFoundException(__('Invalid link'));
        }

        if ($this->request->is(['post', 'put'])) {
            $this->request->data['user_id'] = $link->user_id;
            $link = $this->Links->patchEntity($link, $this->request->data);
            if ($this->Links->save($link)) {
                $this->Flash->success(__('The Link has been updated.'));

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

        $link = $this->Links->findByAlias($alias)->first();

        $link->status = 2;

        if ($this->Links->save($link)) {
            $this->Flash->success(__('The Link with alias: {0} has been hidden.', $alias));

            return $this->redirect(['action' => 'index']);
        }
    }

    public function unhide($alias)
    {
        $this->request->allowMethod(['post', 'delete']);

        $link = $this->Links->findByAlias($alias)->first();

        $link->status = 1;

        if ($this->Links->save($link)) {
            $this->Flash->success(__('The Link with alias: {0} has been unhidden.', $alias));

            return $this->redirect(['action' => 'hidden']);
        }
    }

    public function deactivate($alias)
    {
        $this->request->allowMethod(['post', 'delete']);

        $link = $this->Links->findByAlias($alias)->first();

        $link->status = 3;

        if ($this->Links->save($link)) {
            $this->Flash->success(__('The Link with alias: {0} has been unhided.', $alias));

            return $this->redirect(['action' => 'hidden']);
        }
    }

    public function delete($id, $views = false)
    {
        $this->request->allowMethod(['post', 'delete']);

        $link = $this->Links->findById($id)->first();

        if ($this->Links->delete($link)) {
            if ($views) {
                $this->Links->Statistics->deleteAll(['link_id' => $id]);
            }

            $this->Flash->success(__('The link with id: {0} has been deleted.', $id));
        }

        return $this->redirect(['action' => 'index']);
    }
}
