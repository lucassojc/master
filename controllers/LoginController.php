<?php
    namespace App\Controllers;

    use App\Models\AdministratorModel;
    use App\Core\Controller;
    use App\Validators\StringValidator;

    class LoginController extends Controller {
        public function getLogin() {
            
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
            // if(!$admin) {
            //     $this->set('message', 'Došlo je do greške: Ne postoji korisnik sa tim korisničkim imenom.');
            //     return;
            // }

            $isPassword = $administratorModel->getByFieldName('password', $password);


            if (!$isPassword) {
                sleep(1);
                $this->set('message', 'Došlo je do greške: Pogrešna lozinka.');
                return;
            }

            $check = $administratorModel->check($username , $password);

            if (!$check) {
                sleep(1);
                $this->set('message', 'Došlo je do greške: Pogrešana lozinka.');
                return;
            }


            $this->getSession()->put('administrator_id', $admin->administrator_id);
            $this->getSession()->save();
            $this->redirect(\Configuration::BASE . '');


        }
    }