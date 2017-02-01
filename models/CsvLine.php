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
 * @property $npi
 * @property $mailing_city
 * @property $mailing_address_2
 * @property $mailing_telephone_number
 * @property $mailing_fax_number
 * @property $mailing_state
 * @property $mailing_postal_code
 * @property $mailing_address_1
 * @property $mailing_country_code
 * @property $location_city
 * @property $location_address_2
 * @property $location_telephone_number
 * @property $location_fax_number
 * @property $location_state
 * @property $location_postal_code
 * @property $location_address_1
 * @property $location_country_code
 * @property
 */
class CsvLine
{
    private $line, $map;

    public function __construct()
    {
        $this->map = require_once('CsvMapping.php');
    }

    public function handle($line)
    {
        $line = str_replace("\n", '', $line);
        $line = explode('","', $line);
        $this->line = array_map(function ($val) {
            return trim($val, '"');
        }, $line);
    }

    public function __get($name)
    {
        if ($name == 'taxonomies')
            return $this->getTaxonomies();
        elseif ($name == 'identifiers')
            return $this->getIdentifiers();
        elseif ($name == 'addresses')
            return $this->getAddresses();
        elseif ($name == 'npi')
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
            $code = $this->line[$this->map['taxonomyCode_1'] + $i * 4];
            $license = $this->line[$this->map['taxonomyLicense_1'] + $i * 4];
            $state = $this->line[$this->map['taxonomyState_1'] + $i * 4];
            $primary = $this->line[$this->map['taxonomyPrimary_1'] + $i * 4];
            if ($code != '' && $license != '' && $state != '' && $primary != '')
                $taxonomies[] = [$code, $license, $state, $primary, $this->number];
        }
        return $taxonomies;
    }

    protected function getIdentifiers()
    {
        $identifiers = [];
        for ($i = 0; $i < $this->map['identifiersQuantity']; $i++) {
            $identifier = $this->line[$this->map['identifierIdentifier_1'] + $i * 4];
            $code = $this->line[$this->map['identifierCode_1'] + $i * 4];
            $state = $this->line[$this->map['identifierState_1'] + $i * 4];
            $issuer = $this->line[$this->map['identifierIssuer_1'] + $i * 4];
            if ($identifier != '' && $code != '' && $state != '' && $issuer != '')
                $identifiers[] = [$identifier, $code, $state, $issuer, $this->number];
        }
        return $identifiers;
    }

    protected function getAddresses()
    {
        return [
            [
                $this->mailing_city,
                $this->mailing_address_2,
                $this->mailing_telephone_number,
                $this->mailing_fax_number,
                $this->mailing_state,
                $this->mailing_postal_code,
                $this->mailing_address_1,
                $this->mailing_country_code,
                'mailing',
                $this->number
            ],
            [
                $this->location_city,
                $this->location_address_2,
                $this->location_telephone_number,
                $this->location_fax_number,
                $this->location_state,
                $this->location_postal_code,
                $this->location_address_1,
                $this->location_country_code,
                'location',
                $this->number
            ],
        ];
    }
}