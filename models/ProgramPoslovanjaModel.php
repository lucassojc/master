<?php
    namespace App\Models;

    use App\Core\DatabaseConnection;
    use App\Core\Model;
    use App\Core\Field;
    use App\Validators\NumberValidator;
    use App\Validators\StringValidator;

    class ProgramPoslovanjaModel extends Model{
        protected function getFields(): array {
            return [
                'program_poslovanja_id'     => new Field((new NumberValidator())->setIntegerLength(10), false),
                'aproprijacija'             => new Field((new StringValidator())->setMaxLength(128)),
                'opis'                      => new Field((new StringValidator())->setMaxLength(128)),
                'iznos'                     => new Field((new NumberValidator())->setDecimal()
                                                                                ->setUnsigned()
                                                                                ->setIntegerLength(10)
                                                                                ->setMaxDecimalDigits(2))
            ];
        }
    }