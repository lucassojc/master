<?php
    namespace App\Core\Role;

    use App\Core\Controller;

    class SuperAdminRoleController extends Controller {
        public function __pre() {
            if($this->getSession()->get('administrator_id') != 1) {
                $this->set('message', 'Nemate ovlascenje da dodate Program Poslovanja !');
                $this->redirect(\Configuration::BASE);
            }
        }
    }