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

        $this->map = require_once('CsvDbMapping.php');
    }

    public function __get($name)
    {
        if ($name == 'taxonomies')
            return $this->getTaxonomies();

        $fieldNumber = $this->map[$name];
        return $this->line[$fieldNumber];
    }

    public function getTaxonomies()
    {
        $taxonomies = [];
        for ($i = 0; $i < $this->map['taxonomiesQuantity']; $i++) {
            $taxonomies[] = [
                $this->line[$this->map['taxonomyCode_1'] + $i],
                $this->line[$this->map['taxonomyLicense_1'] + $i],
                $this->line[$this->map['taxonomyState_1'] + $i],
                $this->line[$this->map['taxonomyPrimary_1'] + $i],
            ];
        }
        return $taxonomies;
    }
}