<?php
    namespace App\Controllers;

    use App\Models\PlanJavnihNabavkiModel;
    use App\Models\ProgramPoslovanjaModel;
    use App\Core\Role\AdminRoleController;

    class PlanJavnihNabavkiController extends AdminRoleController {
        public function getPlan() {
            $planJavnihNabavkiModel = new PlanJavnihNabavkiModel($this->getDatabaseConnection());
            $planovi = $planJavnihNabavkiModel->getAll();
            $this->set('planovi', $planovi);
        }

        public function getAdd() {
            $programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());
            $programi = $programPoslovanjaModel->getAll();
            $this->set('programi', $programi);
        }

        public function postAdd() {

            $aproprijacijaFk = \filter_input(INPUT_POST, 'aproprijacija_fk', FILTER_SANITIZE_STRING);
            $odeljenje = \filter_input(INPUT_POST, 'odeljenje', FILTER_SANITIZE_STRING);
            $vrstaPredmeta = \filter_input(INPUT_POST, 'vrsta_predmeta', FILTER_SANITIZE_STRING);
            $vrstaPostupka = \filter_input(INPUT_POST, 'vrsta_postupka', FILTER_SANITIZE_STRING);
            $opis = \filter_input(INPUT_POST, 'opis', FILTER_SANITIZE_STRING);
            $iznosBezPdvInput = \filter_input(INPUT_POST, 'iznos_bez_pdv', FILTER_SANITIZE_STRING);
            $godina2019Input = \filter_input(INPUT_POST, 'godina_2019', FILTER_SANITIZE_STRING);
            $godina2020Input = \filter_input(INPUT_POST, 'godina_2020', FILTER_SANITIZE_STRING);
            $godina2021Input = \filter_input(INPUT_POST, 'godina_2021', FILTER_SANITIZE_STRING);
            $pokretanjePostupka = \filter_input(INPUT_POST, 'pokretanje_postupka', FILTER_SANITIZE_STRING);
            $zakljucenjeUgovora = \filter_input(INPUT_POST, 'zakljucenje_ugovora', FILTER_SANITIZE_STRING);
            $izvrsenjeUgovora = \filter_input(INPUT_POST, 'izvrsenje_ugovora', FILTER_SANITIZE_STRING);
            $napomena = \filter_input(INPUT_POST, 'napomena', FILTER_SANITIZE_STRING);
            $razlog = \filter_input(INPUT_POST, 'razlog', FILTER_SANITIZE_STRING);
            $kontrolniIznos = \filter_input(INPUT_POST, 'kontrolni_iznos', FILTER_SANITIZE_STRING);
            $administratorId =  $this->getSession()->get('administrator_id');

            $iznosBezPdv = number_format($iznosBezPdvInput, 2, '.', '');
            $result = $iznosBezPdv * 1.20;
            $iznosSaPdv = number_format($result, 2, '.', '');
            $godina2019 = number_format($godina2019Input, 2, '.', '');
            $godina2020 = number_format($godina2020Input, 2, '.', '');
            $godina2021 = number_format($godina2021Input, 2, '.', '');


            $planJavnihNabavkiModel = new PlanJavnihNabavkiModel($this->getDatabaseConnection());

            $planJavnihNabavkiId = $planJavnihNabavkiModel->add([
                'aproprijacija_fk'    => $aproprijacijaFk,
                'odeljenje'           => $odeljenje,
                'vrsta_predmeta'      => $vrstaPredmeta,
                'vrsta_postupka'      => $vrstaPostupka,
                'opis'                => $opis,
                'iznos_sa_pdv'        => $iznosSaPdv,
                'iznos_bez_pdv'       => $iznosBezPdv,
                '2019'                => $godina2019,
                '2020'                => $godina2020,
                '2021'                => $godina2021,
                'pokretanje_postupka' => $pokretanjePostupka,
                'zakljucenje_ugovora' => $zakljucenjeUgovora,
                'izvrsenje_ugovora'   => $izvrsenjeUgovora,
                'napomena'            => $napomena,
                'razlog'              => $razlog,
                'kontrolni_iznos'     => $kontrolniIznos,
                'administrator_id'    => $administratorId
            ]);

            echo 'vrednosti  -   ' .$aproprijacijaFk. ' / ' .$odeljenje. ' / ' .$vrstaPredmeta. ' / ' .$vrstaPostupka. ' / ' .$opis. ' / sa pvd-om ' .$iznosSaPdv. ' /  bez pdv-a ' .$iznosBezPdv. ' / ' .$godina2019. ' / ' .$godina2020. ' / ' .$godina2021. ' / ' .$pokretanjePostupka. ' / ' .$zakljucenjeUgovora. ' / ' .$izvrsenjeUgovora. ' / ' .$napomena. ' / ' .$razlog. ' / ' .$kontrolniIznos. ' / ' .$administratorId;
            if (!$planJavnihNabavkiId) {
                $this->set('message', 'Došlo je do greške: Nije moguće dodati ovaj Program Poslovanja.');
                return;
            }

            $this->redirect(\Configuration::BASE . 'plan-javnih-nabavki');
        }
    }
    