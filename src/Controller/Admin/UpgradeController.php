<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppAdminController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Migrations\Migrations;

class UpgradeController extends AppAdminController
{
    public function index()
    {
        if ($this->request->is('post')) {
            set_time_limit(10 * MINUTE);
            @ini_set('max_execution_time', 10 * MINUTE);

            try {
                $migrations = new Migrations();
                $result = $migrations->migrate();
            } catch (\Exception $ex) {
                $result = __('Can not able to run upgrade. Error: ') . $ex->getMessage();
            }

            if ($result !== true) {
                $this->Flash->error($result);
            } else {
                $Options = TableRegistry::get('Options');
                $app_version = $Options->findByName('app_version')->first();

                if (version_compare($app_version, '3.5.0', '<')) {
                    Configure::write('Adlinkfly.installed', 1);
                    Configure::dump('app_vars', 'default', ['Adlinkfly']);
                }

                $app_version->value = APP_VERSION;
                $Options->save($app_version);

                emptyCache();
                createEmailFile();

                $this->Flash->success(__('Database upgraded successfully.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'dashboard']);
            }
        }
    }
}
