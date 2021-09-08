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
            $datumUgovoraAt = \filter_input(INPUT_POST, 'datum_ugovora_at', FILTER_SANITIZE_STRING);
            $sumaInput = \filter_input(INPUT_POST, 'suma', FILTER_SANITIZE_STRING);
            $dobavljac = \filter_input(INPUT_POST, 'dobavljac', FILTER_SANITIZE_STRING);
            $trajanje = \filter_input(INPUT_POST, 'trajanje', FILTER_SANITIZE_STRING);
            $realizacijaInput = \filter_input(INPUT_POST, 'realizacija', FILTER_SANITIZE_STRING);
            $ugovorRealizovanAt = \filter_input(INPUT_POST, 'ugovor_realizovan_at', FILTER_SANITIZE_STRING);
            $status = \filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
            $napomena = \filter_input(INPUT_POST, 'napomena', FILTER_SANITIZE_STRING);
            $razlogNeizvrsenja = \filter_input(INPUT_POST, 'razlog_neizvrsenja', FILTER_SANITIZE_STRING);
            $administratorId =  $this->getSession()->get('administrator_id');

            $suma = number_format($sumaInput, 2, '.', '');
            $realizacija = number_format($realizacijaInput, 2, '.', '');
            $potrosenoPlaniranoInput = $suma - $realizacija;
            $potrosenoPlanirano = number_format($potrosenoPlaniranoInput, 2, '.', '');
            $procenat = $sumaInput / 100;
            $ciljInput = $potrosenoPlanirano / $procenat;
            $ciljFromat = number_format($ciljInput, 0);
            $cilj = $ciljFromat .= "%";

            if ($suma < $realizacija) {
                $this->set('message', 'Došlo je do greške: Dogovorena suma je manja od sume potrebne za realizaciju ugovora.');
                return;
            }


            $realizacijaUgovoraModel = new RealizacijaUgovoraModel($this->getDatabaseConnection());

            $realizacijaUgovoraId = $realizacijaUgovoraModel->add([
                'plan_javnih_nabavki_id'    => $pjnId,
                'broj'                      => $broj,
                'datum_ugovora_at'          => $datumUgovoraAt,
                'suma'                      => $suma,
                'dobavljac'                 => $dobavljac,
                'trajanje'                  => $trajanje,
                'realizacija'               => $realizacija,
                'ugovor_realizovan_at'      => $ugovorRealizovanAt,
                'cilj'                      => $cilj,
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