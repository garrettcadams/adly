<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppAdminController;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

/**
 * @property \App\Model\Table\OptionsTable $Options
 */
class OptionsController extends AppAdminController
{
    public function index()
    {
        $plans = TableRegistry::get('Plans')
            ->find('list', [
                'keyField' => 'id',
                'valueField' => 'title'
            ])
            ->where(['enable' => 1])
            ->toArray();

        $this->set('plans', $plans);

        if ($this->saveOptions()) {
            emptyCache();

            $this->Flash->success(__('Settings have been saved.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function email()
    {
        if ($this->saveOptions()) {
            //emptyCache();
            createEmailFile();

            $this->Flash->success(__('Email settings have been saved.'));
            return $this->redirect(['action' => 'email']);
        }
    }

    public function socialLogin()
    {
        if ($this->saveOptions()) {
            $this->Flash->success(__('Social login settings have been saved.'));
            return $this->redirect(['action' => 'socialLogin']);
        }
    }

    public function payment()
    {
        if ($this->saveOptions()) {
            $this->Flash->success(__('Payment settings have been saved.'));
            return $this->redirect(['action' => 'payment']);
        }
    }

    public function withdrawal()
    {
        if ($this->saveOptions()) {
            $this->Flash->success(__('Withdrawal settings have been saved.'));
            return $this->redirect(['action' => 'withdrawal']);
        }
    }

    protected function saveOptions()
    {
        $options = $this->Options->find()->all();

        $settings = [];
        foreach ($options as $option) {
            $settings[$option->name] = [
                'id' => $option->id,
                'value' => $option->value
            ];
        }

        if ($this->request->is(['post', 'put'])) {
            foreach ($this->request->data['Options'] as $key => $optionData) {
                if (is_array($optionData['value'])) {
                    $optionData['value'] = serialize($optionData['value']);
                }
                $option = $this->Options->newEntity();
                $option->id = $key;
                $option = $this->Options->patchEntity($option, $optionData);
                $this->Options->save($option);
            }
            return true;
        }

        $this->set('options', $options);
        $this->set('settings', $settings);
    }

    public function interstitial()
    {
        if ($this->request->is(['get']) && empty($this->request->query['source'])) {
            return;
        }

        $source = $this->request->query['source'];

        $option = $this->Options->findByName('interstitial_price')->first();
        if (!$option) {
            throw new NotFoundException(__('Invalid option'));
        }

        $option->value = unserialize($option->value);

        if ($this->request->is(['post', 'put'])) {
            foreach ($this->request->data['value'] as $key => $value) {
                if (!empty($value[$source]['advertiser']) && !empty($value[$source]['publisher'])) {
                    $option->value[$key][$source] = [
                        'advertiser' => abs($value[$source]['advertiser']),
                        'publisher' => abs($value[$source]['publisher'])
                    ];
                } else {
                    $option->value[$key][$source] = [
                        'advertiser' => '',
                        'publisher' => ''
                    ];
                }
            }
            unset($key, $value);

            $option->value = serialize($option->value);

            if ($this->Options->save($option)) {
                //debug($option);
                $this->Flash->success('Prices have been updated.');

                foreach (get_site_languages(true) as $lang) {
                    \Cake\Cache\Cache::delete('advertising_rates_' . $lang, '1day');
                    \Cake\Cache\Cache::delete('payout_rates_' . $lang, '1day');
                }

                return $this->redirect(['action' => 'interstitial', '?' => ['source' => $source]]);
            } else {
                $this->Flash->error(__('Oops! There are mistakes in the form. Please make the correction.'));
            }
        }

        $this->set('option', $option);
    }

    public function banner()
    {
        if ($this->request->is(['get']) && empty($this->request->query['source'])) {
            return;
        }

        $source = $this->request->query['source'];

        $option = $this->Options->findByName('banner_price')->first();
        if (!$option) {
            throw new NotFoundException(__('Invalid option'));
        }

        $option->value = unserialize($option->value);

        if ($this->request->is(['post', 'put'])) {
            foreach ($this->request->data['value'] as $key => $value) {
                if (!empty($value[$source]['advertiser']) && !empty($value[$source]['publisher'])) {
                    $option->value[$key][$source] = [
                        'advertiser' => abs($value[$source]['advertiser']),
                        'publisher' => abs($value[$source]['publisher'])
                    ];
                } else {
                    $option->value[$key][$source] = [
                        'advertiser' => '',
                        'publisher' => ''
                    ];
                }
            }
            unset($key, $value);

            $option->value = serialize($option->value);

            if ($this->Options->save($option)) {
                //debug($option);
                $this->Flash->success('Prices have been updated.');

                foreach (get_site_languages(true) as $lang) {
                    \Cake\Cache\Cache::delete('advertising_rates_' . $lang, '1day');
                    \Cake\Cache\Cache::delete('payout_rates_' . $lang, '1day');
                }

                return $this->redirect(['action' => 'banner', '?' => ['source' => $source]]);
            } else {
                $this->Flash->error(__('Oops! There are mistakes in the form. Please make the correction.'));
            }
        }

        $this->set('option', $option);
    }

    public function popup()
    {
        if ($this->request->is(['get']) && empty($this->request->query['source'])) {
            return;
        }

        $source = $this->request->query['source'];

        $option = $this->Options->findByName('popup_price')->first();
        if (!$option) {
            throw new NotFoundException(__('Invalid option'));
        }

        $option->value = unserialize($option->value);

        if ($this->request->is(['post', 'put'])) {
            foreach ($this->request->data['value'] as $key => $value) {
                if (!empty($value[$source]['advertiser']) && !empty($value[$source]['publisher'])) {
                    $option->value[$key][$source] = [
                        'advertiser' => abs($value[$source]['advertiser']),
                        'publisher' => abs($value[$source]['publisher'])
                    ];
                } else {
                    $option->value[$key][$source] = [
                        'advertiser' => '',
                        'publisher' => ''
                    ];
                }
            }
            unset($key, $value);

            $option->value = serialize($option->value);

            if ($this->Options->save($option)) {
                //debug($option);
                $this->Flash->success('Prices have been updated.');

                foreach (get_site_languages(true) as $lang) {
                    \Cake\Cache\Cache::delete('advertising_rates_' . $lang, '1day');
                    \Cake\Cache\Cache::delete('payout_rates_' . $lang, '1day');
                }

                return $this->redirect(['action' => 'popup', '?' => ['source' => $source]]);
            } else {
                $this->Flash->error(__('Oops! There are mistakes in the form. Please make the correction.'));
            }
        }

        $this->set('option', $option);
    }
}
