<?php
    namespace App\Controllers;

    use App\Models\PlanJavnihNabavkiModel;
    use App\Models\ProgramPoslovanjaModel;
    use App\Core\Role\AdminRoleController;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

    class PlanJavnihNabavkiController extends AdminRoleController {
        public function getPlan() {
            $planJavnihNabavkiModel = new PlanJavnihNabavkiModel($this->getDatabaseConnection());
            $administratorId = $this->getSession()->get('administrator_id');
			$this->set('administratorId', $administratorId);

            // $dobra = $planJavnihNabavkiModel->getDobra($administratorId);
            $dobra = $planJavnihNabavkiModel->getAllDobra($administratorId);
            $this->set('dobra', $dobra);

            $usluge = $planJavnihNabavkiModel->getUsluge();
            $this->set('usluge', $usluge);

            $radovi = $planJavnihNabavkiModel->getRadovi();
            $this->set('radovi', $radovi);

            $dobraSum = $planJavnihNabavkiModel->getDobraSum();
            $this->set('dobraSum', $dobraSum);

            $uslugeSum = $planJavnihNabavkiModel->getUslugeSum();
            $this->set('uslugeSum', $uslugeSum);

            $radoviSum = $planJavnihNabavkiModel->getRadoviSum();
            $this->set('radoviSum', $radoviSum);

            $sum = $planJavnihNabavkiModel->getSum();
            $this->set('sum', $sum);

			return [
				$dobra,
				$usluge,
				$radovi
			];
        }

		private function makeHeader(&$spreadsheet) {
			$spreadsheet->getActiveSheet()  ->setCellValue('B2', 'Рб')
                                            ->mergeCells('B2:B3')
                                            ->setCellValue('C2', 'Предмет набавке')
                                            ->mergeCells('C2:C3')
                                            ->setCellValue('D2', 'Процењена вредност без ПДВ-а (укупна, по годинама)')
                                            ->mergeCells('D2:D3')
                                            ->setCellValue('E2', 'Планирана средства у буџету / фин.плану')
                                            ->mergeCells('E2:G2')
                                            ->setCellValue('H2', 'Врста поступка')
                                            ->mergeCells('H2:H3')
                                            ->setCellValue('I2', 'Оквирни датум')
                                            ->mergeCells('I2:K2')
                                            ->setCellValue('E3', 'без ПДВ-а')
                                            ->setCellValue('F3', 'са ПДВ-ом')
                                            ->setCellValue('G3', 'Конто / позиција')
                                            ->setCellValue('I3', 'Покретање поступка')
                                            ->setCellValue('J3', 'Закључење уговора')
                                            ->setCellValue('K3', 'Извршење уговора')
                                            ->setCellValue('B4', 'Укупно')
                                            ->mergeCells('B4:C4')
                                            ->setCellValue('D4', '')
                                            ->setCellValue('E4', '')
                                            ->mergeCells('E4:K4');

			
            $spreadsheet->getActiveSheet()
                        ->getStyle('B2:K4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()
                        ->getStyle('B2:K4')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()
                        ->getStyle('B2:K4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DCDCDC');

		}

		private function makeRows(&$spreadsheet, &$podaci, &$nextIndex, &$lastIndex) {
			for ($i=0; $i < count($podaci); $i++) {
				$rowIndex = ($i+1)*6 + $nextIndex;

				# ODAVDE:

				# 1. Merge
				# 2. Format
				# 3. Fill in

				# ID
				$spreadsheet->getActiveSheet()->mergeCells('B' . $rowIndex . ':B' . ($rowIndex+5));
				$spreadsheet->getActiveSheet()->setCellValue('B' . $rowIndex, $podaci[$i]->plan_javnih_nabavki_id);
				$spreadsheet->getActiveSheet()->getStyle('B' . $rowIndex . ':B' . ($rowIndex+5))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
				# kao za number format integer i uradite right align sa indent 1

				# OPIS
				$spreadsheet->getActiveSheet()->mergeCells('C' . $rowIndex . ':C' . ($rowIndex+3));
				$spreadsheet->getActiveSheet()->getStyle('C' . $rowIndex . ':C' . ($rowIndex+3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
				$spreadsheet->getActiveSheet()->setCellValue('C' . $rowIndex, str_replace(["\r", "\n"], ' ', $podaci[$i]->opis_pjn));
                # isto kao dole, samo za string (text)...
                
                # Procenjena vrednost po godinama
                $borderOutline = array(
                    'borders' => array(
                        'outline' => array(
                            'borderStyle' => Border::BORDER_THIN,
                        ),
                    ),
                );
                $spreadsheet->getActiveSheet()->getStyle('D' . $rowIndex . ':D' . ($rowIndex+3))->applyFromArray($borderOutline);    
                # BEZ PDV
				$spreadsheet->getActiveSheet()->setCellValue('D' . $rowIndex, sprintf("%.2f", $podaci[$i]->iznos_bez_pdv));
				$spreadsheet->getActiveSheet()->getStyle('D' . $rowIndex)->getNumberFormat()->setFormatCode('#.00');                
                # 2019
				$spreadsheet->getActiveSheet()->setCellValue('D' . ($rowIndex+1), '2019 - '.$podaci[$i]->godina_2019);
				$spreadsheet->getActiveSheet()->getStyle('D' . ($rowIndex+1))->getNumberFormat()->setFormatCode('#.00');                
                # 2020
				$spreadsheet->getActiveSheet()->setCellValue('D' . ($rowIndex+2), '2020 - '.$podaci[$i]->godina_2020);
				$spreadsheet->getActiveSheet()->getStyle('D' . ($rowIndex+2))->getNumberFormat()->setFormatCode('#.00');                
                # 2021
				$spreadsheet->getActiveSheet()->setCellValue('D' . ($rowIndex+3), '2021 - '.$podaci[$i]->godina_2021);
				$spreadsheet->getActiveSheet()->getStyle('D' . ($rowIndex+3))->getNumberFormat()->setFormatCode('#.00');
                
                # 2019 bez pdv
                $spreadsheet->getActiveSheet()->mergeCells('E' . $rowIndex . ':E' . ($rowIndex+3));
                $spreadsheet->getActiveSheet()->getStyle('E' . $rowIndex . ':E' . ($rowIndex+3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
				$spreadsheet->getActiveSheet()->setCellValue('E' . $rowIndex, sprintf("%.2f", $podaci[$i]->godina_2019));
				$spreadsheet->getActiveSheet()->getStyle('E' . $rowIndex)->getNumberFormat()->setFormatCode('#.00');

                #2019 sa pdv
                $spreadsheet->getActiveSheet()->mergeCells('F' . $rowIndex . ':F' . ($rowIndex+3));
                $spreadsheet->getActiveSheet()->getStyle('F' . $rowIndex . ':F' . ($rowIndex+3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
				$spreadsheet->getActiveSheet()->setCellValue('F' . $rowIndex, sprintf("%.2f", $podaci[$i]->iznos_sa_pdv));
                $spreadsheet->getActiveSheet()->getStyle('F' . $rowIndex)->getNumberFormat()->setFormatCode('#.00');
                
                #KONTO
                $spreadsheet->getActiveSheet()->mergeCells('G' . $rowIndex . ':G' . ($rowIndex+3));
                $spreadsheet->getActiveSheet()->getStyle('G' . $rowIndex . ':G' . ($rowIndex+3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->setCellValue('G' . $rowIndex, $podaci[$i]->konto);
                
                #VRSTA POSTUPKA
                $spreadsheet->getActiveSheet()->mergeCells('H' . $rowIndex . ':H' . ($rowIndex+3));
                $spreadsheet->getActiveSheet()->getStyle('H' . $rowIndex . ':H' . ($rowIndex+3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->setCellValue('H' . $rowIndex, $podaci[$i]->vrsta_postupka);

                #POKRETANJE POSTUPKA
                $spreadsheet->getActiveSheet()->mergeCells('I' . $rowIndex . ':I' . ($rowIndex+3));
                $spreadsheet->getActiveSheet()->getStyle('I' . $rowIndex . ':I' . ($rowIndex+3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->setCellValue('I' . $rowIndex, $podaci[$i]->postupak_pokrenut_at);
                $spreadsheet->getActiveSheet()->getStyle('I' . $rowIndex)->getNumberFormat()->setFormatCode('dd-mm-yyyy'); 

                #ZAKLJUCENJE UGOVORA
                $spreadsheet->getActiveSheet()->mergeCells('J' . $rowIndex . ':J' . ($rowIndex+3));
                $spreadsheet->getActiveSheet()->getStyle('J' . $rowIndex . ':J' . ($rowIndex+3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->setCellValue('J' . $rowIndex, $podaci[$i]->ugovor_zakljucen_at);
                $spreadsheet->getActiveSheet()->getStyle('J' . $rowIndex)->getNumberFormat()->setFormatCode('dd-mm-yyyy'); 

                #IZVRSENJE UGOVORA
                $spreadsheet->getActiveSheet()->mergeCells('K' . $rowIndex . ':K' . ($rowIndex+3));
                $spreadsheet->getActiveSheet()->getStyle('K' . $rowIndex . ':K' . ($rowIndex+3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->setCellValue('K' . $rowIndex, $podaci[$i]->ugovor_izvrsen_at);
                $spreadsheet->getActiveSheet()->getStyle('K' . $rowIndex)->getNumberFormat()->setFormatCode('dd-mm-yyyy'); 

                #RAZLOG I OPRAVDANOST
                $spreadsheet->getActiveSheet() ->setCellValue('C'. ($rowIndex+4), 'Разлог и оправданост набавке');
                $spreadsheet->getActiveSheet()->mergeCells('D' . ($rowIndex+4) . ':K' . ($rowIndex+4));
                $spreadsheet->getActiveSheet()->getStyle('C' . ($rowIndex+4) . ':K' . ($rowIndex+4))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->setCellValue('D' . ($rowIndex+4), $podaci[$i]->razlog);

                #NAPOMENA
                $spreadsheet->getActiveSheet() ->setCellValue('C'. ($rowIndex+5), 'Начин утврђивања процењене вредности');
                $spreadsheet->getActiveSheet()->mergeCells('D' . ($rowIndex+5) . ':K' . ($rowIndex+5));
                $spreadsheet->getActiveSheet()->getStyle('C' . ($rowIndex+5) . ':K' . ($rowIndex+5))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->setCellValue('D' . ($rowIndex+5), $podaci[$i]->napomena);
                
                $spreadsheet->getActiveSheet()->getStyle('C' . ($rowIndex+4) . ':C' . ($rowIndex+5))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DCDCDC');
                # / DO OVDE;

				$lastIndex = $rowIndex;
            }
		}
		
		private function setSizes(&$spreadsheet) {
			$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		}

		private function downloadFile(&$spreadsheet) {
			$writer = new Xlsx($spreadsheet);
			$uniquePart = date('YmdHisu') . rand(1000, 9999);

			if (!file_exists(\Configuration::TEMP_DIR)) {
				@mkdir(\Configuration::TEMP_DIR, 0755, true);
			}

			$file = \Configuration::TEMP_DIR . \Configuration::EXCEL_PLAN_FILENAME . "-{$uniquePart}.xlsx";
            $writer->save($file);

			ob_clean();
			header('Content-Disposition: attachment; filename=' . basename($file) );
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Length: ' . filesize($file));
			header('Content-Transfer-Encoding: binary');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			readfile($file);
			unlink($file);
			exit;
		}
		
		private function makeGroup($name, &$data) {
			return (object) [
				'naziv_grupe' => $name,
				'items'       => $data
			];
		}

		public function makeExcel() {
			try {
				list($dobra, $usluge, $radovi) = $this->getPlan();

				$spreadsheet = new Spreadsheet();
			} catch (\Exception $e) {
				$this->set('message', 'Doslo je do greske prilikom inicijalizovanje funkcije. '/* . $e->getMessage()*/);
				return;
			}

			try {
				$this->makeHeader($spreadsheet);

				$lastIndex = \Configuration::EXCEL_PLAN_HEADER_OFFSET - 1;

				foreach (
					[
						$this->makeGroup('Dobra',  $dobra),
						$this->makeGroup('Usluge', $usluge),
						$this->makeGroup('Radovi', $radovi)
					] as $group) {
					$nextIndex = $lastIndex + 1;

                    $spreadsheet->getActiveSheet()->setCellValue('B' . ($nextIndex + 5), $group->naziv_grupe);
                    $spreadsheet->getActiveSheet()->mergeCells('B' . ($nextIndex+5) . ':C' . ($nextIndex+5));
                    $spreadsheet->getActiveSheet()->mergeCells('E' . ($nextIndex+5) . ':K' . ($nextIndex+5));
                    $spreadsheet->getActiveSheet()->getStyle('B' . ($nextIndex+5) . ':K' . ($nextIndex+5))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                    $spreadsheet->getActiveSheet()->getStyle('B' . ($nextIndex+5) . ':K' . ($nextIndex+5))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DCDCDC');
                    
					# formatiranje i merge i ostalo za ovo mini zaglavlje...

					$this->makeRows($spreadsheet, $group->items, $nextIndex, $lastIndex);
				}

				$this->setSizes($spreadsheet);
			} catch (\Exception $e) {
				$this->set('message', 'Doslo je do greske prilikom popunjavanja Excel datoteke. '/* . $e->getMessage()*/);
				return;
			}

			try {
				$this->downloadFile($spreadsheet);
			} catch (\Exception $e) {
				$this->set('message', 'Doslo je do greske prilikom slanja Excel datoteke Vama. '/* . $e->getMessage()*/);
			}
		}

        public function getAdd() {
            $programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());
            $programi = $programPoslovanjaModel->getAll();
            $this->set('programi', $programi);
        }

        public function postAdd() {
            $programPoslovanjaId = \filter_input(INPUT_POST, 'program_poslovanja_id', FILTER_SANITIZE_STRING);
            $vrstaPredmeta = \filter_input(INPUT_POST, 'vrsta_predmeta', FILTER_SANITIZE_STRING);
            $vrstaPostupka = \filter_input(INPUT_POST, 'vrsta_postupka', FILTER_SANITIZE_STRING);
            $opisPjn = \filter_input(INPUT_POST, 'opis_pjn', FILTER_SANITIZE_STRING);
            $iznosBezPdvInput = \filter_input(INPUT_POST, 'iznos_bez_pdv', FILTER_SANITIZE_STRING);
            $godina2019Input = \filter_input(INPUT_POST, 'godina_2019', FILTER_SANITIZE_STRING);
            $godina2020Input = \filter_input(INPUT_POST, 'godina_2020', FILTER_SANITIZE_STRING);
            $godina2021Input = \filter_input(INPUT_POST, 'godina_2021', FILTER_SANITIZE_STRING);
            $postupakPokrenutAt = \filter_input(INPUT_POST, 'postupak_pokrenut_at', FILTER_SANITIZE_STRING);
            $ugovorZakljucenAt = \filter_input(INPUT_POST, 'ugovor_zakljucen_at', FILTER_SANITIZE_STRING);
            $ugovorIzvrsenAt = \filter_input(INPUT_POST, 'ugovor_izvrsen_at', FILTER_SANITIZE_STRING);
            $napomena = \filter_input(INPUT_POST, 'napomena', FILTER_SANITIZE_STRING);
            $razlog = \filter_input(INPUT_POST, 'razlog', FILTER_SANITIZE_STRING);
            $programPoslovanjaId = \filter_input(INPUT_POST, 'program_poslovanja_id', FILTER_SANITIZE_STRING);
            $administratorId =  $this->getSession()->get('administrator_id');

            $iznosBezPdv = number_format($iznosBezPdvInput, 2, '.', '');
            $result = $godina2019Input * 1.20;
            $iznosSaPdv = number_format($result, 2, '.', '');
            $godina2019 = number_format($godina2019Input, 2, '.', '');
            $godina2020 = number_format($godina2020Input, 2, '.', '');
            $godina2021 = number_format($godina2021Input, 2, '.', '');
            $zbir = $godina2019 + $godina2020 + $godina2021;

            if ($zbir > $iznosBezPdv) {
                $this->set('message', 'Došlo je do greške: Zbir godina mora da bude jednak iznosu bez pdv-a.');
                return;
            }


            //klontrolni iznos uraditi (raspoloziva sredstva)

            // echo 'vrednosti  -   ' .$programPoslovanjaId. ' / ' .$odeljenje. ' / ' .$vrstaPredmeta. ' / ' .$vrstaPostupka. ' / ' .$opisPjn. ' / sa pvd-om ' .$iznosSaPdv. ' /  bez pdv-a ' .$iznosBezPdv. ' / ' .$godina2019. ' / ' .$godina2020. ' / ' .$godina2021. ' / ' .$pokretanjePostupka. ' / ' .$zakljucenjeUgovora. ' / ' .$izvrsenjeUgovora. ' / ' .$napomena. ' / ' .$razlog. ' / ' .$kontrolniIznos. ' / ' .$administratorId;

            $planJavnihNabavkiModel = new PlanJavnihNabavkiModel($this->getDatabaseConnection());

            $planJavnihNabavkiId = $planJavnihNabavkiModel->add([
                'program_poslovanja_id'     => $programPoslovanjaId,
                'vrsta_predmeta'            => $vrstaPredmeta,
                'vrsta_postupka'            => $vrstaPostupka,
                'opis_pjn'                  => $opisPjn,
                'iznos_sa_pdv'              => $iznosSaPdv,
                'iznos_bez_pdv'             => $iznosBezPdv,
                'godina_2019'               => $godina2019,
                'godina_2020'               => $godina2020,
                'godina_2021'               => $godina2021,
                'postupak_pokrenut_at'      => $postupakPokrenutAt,
                'ugovor_zakljucen_at'       => $ugovorZakljucenAt,
                'ugovor_izvrsen_at'         => $ugovorIzvrsenAt,
                'napomena'                  => $napomena,
                'razlog'                    => $razlog,
                'program_poslovanja_id'     => $programPoslovanjaId,
                'administrator_id'          => $administratorId

            ]);

            print_r ($iznosBezPdv);

            if (!$planJavnihNabavkiId) {
                $this->set('message', 'Došlo je do greške: Nije moguće sprovesti ovu nabavku.' . $programPoslovanjaId ."/".$vrstaPredmeta."/".$vrstaPostupka."/". $opisPjn ."/".$iznosSaPdv."/".$iznosBezPdv."/".
                 $godina2019 ."/".$godina2020."/".$godina2021."/".$postupakPokrenutAt."/".$ugovorZakljucenAt."/".$ugovorIzvrsenAt."/"
                 .$napomena."/".$razlog."/".$programPoslovanjaId."/".$administratorId);
                return;
            }

            $this->redirect(\Configuration::BASE . 'plan-javnih-nabavki');
        }

        public function getEdit($planJavnihNabavkiId) {
            $planJavnihNabavkiModel = new PlanJavnihNabavkiModel($this->getDatabaseConnection());
            $planJavnihNabavki = $planJavnihNabavkiModel->getById($planJavnihNabavkiId);

            if (!$planJavnihNabavki) {
                $this->redirect(\Configuration::BASE . 'plan-javnih-nabavki');
            }

			$administratorId = $this->getSession()->get('administrator_id');
			if ($planJavnihNabavki->administrator_id != $administratorId) {
				$this->redirect(\Configuration::BASE . 'plan-javnih-nabavki');
				return;
			}

            $this->set('plan', $planJavnihNabavki);

            $programPoslovanjaModel = new ProgramPoslovanjaModel($this->getDatabaseConnection());
            $programi = $programPoslovanjaModel->getAll();
            $this->set('programi', $programi);

            return $planJavnihNabavkiModel;

        }

        public function postEdit($planJavnihNabavkiId) {
            $planJavnihNabavkiModel = $this->getEdit($planJavnihNabavkiId);

            $programPoslovanjaId = \filter_input(INPUT_POST, 'program_poslovanja_id', FILTER_SANITIZE_STRING);
            $vrstaPredmeta = \filter_input(INPUT_POST, 'vrsta_predmeta', FILTER_SANITIZE_STRING);
            $vrstaPostupka = \filter_input(INPUT_POST, 'vrsta_postupka', FILTER_SANITIZE_STRING);
            $opisPjn = \filter_input(INPUT_POST, 'opis_pjn', FILTER_SANITIZE_STRING);
            $iznosBezPdvInput = \filter_input(INPUT_POST, 'iznos_bez_pdv', FILTER_SANITIZE_STRING);
            $godina2019Input = \filter_input(INPUT_POST, 'godina_2019', FILTER_SANITIZE_STRING);
            $godina2020Input = \filter_input(INPUT_POST, 'godina_2020', FILTER_SANITIZE_STRING);
            $godina2021Input = \filter_input(INPUT_POST, 'godina_2021', FILTER_SANITIZE_STRING);
            $postupakPokrenutAt = \filter_input(INPUT_POST, 'postupak_pokrenut_at', FILTER_SANITIZE_STRING);
            $ugovorZakljucenAt = \filter_input(INPUT_POST, 'ugovor_zakljucen_at', FILTER_SANITIZE_STRING);
            $ugovorIzvrsenAt = \filter_input(INPUT_POST, 'ugovor_izvrsen_at', FILTER_SANITIZE_STRING);
            $napomena = \filter_input(INPUT_POST, 'napomena', FILTER_SANITIZE_STRING);
            $razlog = \filter_input(INPUT_POST, 'razlog', FILTER_SANITIZE_STRING);
            $programPoslovanjaId = \filter_input(INPUT_POST, 'program_poslovanja_id', FILTER_SANITIZE_STRING);
            $administratorId =  $this->getSession()->get('administrator_id');

            $iznosBezPdv = number_format($iznosBezPdvInput, 2, '.', '');
            $result = $godina2019Input * 1.20;
            $iznosSaPdv = number_format($result, 2, '.', '');
            $godina2019 = number_format($godina2019Input, 2, '.', '');
            $godina2020 = number_format($godina2020Input, 2, '.', '');
            $godina2021 = number_format($godina2021Input, 2, '.', '');
            $zbir = $godina2019 + $godina2020 + $godina2021;


            $planJavnihNabavkiModel->editById($planJavnihNabavkiId, [
                'program_poslovanja_id'     => $programPoslovanjaId,
                'vrsta_predmeta'            => $vrstaPredmeta,
                'vrsta_postupka'            => $vrstaPostupka,
                'opis_pjn'                  => $opisPjn,
                'iznos_sa_pdv'              => $iznosSaPdv,
                'iznos_bez_pdv'             => $iznosBezPdv,
                'godina_2019'               => $godina2019,
                'godina_2020'               => $godina2020,
                'godina_2021'               => $godina2021,
                'postupak_pokrenut_at'      => $postupakPokrenutAt,
                'ugovor_zakljucen_at'       => $ugovorZakljucenAt,
                'ugovor_izvrsen_at'         => $ugovorIzvrsenAt,
                'napomena'                  => $napomena,
                'razlog'                    => $razlog,
                'program_poslovanja_id'     => $programPoslovanjaId,
                'administrator_id'          => $administratorId
            ]);
            
            $this->redirect(\Configuration::BASE . 'plan-javnih-nabavki');

        }
    }
    