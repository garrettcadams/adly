<?php

namespace App\Routing\Route;

use Cake\Datasource\ConnectionManager;
use Cake\Routing\Route\Route as CakeRoute;

class ShortLinkRoute extends CakeRoute
{
    public function parse($url, $method = '')
    {
        $route = parent::parse($url, $method);
        if (empty($route)) {
            return false;
        }

        if (!database_connect()) {
            return false;
        }

        try {
            $alias = $route['pass']['0'];
            //$alias = $route['alias'];

            $connection = ConnectionManager::get('default');
            $stmt = $connection->prepare("SELECT id FROM links WHERE alias = :alias");
            $stmt->bindValue('alias', $alias, 'string');
            $stmt->execute();

            $rowCount = count($stmt);

            if ($rowCount) {
                return $route;
            }
        } catch (\Exception $ex) {
        }
        return false;
    }
}
