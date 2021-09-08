<?php
    namespace App\Controllers;

    use App\Models\AdministratorModel;
    use App\Core\Role\AdminRoleController;
    use App\Validators\StringValidator;

    class MainController extends AdminRoleController {
        public function home() {
            $administratorId =  $this->getSession()->get('administrator_id');

            if($administratorId != 1) {
                $this->set('message', 'Napomena: Nemate ovlašćenje za dodavanje programa poslovanja.');
            }


            $administratorModel = new AdministratorModel($this->getDatabaseConnection());
            $admin = $administratorModel->getById($administratorId);
            $this->set('admin', $admin);
        }

        public function getLogout() {
            $this->getSession()->remove('administrator_id');
            $this->getSession()->save();
            $this->redirect(\Configuration::BASE . 'login');
        }
    }