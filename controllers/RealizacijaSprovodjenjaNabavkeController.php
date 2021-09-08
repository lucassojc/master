<?php
    namespace App\Controllers;

    use App\Models\PlanJavnihNabavkiModel;
    use App\Models\RealizacijaSprovodjenjaNabavkeModel;
    use App\Core\Role\AdminRoleController;


    class RealizacijaSprovodjenjaNabavkeController extends AdminRoleController {
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
            
            $pjnId = \filter_input(INPUT_POST, 'plan_javnih_nabavki_id', FILTER_SANITIZE_STRING);
            $broj = \filter_input(INPUT_POST, 'broj', FILTER_SANITIZE_STRING);
            $zahtevPokrenutAt = \filter_input(INPUT_POST, 'zahtev_pokrenut_at', FILTER_SANITIZE_STRING);
            $odlukaDonesenaAt = \filter_input(INPUT_POST, 'odluka_donesena_at', FILTER_SANITIZE_STRING);
            $resenjeAt = \filter_input(INPUT_POST, 'resenje_at', FILTER_SANITIZE_STRING);
            $izjavaAt = \filter_input(INPUT_POST, 'izjava_at', FILTER_SANITIZE_STRING);
            $dokumentacijaDirektorAt = \filter_input(INPUT_POST, 'dokumentacija_direktor_at', FILTER_SANITIZE_STRING);
            $dokumentacijaOjnAt = \filter_input(INPUT_POST, 'dokumentacija_ojn_at', FILTER_SANITIZE_STRING);
            $ponudaOtvorenaAt = \filter_input(INPUT_POST, 'ponuda_otvorena_at', FILTER_SANITIZE_STRING);
            $administratorId =  $this->getSession()->get('administrator_id');

            echo 'vrednosti  -   ' .$pjn_id. ' / ' .$broj. ' / ' .$zahtev. ' / ' .$odluka. ' / ' .$resenje. ' / ' .$izjava. ' / ' .$datum_direktor. ' / ' .$datum_ojn. ' / ' .$otvaranje_ponuda. ' / ' .$administratorId;

            $realizacijaSprovodjenjaNabavkeModel = new RealizacijaSprovodjenjaNabavkeModel($this->getDatabaseConnection());

            $realizacijaSprovodjenjaNabavkeId = $realizacijaSprovodjenjaNabavkeModel->add([
                'plan_javnih_nabavki_id'    => $pjnId,
                'broj'                      => $broj,
                'zahtev_pokrenut_at'        => $zahtevPokrenutAt,
                'odluka_donesena_at'        => $odlukaDonesenaAt,
                'resenje_at'                => $resenjeAt,
                'izjava_at'                 => $izjavaAt,
                'dokumentacija_direktor_at' => $dokumentacijaDirektorAt,
                'dokumentacija_ojn_at'      => $dokumentacijaOjnAt,
                'ponuda_otvorena_at'        => $ponudaOtvorenaAt,
                'administrator_id'          => $administratorId
            ]);

            if (!$realizacijaSprovodjenjaNabavkeId) {
                $this->set('message', 'Došlo je do greške: Nije moguće sprovesti ovu nabavku.');
                return;
            }

            $this->redirect(\Configuration::BASE . 'realizacija-sprovodjenja-nabavke');
        }
    }