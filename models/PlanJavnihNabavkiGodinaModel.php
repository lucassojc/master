<?php
    namespace App\Models;

    use App\Core\DatabaseConnection;
    use App\Core\Model;
    use App\Core\Field;
    use App\Validators\NumberValidator;
    use App\Validators\DateTimeValidator;
    use App\Validators\StringValidator;

    class PlanJavnihNabavkiGodinaModel extends Model{
        protected function getFields(): array {
            return [
                'plan_javnih_nabavki_id'    => new Field((new NumberValidator())->setIntegerLength(10)),
                'godina_2019'               => new Field((new StringValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)),
                'godina_2020'               => new Field((new StringValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2)),
                'godina_2021'               => new Field((new StringValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2))
            ];
        }
    }