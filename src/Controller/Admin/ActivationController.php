<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppAdminController;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;

/**
 * @property \App\Model\Table\ActivationTable $Activation
 */
class ActivationController extends AppAdminController
{
    public function index()
    {
        if ($this->request->is('post')) {
            $response = $this->Activation->licenseCurlRequest($this->request->data);

            $result = json_decode($response->body, true);

            if (isset($result['item']['id']) && $result['item']['id'] == 16887109) {
                Cache::write('license_response_result', data_encrypt($result), '1month');

                $Options = TableRegistry::get('Options');

                $personal_token = $Options->find()->where(['name' => 'personal_token'])->first();
                $personal_token->value = trim($this->request->data['personal_token']);
                $Options->save($personal_token);

                $purchase_code = $Options->find()->where(['name' => 'purchase_code'])->first();
                $purchase_code->value = trim($this->request->data['purchase_code']);
                $Options->save($purchase_code);

                $this->Flash->success(__('Your license has been verified.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'dashboard']);
            } else {
                if (isset($response->error) && !empty($response->error)) {
                    $this->Flash->error($response->error);
                    return null;
                }

                if (isset($result['Message']) && !empty($result['Message'])) {
                    $this->Flash->error($result['Message']);
                    return null;
                }

                if (isset($result['message']) && !empty($result['message'])) {
                    $this->Flash->error($result['message']);
                    return null;
                }

                if (isset($result['description']) && !empty($result['description'])) {
                    $this->Flash->error($result['description']);
                    return null;
                }

                if (isset($result['error_description']) && !empty($result['error_description'])) {
                    $this->Flash->error($result['error_description']);
                    return null;
                }

                if (isset($result['error'])) {
                    $this->Flash->error($result['error']);
                    return null;
                }
            }
        }
    }
}
