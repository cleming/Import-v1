<?php
declare(strict_types=1);

namespace ImportV1\Processors;

use ImportV1\Processor;
use Robert2\API\Models\Person;
use Robert2\API\Config;

class Beneficiaries extends Processor
{
    public $autoFieldsMap = [
        'id' => null,
        'label' => ['type' => 'string', 'field' => 'nickname'],
        'adresse' => ['type' => 'string', 'field' => 'street'],
        'codePostal' => ['type' => 'string', 'field' => 'postal_code'],
        'ville' => ['type' => 'string', 'field' => 'locality'],
        'email' => ['type' => 'string', 'field' => 'email'],
        'tel' => ['type' => 'string', 'field' => 'phone'],
        'poste' => null,
        'remarque' => null,
        'nomStruct' => null,
        'typeRetour' => null,

        // Added in _preProcess method
        'firstName' => ['type' => 'string', 'field' => 'first_name'],
        'lastName' => ['type' => 'string', 'field' => 'last_name'],
        'notes' => ['type' => 'string', 'field' => 'note'],
        'tags' => ['type' => 'array', 'field' => 'tags'],
    ];

    public function __construct()
    {
        $this->model = new Person;
    }

    // ------------------------------------------------------
    // -
    // -    Specific Methods
    // -
    // ------------------------------------------------------

    protected function _preProcess(array $data): array
    {
        return array_map(function ($item) {
            $itemFullName = explode(' ', $item['nomPrenom']);
            $item['firstName'] = $itemFullName[0];
            $item['lastName'] = $itemFullName[1];

            $extraData = [
                'nomStruct' => "Structure associée",
                'idStructure' => "Structure ID (Robert v1)",
                'poste' => "Poste dans la structure",
                'remarque' => "Remarques",
            ];
            $notes = [];
            foreach ($extraData as $field => $info) {
                $value = $item[$field];
                $emptyValues = [null, '', 'N/A', 'undefined'];
                if (!in_array($value, $emptyValues)) {
                    $notes[] = sprintf('%s : %s', $info, $value);
                }
            }
            $item['notes'] = implode("\n", $notes);

            $tagsConfig = Config\Config::getSettings('defaultTags');
            $item['tags'] = [$tagsConfig['beneficiary']];

            return $item;
        }, $data);
    }
}
