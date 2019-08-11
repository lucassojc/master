<?php
    namespace App\Controllers;

    use App\Models\PlanJavnihNabavkiModel;
    use App\Models\RealizacijaUgovoraModel;
    use App\Core\Role\AdminRoleController;

    class RealizacijaUgovoraController extends AdminRoleController {
        public function getUgovor() {
            $realizacijaUgovoraModel = new RealizacijaUgovoraModel($this->getDatabaseConnection());
            $ugovori = $realizacijaUgovoraModel->innerJoinUgovor();
            $this->set('ugovori', $ugovori);
        }

        public function getAdd() {
            $planJavnihNabavkiModel = new PlanJavnihNabavkiModel($this->getDatabaseConnection());
            $planovi = $planJavnihNabavkiModel->getAll();
            $this->set('planovi', $planovi);
        }

        public function postAdd() {
            $pjnId = \filter_input(INPUT_POST, 'plan_javnih_nabavki_id', FILTER_SANITIZE_STRING);
            $broj = \filter_input(INPUT_POST, 'broj', FILTER_SANITIZE_STRING);
            $sumaInput = \filter_input(INPUT_POST, 'suma', FILTER_SANITIZE_STRING);
            $dobavljac = \filter_input(INPUT_POST, 'dobavljac', FILTER_SANITIZE_STRING);
            $trajanje = \filter_input(INPUT_POST, 'trajanje', FILTER_SANITIZE_STRING);
            $realizacija = \filter_input(INPUT_POST, 'realizacija', FILTER_SANITIZE_STRING);
            $datumRealizacije = \filter_input(INPUT_POST, 'datum_realizacije', FILTER_SANITIZE_STRING);
            $efikasnost = \filter_input(INPUT_POST, 'efikasnost', FILTER_SANITIZE_STRING);
            $potrosenoPlaniranoInput = \filter_input(INPUT_POST, 'potroseno_planirano', FILTER_SANITIZE_STRING);
            $status = \filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
            $napomena = \filter_input(INPUT_POST, 'napomena', FILTER_SANITIZE_STRING);
            $razlogNeizvrsenja = \filter_input(INPUT_POST, 'razlog_neizvrsenja', FILTER_SANITIZE_STRING);
            $administratorId =  $this->getSession()->get('administrator_id');

            $suma = number_format($sumaInput, 2, '.', '');
            $potrosenoPlanirano = number_format($potrosenoPlaniranoInput, 2, '.', '');

            echo 'vrednosti  -   ' .$pjn_id. ' / ' .$broj. ' / ' .$suma. ' / ' .$dobavljac. ' / ' .$trajanje. ' / ' .$realizacija. ' / ' .$datum_realizacije. ' / ' .$efikasnost. ' / ' .$potroseno_planirano. ' / ' .$administratorId;


            $realizacijaUgovoraModel = new RealizacijaUgovoraModel($this->getDatabaseConnection());

            $realizacijaUgovoraId = $realizacijaUgovoraModel->add([
                'plan_javnih_nabavki_id'    => $pjnId,
                'broj'                      => $broj,
                'suma'                      => $suma,
                'dobavljac'                 => $dobavljac,
                'trajanje'                  => $trajanje,
                'realizacija'               => $realizacija,
                'datum_realizacije'         => $datumRealizacije,
                'efikasnost'                => $efikasnost,
                'potroseno_planirano'       => $potrosenoPlanirano,
                'status'                    => $status,
                'napomena'                  => $napomena,
                'razlog_neizvrsenja'        => $razlogNeizvrsenja,
                'administrator_id'          => $administratorId
            ]);

            if (!$realizacijaUgovoraId) {
                $this->set('message', 'Došlo je do greške: Nije moguće realizovati ovaj ugovor.');
                return;
            }

            $this->redirect(\Configuration::BASE . 'realizacija-ugovora');
        }
    }