<?php
/**
 * Created by PhpStorm.
 * User: savchenko
 * Date: 31.01.17
 * Time: 21:40
 */

return [
    //npi table
    'number' => 0,                  //CSV Column Name: npi,
    'last_updated_epoch' => 1,      //CSV Column Name:
    'enumeration_type' => 1,        //CSV Column Name:
    'created_epoch' => 1,           //CSV Column Name:
    'status' => 1,                  //CSV Column Name:
    'credential' => 1,              //CSV Column Name: Provider Credential Text
    'first_name' => 1,              //CSV Column Name: Provider First Name
    'last_name' => 1,               //CSV Column Name: Provider Last Name (Legal Name)
    'middle_name' => 1,             //CSV Column Name: Provider Middle Name
    'sole_proprietor' => 1,         //CSV Column Name: Is Sole Proprietor
    'gender' => 1,                  //CSV Column Name: Provider Gender Code
    'last_updated' => 1,            //CSV Column Name: Last Update Date
    'name_prefix' => 1,             //CSV Column Name Provider Name Prefix Text
    'enumeration_date' => 1,        //CSV Column Name: Provider Enumeration Date

    //taxonomies table
    'taxonomiesQuantity' => 15,
    'taxonomyCode_1' => 48,
    'taxonomyLicense_1' => 49,
    'taxonomyState_1' => 50,
    'taxonomyPrimary_1' => 51,
];