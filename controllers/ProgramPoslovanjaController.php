<?php 
    namespace App\Controllers;

    use App\Models\ProgramPoslovanjaModel;
    use App\Core\Controller;
    use App\Core\Role\AdminRoleController;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    class ProgramPoslovanjaController extends AdminRoleController {
        // public function getProgram() {
        //     $programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());
        //     $programi = $programPoslovanjaModel->getAll();
        //     $this->set('programi', $programi);
        // }

        public function getProgram() {

            $programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());
            $programi = $programPoslovanjaModel->getAll();
            $this->set('programi', $programi);

            $length = count($programi);
            
            $array = json_decode(json_encode($programi), True);

            // $konto = [];
            // for ($i=0; $i<$length; $i++) {               
            //     $konto[] = $programi[$i]->konto;
            // }

            $spreadsheet = new Spreadsheet();

            $spreadsheet->getActiveSheet()->setCellValue('A1', 'Рб');
            $spreadsheet->getActiveSheet()->setCellValue('B1', 'Конто');
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'Опис');
            $spreadsheet->getActiveSheet()->setCellValue('D1', 'Износ');

            $spreadsheet->getActiveSheet()
                        ->fromArray(
                        $array,  
                        NULL,
                        'A2'
                        );

            // $columnKonto = array_chunk($konto, 1);
            // $spreadsheet->getActiveSheet()
            //             ->fromArray(
            //             $columnKonto,  
            //             NULL,
            //             'B2'
            //             );
            $writer = new Xlsx($spreadsheet);
            $writer->save('assets/downloads/program_poslovanja.xlsx');

            if(isset($_REQUEST["program_poslovanja.xlsx"])){
                // Get parameters
                $file = urldecode($_REQUEST["program_poslovanja.xlsx"]); // Decode URL-encoded string
                $filepath = "assets/uploads/" . $file;
                
                // Process download
                if(file_exists($filepath)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($filepath));
                    flush(); // Flush system output buffer
                    readfile($filepath);
                    exit;
                }
            }

        }
    }
