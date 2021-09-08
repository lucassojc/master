<?php
    namespace App\Models;

    use App\Core\DatabaseConnection;
    use App\Core\Model;
    use App\Core\Field;
    use App\Validators\NumberValidator;
    use App\Validators\DateTimeValidator;
    use App\Validators\StringValidator;

    class RealizacijaSprovodjenjaNabavkeModel extends Model{
        protected function getFields(): array {
            return [
                'realizacija_sprovodjenja_nabavke_id'   => new Field((new NumberValidator())->setIntegerLength(10), false),
                'plan_javnih_nabavki_id'                => new Field((new NumberValidator())->setIntegerLength(10)),
                'broj'                                  => new Field((new StringValidator())->setMaxLength(128)),
                'zahtev_pokrenut_at'                                => new Field((new StringValidator())->setMaxLength(128)),    //date
                'odluka_donesena_at'                                => new Field((new StringValidator())->setMaxLength(128)),    //date
                'resenje_at'                               => new Field((new StringValidator())->setMaxLength(128)),    //date
                'izjava_at'                                => new Field((new StringValidator())->setMaxLength(128)),    //date
                'dokumentacija_direktor_at'                         => new Field((new StringValidator())->setMaxLength(128)),    //date
                'dokumentacija_ojn_at'                             => new Field((new StringValidator())->setMaxLength(128)),    //date
                'ponuda_otvorena_at'                      => new Field((new StringValidator())->setMaxLength(128)),    //date
                'administrator_id'                      => new Field((new NumberValidator())->setIntegerLength(10))
            ];
        }

        public function innerJoinRealizacija() {
            $sql = 'SELECT * FROM plan_javnih_nabavki INNER JOIN realizacija_sprovodjenja_nabavke ON plan_javnih_nabavki.plan_javnih_nabavki_id = realizacija_sprovodjenja_nabavke.plan_javnih_nabavki_id ';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $res = $prep->execute();
            $items = [];
            if ($res) {
                $items = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $items;
        }


    }