<?php
    namespace App\Core\Role;

    use App\Core\Controller;

    class AdminRoleController extends Controller {
        public function __pre() {
            if($this->getSession()->get('administrator_id') === null) {
                $this->redirect(\Configuration::BASE . 'login');
            }
        }
    }