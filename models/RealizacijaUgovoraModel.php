<?php
    namespace App\Models;

    use App\Core\DatabaseConnection;
    use App\Core\Model;
    use App\Core\Field;
    use App\Validators\NumberValidator;
    use App\Validators\DateTimeValidator;
    use App\Validators\StringValidator;

    class RealizacijaUgovoraModel extends Model{
        protected function getFields(): array {
            return [
                'realizacija_ugovora_id'    => new Field((new NumberValidator())->setIntegerLength(10), false),
                'plan_javnih_nabavki_id'    => new Field((new NumberValidator())->setIntegerLength(10)),
                'broj'                      => new Field((new StringValidator())->setMaxLength(128)),
                'datum_ugovora_at'          => new Field((new StringValidator())->setMaxLength(128)), // date validator ubaciti
                'suma'                      => new Field((new NumberValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)),
                'dobavljac'                 => new Field((new StringValidator())->setMaxLength(128)),
                'trajanje'                  => new Field((new NumberValidator())->setIntegerLength(10)),
                'realizacija'               => new Field((new NumberValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)), 
                'ugovor_realizovan_at'         => new Field((new StringValidator())->setMaxLength(128)), // date validator ubaciti
                'cilj'                      => new Field((new StringValidator())->setMaxLength(128)),
                'potroseno_planirano'       => new Field((new NumberValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)),
                'status'                    => new Field((new StringValidator())->setMaxLength(128)),
                'napomena'                  => new Field((new StringValidator())->setMaxLength(512)),
                'razlog_neizvrsenja'        => new Field((new StringValidator())->setMaxLength(512)),
                'administrator_id'          => new Field((new NumberValidator())->setIntegerLength(10))
            ];
        }

        public function innerJoinUgovor() {
            $sql = 'SELECT * FROM plan_javnih_nabavki INNER JOIN realizacija_ugovora ON plan_javnih_nabavki.plan_javnih_nabavki_id = realizacija_ugovora.plan_javnih_nabavki_id ';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute();
            $items = [];
            if ($res) {
                $items = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $items;
        }

    }