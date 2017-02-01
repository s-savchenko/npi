<?php
/**
 * Created by PhpStorm.
 * User: savchenko
 * Date: 31.01.17
 * Time: 21:28
 */

namespace app\models;

/**
 * Class CsvHandler
 * @package app\models
 * @property $number
 * @property $last_updated_epoch
 * @property $enumeration_type
 * @property $created_epoch
 * @property $status
 * @property $credential
 * @property $first_name
 * @property $last_name
 * @property $middle_name
 * @property $sole_proprietor
 * @property $gender
 * @property $last_updated
 * @property $name_prefix
 * @property $enumeration_date
 * @property $taxonomies
 * @property $identifiers
 * @property $addresses
 */
class CsvLine
{
    private $line, $map;

    /**
     * CsvHandler constructor.
     * @param string $line
     */
    public function __construct($line)
    {
        $line = str_replace("\n", '', $line);
        $line = explode('","', $line);
        $this->line = array_map(function ($val) {
            return trim($val, '"');
        }, $line);

        $this->map = require_once('CsvMapping.php');
    }

    public function __get($name)
    {
        if ($name == 'taxonomies')
            return $this->getTaxonomies();
        elseif ($name == 'identifiers')
            return $this->getIdentifiers();
        elseif ($name == 'addresses')
            return $this->getAddresses();
        elseif ($name == 'addresses')
            return $this->getNpi();

        $fieldNumber = $this->map[$name];
        if ($fieldNumber === false)
            return '';
        return $this->line[$fieldNumber];
    }

    protected function getNpi()
    {
        return [
            $this->number,
            $this->last_updated_epoch,
            $this->enumeration_type,
            $this->created_epoch,
            $this->status,
            $this->credential,
            $this->first_name,
            $this->last_name,
            $this->middle_name,
            $this->sole_proprietor,
            $this->gender,
            $this->last_updated,
            $this->name_prefix,
            $this->enumeration_date,
        ];
    }

    protected function getTaxonomies()
    {
        $taxonomies = [];
        for ($i = 0; $i < $this->map['taxonomiesQuantity']; $i++) {
            $code = trim($this->line[$this->map['taxonomyCode_1'] + $i * 4]);
            $license = trim($this->line[$this->map['taxonomyLicense_1'] + $i * 4]);
            $state = trim($this->line[$this->map['taxonomyState_1'] + $i * 4]);
            $primary = trim($this->line[$this->map['taxonomyPrimary_1'] + $i * 4]);
            if ($code != '' && $license != '' && $state != '' && $primary != '')
                $taxonomies[] = [
                    'code' => $code,
                    'license' => $license,
                    'state' => $state,
                    'primary' => $primary
                ];
        }
        return $taxonomies;
    }

    protected function getIdentifiers()
    {
        $identifiers = [];
        for ($i = 0; $i < $this->map['identifiersQuantity']; $i++) {
            $identifier = trim($this->line[$this->map['identifierIdentifier_1'] + $i * 4]);
            $code = trim($this->line[$this->map['identifierCode_1'] + $i * 4]);
            $state = trim($this->line[$this->map['identifierState_1'] + $i * 4]);
            $issuer = trim($this->line[$this->map['identifierIssuer_1'] + $i * 4]);
            if ($identifier != '' && $code != '' && $state != '' && $issuer != '')
                $identifiers[] = [
                    'identifier' => $identifier,
                    'code' => $code,
                    'state' => $state,
                    'issuer' => $issuer
                ];
        }
        return $identifiers;
    }

    protected function getAddresses()
    {
        return [
            [
                'city' => $this->line[$this->map['mailing_city']],
                'address_2' => $this->line[$this->map['mailing_address_2']],
                'telephone_number' => $this->line[$this->map['mailing_telephone_number']],
                'fax_number' => $this->line[$this->map['mailing_fax_number']],
                'state' => $this->line[$this->map['mailing_state']],
                'postal_code' => $this->line[$this->map['mailing_postal_code']],
                'address_1' => $this->line[$this->map['mailing_address_1']],
                'country_code' => $this->line[$this->map['mailing_country_code']],
                'purpose' => 'mailing'
            ],
            [
                'city' => $this->line[$this->map['location_city']],
                'address_2' => $this->line[$this->map['location_address_2']],
                'telephone_number' => $this->line[$this->map['location_telephone_number']],
                'fax_number' => $this->line[$this->map['location_fax_number']],
                'state' => $this->line[$this->map['location_state']],
                'postal_code' => $this->line[$this->map['location_postal_code']],
                'address_1' => $this->line[$this->map['location_address_1']],
                'country_code' => $this->line[$this->map['location_country_code']],
                'purpose' => 'location'
            ],
        ];
    }
}