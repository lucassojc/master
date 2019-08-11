<?php
    namespace App\Controllers;

    use App\Models\AdministratorModel;
    use App\Core\Controller;
    use App\Validators\StringValidator;

    class MainController extends Controller {
        public function home() {

            // $administratorId =  $this->getSession()->get('administrator_id');

            // if (!$administratorId) {
                
            // }

            // $administratorModel = new AdministratorModel($this->getDatabaseConnection());
            // $admin = $administratorModel->getById(1);
            // $this->set('admin', $admin);
        }

        public function postLogin() {
            $username = \filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $password = \filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            $validanPassword = (new StringValidator())
                ->setMinLength(3)
                ->setMaxLength(120)
                ->isValid($password);
            
            if (!$validanPassword) {
                $this->set('message', 'Došlo je do greške, lozinka nije validna.');
                return;
            }

            $administratorModel = new AdministratorModel($this->getDatabaseConnection());

            $admin = $administratorModel->getByFieldName('username', $username);
            if(!$admin) {
                $this->set('message', 'Došlo je do greške: Ne postoji korisnik sa tim korisničkim imenom.');
                return;
            }

            $isPassword = $administratorModel->getByFieldName('password', $password);
            if (!$isPassword) {
                sleep(1);
                $this->set('message', 'Došlo je do greške: Lozinka nije ispravna.');
                return;
            }

            $this->getSession()->put('administrator_id', $admin->administrator_id);
            $this->getSession()->save();
            $this->redirect(\Configuration::BASE . '');


        }

        public function getLogout() {
            $this->getSession()->remove('administrator_id');
            $this->getSession()->save();
            $this->redirect(\Configuration::BASE . 'login');
        }
    }