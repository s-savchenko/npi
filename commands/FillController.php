<?php

namespace app\commands;

use app\models\CsvLine;
use yii\console\Controller;
use Yii;

class FillController extends Controller
{
    protected function getNpiFields()
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

    protected function getAddressesFields()
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

    protected function getTaxonomiesFields()
    {
        return [
            'code', 'license', 'state', 'primary', 'number'
        ];
    }

    protected function getIdentifiersFields()
    {
        return [
            'identifier', 'code', 'state', 'issuer', 'number'
        ];
    }

    protected function getOtherNamesFields()
    {
        return [
            'organization_name', 'code', 'number'
        ];
    }

    public function actionIndex()
    {
        echo date('c').PHP_EOL;
        Yii::$app->db->createCommand('delete from npi')->execute();
        Yii::$app->db->createCommand('delete from addresses')->execute();
        Yii::$app->db->createCommand('delete from taxonomies')->execute();
        Yii::$app->db->createCommand('delete from identifiers')->execute();
        Yii::$app->db->createCommand('delete from other_names')->execute();

        $file = dirname(__DIR__) . '/web/full.csv';
//        $file = dirname(__DIR__) . '/web/weekly.csv';
        $fp = fopen($file, "r");
        fgets($fp);// Skip headers

        $npi = [];
        $addresses = [];
        $taxonomies = [];
        $identifiers = [];
        $otherNames = [];
        $i = 0;
        $y = 0;
        $csvLine = new CsvLine();
        while (false !== ($line = fgets($fp))) {
            $csvLine->handle($line);
            $npi[] = $csvLine->npi;
            $addresses = array_merge($addresses, $csvLine->addresses);
            $taxonomies = array_merge($taxonomies, $csvLine->taxonomies);
            $identifiers = array_merge($identifiers, $csvLine->identifiers);
            $otherNames = array_merge($otherNames, $csvLine->other_names);
            $i++;
            $y++;
            if ($i == 10000) {
                Yii::$app->db->createCommand()
                    ->batchInsert('npi', $this->npiFields, $npi)->execute();
                Yii::$app->db->createCommand()
                    ->batchInsert('addresses', $this->addressesFields, $addresses)->execute();
                Yii::$app->db->createCommand()
                    ->batchInsert('taxonomies', $this->taxonomiesFields, $taxonomies)->execute();
                Yii::$app->db->createCommand()
                    ->batchInsert('identifiers', $this->identifiersFields, $identifiers)->execute();
                Yii::$app->db->createCommand()
                    ->batchInsert('other_names', $this->otherNamesFields, $otherNames)->execute();
                $npi = [];
                $addresses = [];
                $taxonomies = [];
                $identifiers = [];
                $otherNames = [];
                $i = 0;
            }
            if ($y == 10000) {
                break;
            }

        }

        fclose($fp);
        echo date('c').PHP_EOL;
    }
}