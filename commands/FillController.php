<?php

namespace app\commands;

use app\models\CsvDbMapping;
use app\models\CsvLine;
use app\models\FileHandler;
use yii\console\Controller;
use Yii;

class FillController extends Controller
{
    public function actionPopulate()
    {
        echo 'Downloading monthly file...' . PHP_EOL;
        $link = FileHandler::getDownloadLink(
            Yii::$app->params['npiFilesDownloadPage'], Yii::$app->params['monthlyFileXPath']);
        $zip = Yii::getAlias('@runtime') . '/monthly.zip';
        FileHandler::download($link, $zip);

        echo 'Unzipping monthly file...' . PHP_EOL;
        FileHandler::unzip($zip);

        $zip = rtrim($zip, '.zip');
        $files = glob($zip . '*.csv');
        $fileName = '';
        foreach ($files as $file) {
            if (strpos($file, 'FileHeader') === false) {
                $fileName = $file;
                break;
            }
        }

        echo 'Start of populating DB: ' . date('c') . PHP_EOL;
        $fp = fopen($fileName, "r");
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
            if ($y == 100000) {
                break;
            }

        }

        fclose($fp);
        echo 'End of populating DB: ' . date('c') . PHP_EOL;

        echo 'Deleting files' . PHP_EOL;
        unlink(Yii::getAlias('@runtime') . '/monthly.zip');
        FileHandler::deleteDir(Yii::getAlias('@runtime') . '/monthly');
    }

    public function actionClearDb()
    {
        Yii::$app->db->createCommand('delete from npi')->execute();
        Yii::$app->db->createCommand('delete from addresses')->execute();
        Yii::$app->db->createCommand('delete from taxonomies')->execute();
        Yii::$app->db->createCommand('delete from identifiers')->execute();
        Yii::$app->db->createCommand('delete from other_names')->execute();
    }
}