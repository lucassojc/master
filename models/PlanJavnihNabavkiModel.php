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
                'aproprijacija_fk'          => new Field((new StringValidator())->setMaxLength(128)),
                'odeljenje'                 => new Field((new StringValidator())->setMaxLength(128)), //mozda enum
                'vrsta_predmeta'            => new Field((new StringValidator())->setMaxLength(128)), //enum
                'vrsta_postupka'            => new Field((new StringValidator())->setMaxLength(128)), //enum
                'opis'                      => new Field((new StringValidator())->setMaxLength(128)),
                'iznos_sa_pdv'              => new Field((new NumberValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)),
                'iznos_bez_pdv'             => new Field((new NumberValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)),
                '2019'                      => new Field((new NumberValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)),
                '2020'                      => new Field((new NumberValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)),
                '2021'                      => new Field((new NumberValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)),
                'pokretanje_postupka'       => new Field((new StringValidator())->setMaxLength(128)),    //date
                'zakljucenje_ugovora'       => new Field((new StringValidator())->setMaxLength(128)),    //date
                'izvrsenje_ugovora'         => new Field((new StringValidator())->setMaxLength(128)),    //date
                'napomena'                  => new Field((new StringValidator())->setMaxLength(128)),
                'razlog'                    => new Field((new StringValidator())->setMaxLength(128)),
                'kontrolni_iznos'           => new Field((new StringValidator())->setMaxLength(128)),
                'administrator_id'          => new Field((new NumberValidator())->setIntegerLength(10))
            ];
        }
    }