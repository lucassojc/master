<?php
    namespace App\Models;

    use App\Core\DatabaseConnection;
    use App\Core\Model;
    use App\Core\Field;
    use App\Validators\NumberValidator;
    use App\Validators\DateTimeValidator;
    use App\Validators\StringValidator;

    class PlanJavnihNabavkiModel extends Model{
        protected function getFields(): array {
            return [
                'plan_javnih_nabavki_id'    => new Field((new NumberValidator())->setIntegerLength(10), false),
                'vrsta_predmeta'            => new Field((new StringValidator())->setMaxLength(128)), //enum
                'vrsta_postupka'            => new Field((new StringValidator())->setMaxLength(128)), //enum
                'opis_pjn'                  => new Field((new StringValidator())->setMaxLength(512)),
                'iznos_sa_pdv'              => new Field((new NumberValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)),
                'iznos_bez_pdv'             => new Field((new NumberValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)),
                'godina_2019'               => new Field((new NumberValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)),
                'godina_2020'               => new Field((new NumberValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)),
                'godina_2021'               => new Field((new NumberValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)),
                'postupak_pokrenut_at'       => new Field((new StringValidator())->setMaxLength(128)),    //date
                'ugovor_zakljucen_at'       => new Field((new StringValidator())->setMaxLength(128)),    //date
                'ugovor_izvrsen_at'         => new Field((new StringValidator())->setMaxLength(128)),    //date
                'napomena'                  => new Field((new StringValidator())->setMaxLength(1024)),
                'razlog'                    => new Field((new StringValidator())->setMaxLength(1024)),
                'program_poslovanja_id'     => new Field((new StringValidator())->setMaxLength(128)),
                'administrator_id'          => new Field((new NumberValidator())->setIntegerLength(10))
            ];
        }

        public function innerJoinPlan() {
            $sql = 'SELECT * FROM plan_javnih_nabavki INNER JOIN program_poslovanja ON plan_javnih_nabavki.program_poslovanja_id = program_poslovanja.program_poslovanja_id ';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute();
            $items = [];
            if ($res) {
                $items = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $items;
        }

        public function innerJoinPlanAdmin() {
            $sql = 'SELECT * FROM plan_javnih_nabavki INNER JOIN administrator ON plan_javnih_nabavki.administrator_id = administrator.administrator_id ';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute();
            $items = [];
            if ($res) {
                $items = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $items;
        }

        public function getDobra(int $id) {
            $sql = 'SELECT * FROM plan_javnih_nabavki INNER JOIN administrator ON plan_javnih_nabavki.administrator_id = administrator.administrator_id INNER JOIN program_poslovanja ON plan_javnih_nabavki.program_poslovanja_id=program_poslovanja.program_poslovanja_id WHERE plan_javnih_nabavki.vrsta_predmeta = "Добра" AND plan_javnih_nabavki.administrator_id = ?; ';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute([$id]);
            $items = [];
            if ($res) {
                $items = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $items;        
        }

        public function getAllDobra() {
            $sql = 'SELECT * FROM plan_javnih_nabavki INNER JOIN administrator ON plan_javnih_nabavki.administrator_id = administrator.administrator_id INNER JOIN program_poslovanja ON plan_javnih_nabavki.program_poslovanja_id=program_poslovanja.program_poslovanja_id WHERE plan_javnih_nabavki.vrsta_predmeta = "Добра"; ';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute();
            $items = [];
            if ($res) {
                $items = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $items;        
        }

        public function getUsluge() {
            $sql = 'SELECT * FROM plan_javnih_nabavki INNER JOIN administrator ON plan_javnih_nabavki.administrator_id = administrator.administrator_id INNER JOIN program_poslovanja ON plan_javnih_nabavki.program_poslovanja_id=program_poslovanja.program_poslovanja_id WHERE plan_javnih_nabavki.vrsta_predmeta = "Услуге" ';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute();
            $items = [];
            if ($res) {
                $items = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $items;        
        }

        public function getRadovi() {
            $sql = 'SELECT * FROM plan_javnih_nabavki INNER JOIN administrator ON plan_javnih_nabavki.administrator_id = administrator.administrator_id INNER JOIN program_poslovanja ON plan_javnih_nabavki.program_poslovanja_id=program_poslovanja.program_poslovanja_id WHERE plan_javnih_nabavki.vrsta_predmeta = "Радови" ';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute();
            $items = [];
            if ($res) {
                $items = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $items;        
        }

        public function getDobraSum() {
            $sql = 'SELECT SUM(iznos_bez_pdv) AS suma FROM plan_javnih_nabavki WHERE vrsta_predmeta = "Добра"';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute();

            if ($res) {
                $item = $prep->fetch(\PDO::FETCH_OBJ);

				if ($item) {
					return $item->suma;
				}
            }

            return 0;     
        }

        public function getUslugeSum() {
            $sql = 'SELECT SUM(iznos_bez_pdv) AS suma FROM plan_javnih_nabavki WHERE vrsta_predmeta = "Услуге"';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute();

            if ($res) {
                $item = $prep->fetch(\PDO::FETCH_OBJ);

				if ($item) {
					return $item->suma;
				}
            }

            return 0;
        }

        public function getRadoviSum() {
            $sql = 'SELECT SUM(iznos_bez_pdv) AS suma FROM plan_javnih_nabavki WHERE vrsta_predmeta = "Радови"';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute();

            if ($res) {
                $item = $prep->fetch(\PDO::FETCH_OBJ);

				if ($item) {
					return $item->suma;
				}
            }
            return 0;
        }

        public function getSum() {
            $sql = 'SELECT SUM(iznos_bez_pdv) AS suma FROM plan_javnih_nabavki';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute();

            if ($res) {
                $item = $prep->fetch(\PDO::FETCH_OBJ);

				if ($item) {
					return $item->suma;
				}
            }
            return 0;
        }
    }