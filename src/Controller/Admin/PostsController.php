<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppAdminController;
use Cake\Network\Exception\NotFoundException;

/**
 * @property \App\Model\Table\PostsTable $Posts
 */
class PostsController extends AppAdminController
{
    public function index()
    {
        $query = $this->Posts->find();
        $posts = $this->paginate($query);

        $this->set('posts', $posts);
    }

    public function add()
    {
        $post = $this->Posts->newEntity();

        if ($this->request->is('post')) {
            if (isset($this->request->data['slug']) && !empty($this->request->data['slug'])) {
                $this->request->data['slug'] = $this->Posts->createSlug($this->request->data['slug']);
            } else {
                $this->request->data['slug'] = $this->Posts->createSlug($this->request->data['title']);
            }

            $post = $this->Posts->patchEntity($post, $this->request->data);

            if ($this->Posts->save($post)) {
                $this->Flash->success(__('Post has been added.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Oops! There are mistakes in the form. Please make the correction.'));
        }
        $this->set('post', $post);
    }

    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid Post'));
        }

        if (isset($this->request->query['lang']) && isset(get_site_languages()[$this->request->query['lang']])) {
            //$post->_locale = $this->request->query['lang'];
            $this->Posts->locale($this->request->query['lang']);
        }

        $post = $this->Posts->get($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid Post'));
        }

        if ($this->request->is(['post', 'put'])) {
            if (isset($this->request->data['slug']) && !empty($this->request->data['slug'])) {
                $this->request->data['slug'] = $this->Posts->createSlug($this->request->data['slug'], $id);
            } else {
                $this->request->data['slug'] = $this->Posts->createSlug($this->request->data['title'], $id);
            }

            $post = $this->Posts->patchEntity($post, $this->request->data);

            if ($this->Posts->save($post)) {
                $this->Flash->success(__('Post has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Oops! There are mistakes in the form. Please make the correction.'));
        }
        $this->set('post', $post);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        /*
        if(in_array($id, [1, 2, 3, 4, 5]) ) {
            $this->Flash->error(__('You can not delete this post.'));
            return $this->redirect(['action' => 'index']);
        }
        */

        $post = $this->Posts->findById($id)->first();

        if ($this->Posts->delete($post)) {
            $this->Flash->success(__('The post with id: {0} has been deleted.', $post->id));
            return $this->redirect(['action' => 'index']);
        }
    }
}
