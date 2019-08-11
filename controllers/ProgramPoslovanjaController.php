<?php 
    namespace App\Controllers;
    
    use App\Models\ProgramPoslovanjaModel;
    use App\Core\Controller;
    use App\Core\Role\AdminRoleController;
    
    class ProgramPoslovanjaController extends AdminRoleController {
        public function getProgram() {
            $programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());
            $programi = $programPoslovanjaModel->getAll();
            $this->set('programi', $programi);
        }
        public function getAdd() {

        }

        public function postAdd() {
            $programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());

            $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            
            if(in_array($_FILES["file"]["type"],$allowedFileType)){

                    $targetPath = 'assets/uploads/'.$_FILES['file']['name'];
                    move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
                    
                    $Reader = new SpreadsheetReader($targetPath);
                    
                    $sheetCount = count($Reader->sheets());
                    for($i=0;$i<$sheetCount;$i++)
                    {
                        
                        $Reader->ChangeSheet($i);
                        
                        foreach ($Reader as $Row)
                        {
                    
                            $aproprijacija = "";
                            if(isset($Row[0])) {
                                $aproprijacija = mysqli_real_escape_string($programPoslovanjaModel,$Row[0]);
                            }
                            
                            $opis = "";
                            if(isset($Row[1])) {
                                $opis = mysqli_real_escape_string($programPoslovanjaModel,$Row[1]);
                            }

                            $iznos = "";
                            if(isset($Row[2])) {
                                $iznos = mysqli_real_escape_string($programPoslovanjaModel,$Row[2]);
                            }
                            
                            if (!empty($aproprijacija) || !empty($opis) || !empty($iznos)) {
                                $query = "INSERT INTO program_poslovanja(aproprijacija,opis,iznos) VALUES ('".$aproprijacija."','".$opis."','".$iznos."')";
                                $result = mysqli_query($programPoslovanjaModel, $query);
                            
                                if (! empty($result)) {
                                    $type = "success";
                                    $message = "Excel Data Imported into the Database";
                                } else {
                                    $type = "error";
                                    $message = "Problem in Importing Excel Data";
                                }
                            }
                        }
                    
                    }
            }
            else
            { 
                    $type = "error";
                    $message = "Invalid File Type. Upload Excel File.";
            }
            // $aproprijacija = \filter_input(INPUT_POST, 'aproprijacija_pp', FILTER_SANITIZE_STRING);
            // $opis = \filter_input(INPUT_POST, 'opis', FILTER_SANITIZE_STRING);
            // $iznos = \filter_input(INPUT_POST, 'iznos', FILTER_SANITIZE_STRING);
            // $administratorId =  $this->getSession()->get('administrator_id');

            // $programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());

            // $programPoslovanjaId = $programPoslovanjaModel->add([
            //     'aproprijacija_pp' => $aproprijacija,
            //     'opis' => $opis,
            //     'iznos' => $iznos,
            //     'administrator_id' => $administratorId
            // ]);

            // if (!$programPoslovanjaId) {
            //     $this->set('message', 'Došlo je do greške: Nije moguće dodati ovaj Program Poslovanja.');
            //     return;
            // }

            // $this->redirect(\Configuration::BASE . 'program-poslovanja');
        }
    }
