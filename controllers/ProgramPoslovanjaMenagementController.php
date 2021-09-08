<?php 
    namespace App\Controllers;

    use App\Models\ProgramPoslovanjaModel;
    use App\Core\Controller;
    use App\Core\Role\SuperAdminRoleController;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class ProgramPoslovanjaMenagementController extends SuperAdminRoleController {
        public function getAdd() {

        }

        public function postAdd() {  
            $programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());
          
            $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            
            if (in_array($_FILES["file"]["type"],$allowedFileType)) {
                $normalized = preg_replace( '/[^a-z0-9.]+/', '', strtolower( $_FILES['file']['name'] ) );
				$targetPath = 'assets/uploads/'.$normalized;
                move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

                $inputFileType = IOFactory::identify($targetPath);
                $reader = IOFactory::createReader($inputFileType);
                $reader->setReadDataOnly(TRUE);
                $spreadsheet = $reader->load($targetPath);
                $worksheet = $spreadsheet->getActiveSheet()->toArray();
                foreach ($worksheet as $Row) {
                    $konto = @$Row[0];
                    $opisPp = @$Row[1];
                    $iznosInput = @$Row[2];
                    $iznos = number_format($iznosInput, 2, '.', '');
                    $programPoslovanja = $programPoslovanjaModel->add([
                        'konto'   => $konto,
                        'opis_pp' => $opisPp,
                        'iznos'   => $iznos
                    ]);

                    if (!$programPoslovanja) {
                        $this->set('message', 'Došlo je do greške: Nije moguće dodati neke od programa ili već postoje.');
                        return;
                    }
                }
            }  else {
                $this->set('message', 'Došlo je do greške: Tip fajla nije podržan.');
            }


            // -----------------------------------------------------

            // $programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());

            // $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            
            // if (in_array($_FILES["file"]["type"],$allowedFileType)) {
            //     $normalized = preg_replace( '/[^a-z0-9.]+/', '', strtolower( $_FILES['file']['name'] ) );
			// 	$targetPath = 'assets/uploads/'.$normalized;
			// 	move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

			// 	$Reader = new \SpreadsheetReader($targetPath);
			// 	$programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());

			// 	$sheetCount = count($Reader->sheets());
			// 	for ($i=0;$i<$sheetCount;$i++) {
            //         $Reader->ChangeSheet($i);
                    
                    

			// 		foreach ($Reader as $Row) {
            //             $konto = @$Row[0];
            //             $opisPp = @$Row[1];
            //             $iznosInput = @$Row[2];
            //             $iznos = number_format($iznosInput, 2, '.', '');
			// 			$programPoslovanja = $programPoslovanjaModel->add([
			// 				'konto'   => $konto,
			// 				'opis_pp' => $opisPp,
			// 				'iznos'   => $iznos
            //             ]);

            //             if (!$programPoslovanja) {
            //                 $this->set('message', 'Došlo je do greške: Nije moguće dodati neke od programa ili već postoje.');
            //                 return;
            //             }
            //         }
            //     }
            // } else {
			// 	$this->set('message', 'Došlo je do greške: Tip fajla nije podržan.');
            // }

            /*if($this->getSession()->get('administrator_id') != 1) {
                $this->redirect(\Configuration::BASE);
            }

            $konto = \filter_input(INPUT_POST, 'konto', FILTER_SANITIZE_STRING);
            $opis = \filter_input(INPUT_POST, 'opis_pp', FILTER_SANITIZE_STRING);
            $iznosInput = \filter_input(INPUT_POST, 'iznos', FILTER_SANITIZE_STRING);

            $iznos = number_format($iznosInput, 2, '.', '');

            $programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());

            $programPoslovanja = $programPoslovanjaModel->add([
                'konto' => $konto,
                'opis_pp' => $opis,
                'iznos' => $iznos
            ]);*/

            // if (!$programPoslovanja) {
//               $this->set('message', 'Došlo je do greške: Nije moguće dodati ovaj Program Poslovanja.');
               //return;
            // }
            $this->redirect(\Configuration::BASE . 'program-poslovanja');
        }

        public function getEdit($programPoslovanjaId) {

            $programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());
            $programPoslovanja = $programPoslovanjaModel->getById($programPoslovanjaId);

            if (!$programPoslovanja) {
                $this->redirect(\Configuration::BASE . 'program-poslovanja');
            }

            $this->set('program', $programPoslovanja);

            $programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());
            $programi = $programPoslovanjaModel->getAll();
            $this->set('programi', $programi);

            return $programPoslovanjaModel;

        }

        public function postEdit($programPoslovanjaId) {
            $programPoslovanjaModel = $this->getEdit($programPoslovanjaId);

            $konto = \filter_input(INPUT_POST, 'konto', FILTER_SANITIZE_STRING);
            $opis = \filter_input(INPUT_POST, 'opis_pp', FILTER_SANITIZE_STRING);
            $iznosInput = \filter_input(INPUT_POST, 'iznos', FILTER_SANITIZE_STRING);

            $iznos = number_format($iznosInput, 2, '.', '');

            $programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());

            $programPoslovanjaModel->editById($programPoslovanjaId, [
                'konto' => $konto,
                'opis_pp' => $opis,
                'iznos' => $iznos
            ]);
            
            $this->redirect(\Configuration::BASE . 'program-poslovanja');
        }
    }
