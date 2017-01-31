<?php
/**
 * Created by PhpStorm.
 * User: savchenko
 * Date: 31.01.17
 * Time: 21:40
 */

return [
    //npi
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

    //taxonomies
    'taxonomiesQuantity' => 15,     // Quantity of taxonomy group of fields
    'taxonomyCode_1' => 48,         // CSV Column Name: Healthcare Provider Taxonomy Code_1
    'taxonomyLicense_1' => 49,      // CSV Column Name: Provider License Number_1
    'taxonomyState_1' => 50,        // CSV Column Name: Provider License Number State Code_1
    'taxonomyPrimary_1' => 51,      // CSV Column Name: Healthcare Provider Primary Taxonomy Switch_1

    //identifiers
    'identifiersQuantity' => 50,    // Quantity of identifiers group of fields
    'identifierIdentifier_1' => 108,            // CSV Column Name: Other Provider Identifier_1
    'identifierCode_1' => 109,                  // CSV Column Name: Other Provider Identifier Type Code_1
    'identifierState_1' => 110,                 // CSV Column Name: Other Provider Identifier State_1
    'identifierIssuer_1' => 111,                // CSV Column Name: Other Provider Identifier Issuer_1

    //addresses
    ''
];