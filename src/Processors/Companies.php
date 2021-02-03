<?php
declare(strict_types=1);

namespace ImportV1\Processors;

use ImportV1\Processor;
use Robert2\API\Models\Company;
use Robert2\API\Config;

class Companies extends Processor
{
    public $autoFieldsMap = [
        'id' => null,
        'label' => null,
        'SIRET' => null,
        'type' => null,
        'NomRS' => ['type' => 'string', 'field' => 'legal_name'],
        'interlocteurs' => null,
        'adresse' => ['type' => 'string', 'field' => 'street'],
        'codePostal' => ['type' => 'string', 'field' => 'postal_code'],
        'ville' => ['type' => 'string', 'field' => 'locality'],
        'email' => ['type' => 'string', 'field' => 'email'],
        'tel' => ['type' => 'string', 'field' => 'phone'],
        'listePlans' => null,
        'decla' => null,
        'remarque' => null,

        // Added in _preProcess method
        'notes' => ['type' => 'string', 'field' => 'note'],
        'persons' => ['type' => 'array', 'field' => 'persons'],
        'tags' => ['type' => 'array', 'field' => 'tags'],
    ];

    public function __construct()
    {
        $this->model = new Company;
    }

    // ------------------------------------------------------
    // -
    // -    Specific Methods
    // -
    // ------------------------------------------------------

    protected function _preProcess(array $data): array
    {
        return array_map(function ($item) {
            $extraData = [
                'SIRET' => "N° SIRET",
                'type' => "Type",
                'label' => "Label",
                'interlocteurs' => "Interlocuteurs (ID bénéficiaires Robert v1)",
                'decla' => "Déclaration",
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

            $person = [
                'first_name' => '--',
                'last_name' => $item['interlocteurs'] ? explode(',', $item['interlocteurs'])[0] : '--',
            ];
            $item['persons'] = [$person];

            return $item;
        }, $data);
    }
}
