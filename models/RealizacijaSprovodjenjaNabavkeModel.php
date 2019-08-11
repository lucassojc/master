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
                'zahtev'                                => new Field((new StringValidator())->setMaxLength(128)),    //date
                'odluka'                                => new Field((new StringValidator())->setMaxLength(128)),    //date
                'resenje'                               => new Field((new StringValidator())->setMaxLength(128)),    //date
                'izjava'                                => new Field((new StringValidator())->setMaxLength(128)),    //date
                'datum_direktor'                        => new Field((new StringValidator())->setMaxLength(128)),    //date
                'datum_ojn'                             => new Field((new StringValidator())->setMaxLength(128)),    //date
                'otvaranje_ponuda'                      => new Field((new StringValidator())->setMaxLength(128)),    //date
                'administrator_id'                      => new Field((new NumberValidator())->setIntegerLength(10))
            ];
        }
    }