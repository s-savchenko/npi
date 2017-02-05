<?php

namespace app\commands;

use app\models\CsvDbMapping;
use app\models\CsvLine;
use yii\console\Controller;
use Yii;

class FillController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->db->createCommand('delete from npi')->execute();
        Yii::$app->db->createCommand('delete from addresses')->execute();
        Yii::$app->db->createCommand('delete from taxonomies')->execute();
        Yii::$app->db->createCommand('delete from identifiers')->execute();
        Yii::$app->db->createCommand('delete from other_names')->execute();

        echo date('c').PHP_EOL;
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
//        $y = 0;
        $csvLine = new CsvLine();
        while (false !== ($line = fgets($fp))) {
            $csvLine->handle($line);
            $npi[] = $csvLine->npi;
            $addresses = array_merge($addresses, $csvLine->addresses);
            $taxonomies = array_merge($taxonomies, $csvLine->taxonomies);
            $identifiers = array_merge($identifiers, $csvLine->identifiers);
            $otherNames = array_merge($otherNames, $csvLine->other_names);
            $i++;
//            $y++;
            if ($i == 10000) {
                Yii::$app->db->createCommand()
                    ->batchInsert('npi', CsvDbMapping::getNpiFields(), $npi)->execute();
                Yii::$app->db->createCommand()
                    ->batchInsert('addresses', CsvDbMapping::getAddressesFields(), $addresses)->execute();
                Yii::$app->db->createCommand()
                    ->batchInsert('taxonomies', CsvDbMapping::getTaxonomiesFields(), $taxonomies)->execute();
                Yii::$app->db->createCommand()
                    ->batchInsert('identifiers', CsvDbMapping::getIdentifiersFields(), $identifiers)->execute();
                Yii::$app->db->createCommand()
                    ->batchInsert('other_names', CsvDbMapping::getOtherNamesFields(), $otherNames)->execute();
                $npi = [];
                $addresses = [];
                $taxonomies = [];
                $identifiers = [];
                $otherNames = [];
                $i = 0;
            }
//            if ($y == 100000) {
//                break;
//            }

        }

        fclose($fp);
        echo date('c').PHP_EOL;
    }
}