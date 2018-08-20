<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppAdminController;
use Cake\Network\Exception\NotFoundException;

/**
 * @property \App\Model\Table\PagesTable $Pages
 */
class PagesController extends AppAdminController
{
    public function index()
    {
        $query = $this->Pages->find();
        $pages = $this->paginate($query);

        $this->set('pages', $pages);
    }

    public function add()
    {
        $page = $this->Pages->newEntity();

        if ($this->request->is('post')) {
            if (isset($this->request->data['slug']) && !empty($this->request->data['slug'])) {
                $this->request->data['slug'] = $this->Pages->createSlug($this->request->data['slug']);
            } else {
                $this->request->data['slug'] = $this->Pages->createSlug($this->request->data['title']);
            }

            $page = $this->Pages->patchEntity($page, $this->request->data);

            if ($this->Pages->save($page)) {
                $this->Flash->success(__('Page has been added.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Oops! There are mistakes in the form. Please make the correction.'));
        }
        $this->set('page', $page);
    }

    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid Page'));
        }

        if (isset($this->request->query['lang']) && isset(get_site_languages()[$this->request->query['lang']])) {
            //$page->_locale = $this->request->query['lang'];
            $this->Pages->locale($this->request->query['lang']);
        }

        $page = $this->Pages->get($id);
        if (!$page) {
            throw new NotFoundException(__('Invalid Page'));
        }

        if ($this->request->is(['post', 'put'])) {
            if (isset($this->request->data['slug']) && !empty($this->request->data['slug'])) {
                $this->request->data['slug'] = $this->Pages->createSlug($this->request->data['slug'], $id);
            } else {
                $this->request->data['slug'] = $this->Pages->createSlug($this->request->data['title'], $id);
            }

            $page = $this->Pages->patchEntity($page, $this->request->data);

            if ($this->Pages->save($page)) {
                $this->Flash->success(__('Page has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Oops! There are mistakes in the form. Please make the correction.'));
        }
        $this->set('page', $page);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        /*
        if(in_array($id, [1, 2, 3, 4, 5]) ) {
            $this->Flash->error(__('You can not delete this page.'));
            return $this->redirect(['action' => 'index']);
        }
        */

        $page = $this->Pages->findById($id)->first();

        if ($this->Pages->delete($page)) {
            $this->Flash->success(__('The page with id: {0} has been deleted.', $page->id));
            return $this->redirect(['action' => 'index']);
        }
    }
}
