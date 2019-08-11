<?php
    namespace App\Controllers;

    use App\Models\PlanJavnihNabavkiModel;
    use App\Models\RealizacijaSprovodjenjaNabavkeModel;
    use App\Core\Controller;


    class RealizacijaSprovodjenjaNabavkeController extends Controller {
        public function getRealizacija() {
            $realizacijaSprovodjenjaNabavkeModel = new RealizacijaSprovodjenjaNabavkeModel($this->getDatabaseConnection());
            $realizacije = $realizacijaSprovodjenjaNabavkeModel->innerJoinRealizacija();
            $this->set('realizacije', $realizacije);
            

        }

        public function getAdd() {
            $planJavnihNabavkiModel = new PlanJavnihNabavkiModel($this->getDatabaseConnection());
            $planovi = $planJavnihNabavkiModel->getAll();
            $this->set('planovi', $planovi);
        }

        public function postAdd() {
            
            $pjn_id = \filter_input(INPUT_POST, 'plan_javnih_nabavki_id', FILTER_SANITIZE_STRING);
            $broj = \filter_input(INPUT_POST, 'broj', FILTER_SANITIZE_STRING);
            $zahtev = \filter_input(INPUT_POST, 'zahtev', FILTER_SANITIZE_STRING);
            $odluka = \filter_input(INPUT_POST, 'odluka', FILTER_SANITIZE_STRING);
            $resenje = \filter_input(INPUT_POST, 'resenje', FILTER_SANITIZE_STRING);
            $izjava = \filter_input(INPUT_POST, 'izjava', FILTER_SANITIZE_STRING);
            $datum_direktor = \filter_input(INPUT_POST, 'datum_direktor', FILTER_SANITIZE_STRING);
            $datum_ojn = \filter_input(INPUT_POST, 'datum_ojn', FILTER_SANITIZE_STRING);
            $otvaranje_ponuda = \filter_input(INPUT_POST, 'otvaranje_ponuda', FILTER_SANITIZE_STRING);
            $administratorId =  $this->getSession()->get('administrator_id');

            echo 'vrednosti  -   ' .$pjn_id. ' / ' .$broj. ' / ' .$zahtev. ' / ' .$odluka. ' / ' .$resenje. ' / ' .$izjava. ' / ' .$datum_direktor. ' / ' .$datum_ojn. ' / ' .$otvaranje_ponuda. ' / ' .$administratorId;

            $realizacijaSprovodjenjaNabavkeModel = new RealizacijaSprovodjenjaNabavkeModel($this->getDatabaseConnection());

            $realizacijaSprovodjenjaNabavkeId = $realizacijaSprovodjenjaNabavkeModel->add([
                'plan_javnih_nabavki_id'    => $pjn_id,
                'broj'                      => $broj,
                'zahtev'                    => $zahtev,
                'odluka'                    => $odluka,
                'resenje'                   => $resenje,
                'izjava'                    => $izjava,
                'datum_direktor'            => $datum_direktor,
                'datum_ojn'                 => $datum_ojn,
                'otvaranje_ponuda'          => $otvaranje_ponuda,
                'administrator_id'          => $administratorId
            ]);

            if (!$realizacijaSprovodjenjaNabavkeId) {
                $this->set('message', 'Došlo je do greške: Nije moguće sprovesti ovu nabavku.');
                return;
            }

            $this->redirect(\Configuration::BASE . 'realizacija-sprovodjenja-nabavke');
        }
    }