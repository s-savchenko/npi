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
        $this->processing();
    }

    public function actionUpdate()
    {
        $this->processing(false);
    }

    public function processing($monthly = true)
    {
        $period = $monthly ? 'monthly' : 'weekly';

        if ($monthly) {
            echo 'Deleting of data from DB...' . PHP_EOL;
            Yii::$app->db->createCommand('delete from npi')->execute();
            Yii::$app->db->createCommand('delete from addresses')->execute();
            Yii::$app->db->createCommand('delete from taxonomies')->execute();
            Yii::$app->db->createCommand('delete from identifiers')->execute();
            Yii::$app->db->createCommand('delete from other_names')->execute();
        }

        printf('Downloading of %s file...%s', $period, PHP_EOL);
        $fileIndex = $monthly ? 'monthlyFileIndex' : 'weeklyFileIndex';
        $fileIndex = Yii::$app->params[$fileIndex];
        $link = FileHandler::getDownloadLink(
            Yii::$app->params['npiFilesDownloadPage'], Yii::$app->params['linkXPath'], $fileIndex);
        printf('File: %s (%s)%s', $link['caption'], $link['link'], PHP_EOL);
        $link = $link['link'];
        $zip = Yii::getAlias('@runtime') . '/' . $period . '.zip';
        FileHandler::download($link, $zip);

        printf('Unzipping of %s file...', $period, PHP_EOL);
        FileHandler::unzip($zip);

        $zip = rtrim($zip, '.zip');
        $files = glob($zip . '/*.csv');
        $fileName = '';
        foreach ($files as $file) {
            if (strpos($file, 'FileHeader') === false) {
                $fileName = $file;
                break;
            }
        }

        printf('Start of DB %s: %s%s', $monthly ? 'populating' : 'updating', date('c'), PHP_EOL);
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
                if (!$monthly) {
                    $npiIds = array_map(function ($npiRow) {
                        return $npiRow[0];
                    }, $npi);
                    $npiIds = '(' . implode(',', $npiIds) . ')';
                    Yii::$app->db->createCommand('delete from npi where number in ' . $npiIds)->execute();
                }
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
        printf('End of DB %s: %s%s', $monthly ? 'populating' : 'updating', date('c'), PHP_EOL);

        echo 'Deleting of temporary files...' . PHP_EOL;
        unlink(Yii::getAlias('@runtime') . '/' . $period . '.zip');
        FileHandler::deleteDir(Yii::getAlias('@runtime') . '/' . $period);
    }
}