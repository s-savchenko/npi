<?php
/**
 * Created by PhpStorm.
 * User: savchenko
 * Date: 05.02.17
 * Time: 15:03
 */

namespace app\models;


class CsvDbMapping
{
    public static function getNpiFields()
    {
        return [
            'number',
            'last_updated_epoch',
            'enumeration_type',
            'created_epoch',
            'status',
            'credential',
            'first_name',
            'last_name',
            'middle_name',
            'sole_proprietor',
            'gender',
            'last_updated',
            'name_prefix',
            'enumeration_date',
        ];
    }

    public static function getAddressesFields()
    {
        return [
            'city',
            'address_2',
            'telephone_number',
            'fax_number',
            'state',
            'postal_code',
            'address_1',
            'country_code',
            'purpose',
            'number',
        ];
    }

    public static function getTaxonomiesFields()
    {
        return [
            'code', 'license', 'state', 'primary', 'number'
        ];
    }

    public static function getIdentifiersFields()
    {
        return [
            'identifier', 'code', 'state', 'issuer', 'number'
        ];
    }

    public static function getOtherNamesFields()
    {
        return [
            'organization_name', 'code', 'number'
        ];
    }
}