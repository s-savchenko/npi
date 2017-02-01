<?php
/**
 * Created by PhpStorm.
 * User: savchenko
 * Date: 31.01.17
 * Time: 21:40
 */

return [
    //npi
    'number' => 0,                      //CSV Column Name: npi,
    'last_updated_epoch' => false,      //CSV Column Name:
    'enumeration_type' => false,        //CSV Column Name:
    'created_epoch' => false,           //CSV Column Name:
    'status' => false,                  //CSV Column Name:
    'credential' => 10,                 //CSV Column Name: Provider Credential Text
    'first_name' => 6,                  //CSV Column Name: Provider First Name
    'last_name' => 5,                   //CSV Column Name: Provider Last Name (Legal Name)
    'middle_name' => 7,                 //CSV Column Name: Provider Middle Name
    'sole_proprietor' => 307,           //CSV Column Name: Is Sole Proprietor
    'gender' => 41,                     //CSV Column Name: Provider Gender Code
    'last_updated' => 37,               //CSV Column Name: Last Update Date
    'name_prefix' => 8,                 //CSV Column Name Provider Name Prefix Text
    'enumeration_date' => 36,           //CSV Column Name: Provider Enumeration Date

    //taxonomies
    'taxonomiesQuantity' => 15,         // Quantity of taxonomy group of fields
    'taxonomyCode_1' => 47,             // CSV Column Name: Healthcare Provider Taxonomy Code_1
    'taxonomyLicense_1' => 48,          // CSV Column Name: Provider License Number_1
    'taxonomyState_1' => 49,            // CSV Column Name: Provider License Number State Code_1
    'taxonomyPrimary_1' => 50,          // CSV Column Name: Healthcare Provider Primary Taxonomy Switch_1

    //identifiers
    'identifiersQuantity' => 50,        // Quantity of identifiers group of fields
    'identifierIdentifier_1' => 107,    // CSV Column Name: Other Provider Identifier_1
    'identifierCode_1' => 108,          // CSV Column Name: Other Provider Identifier Type Code_1
    'identifierState_1' => 109,         // CSV Column Name: Other Provider Identifier State_1
    'identifierIssuer_1' => 110,        // CSV Column Name: Other Provider Identifier Issuer_1

    //addresses
    'mailing_city' => 22,               // CSV Column Name: Provider Business Mailing Address City Name
    'mailing_address_2' => 21,          // CSV Column Name: Provider Second Line Business Mailing Address
    'mailing_telephone_number' => 26,   // CSV Column Name: Provider Business Mailing Address Telephone Number
    'mailing_fax_number' => 27,         // CSV Column Name: Provider Business Mailing Address Fax Number
    'mailing_state' => 23,              // CSV Column Name: Provider Business Mailing Address State Name
    'mailing_postal_code' => 24,        // CSV Column Name: Provider Business Mailing Address Postal Code
    'mailing_address_1' => 20,          // CSV Column Name: Provider First Line Business Mailing Address
    'mailing_country_code' => 25,       // CSV Column Name: Provider Business Mailing Address Country Code (If outside U.S.)

    'location_city' => 30,               // CSV Column Name: Provider Business Location Address City Name
    'location_address_2' => 29,          // CSV Column Name: Provider Second Line Business Location Address
    'location_telephone_number' => 34,   // CSV Column Name: Provider Business Location Address Telephone Number
    'location_fax_number' => 35,         // CSV Column Name: Provider Business Location Address Fax Number
    'location_state' => 31,              // CSV Column Name: Provider Business Location Address State Name
    'location_postal_code' => 32,        // CSV Column Name: Provider Business Location Address Postal Code
    'location_address_1' => 28,          // CSV Column Name: Provider First Line Business Location Address
    'location_country_code' => 33,       // CSV Column Name: Provider Business Location Address Country Code (If outside U.S.)

    //other_names
    'organization_name' => 11,           // CSV Column Name: Provider Other Organization Name
    'code' => 12                         // CSV Column Name: Provider Other Organization Name Type Code
];