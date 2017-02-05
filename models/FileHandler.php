<?php
/**
 * Created by PhpStorm.
 * User: savchenko
 * Date: 01.02.17
 * Time: 22:15
 */

namespace app\models;

use DOMDocument;
use DOMXPath;

class FileHandler
{
    public static function getDownloadLink($url, $xPath)
    {
        libxml_use_internal_errors(true);
        $opts = [
            'http' =>
                [
                    'header' => "User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36\r\n"
                ]
        ];
        $context = stream_context_create($opts);
        $html = file_get_contents($url, false, $context);
        $dom = new DomDocument();
        $dom->loadHTML($html);
        $domXPath = new DomXPath($dom);
        $link = $domXPath->query($xPath)[0]->getAttribute('href');

        $page = explode('/', $url);
        $page = array_slice($page, 0, count($page) - 1);
        return implode('/', $page) . '/' . $link;
    }

    public static function download($url, $path)
    {
        $newFileName = $path;
        $file = fopen($url, 'rb');
        if ($file) {
            $newFile = fopen($newFileName, 'wb');
            if ($newFile) {
                while(!feof($file)) {
                    fwrite($newFile, fread($file, 1024 * 8), 1024 * 8);
                }
            }
        }
        if ($file) {
            fclose($file);
        }
        if ($newFile) {
            fclose($newFile);
        }
    }

    public static function unzip($srcFile, $destDir = false, $createZipNameDir = true, $overwrite = true)
    {
        if ($zip = zip_open($srcFile))
        {
            if ($zip)
            {
                $splitter = ($createZipNameDir === true) ? "." : "/";
                if ($destDir === false)
                    $destDir = substr($srcFile, 0, strrpos($srcFile, $splitter)) . "/";

                self::createDir($destDir);

                while ($zipEntry = zip_read($zip))
                {
                    $posLastSlash = strrpos(zip_entry_name($zipEntry), "/");
                    if ($posLastSlash !== false)
                        self::createDir($destDir.substr(zip_entry_name($zipEntry), 0, $posLastSlash+1));

                    if (zip_entry_open($zip, $zipEntry, "r"))
                    {
                        $fileName = $destDir . zip_entry_name($zipEntry);
                        if ($overwrite === true || $overwrite === false && !is_file($fileName))
                        {
                            $fstream = zip_entry_read($zipEntry, zip_entry_filesize($zipEntry));
                            file_put_contents($fileName, $fstream);
                            chmod($fileName, 0777);
                        }
                        zip_entry_close($zipEntry);
                    }
                }
                zip_close($zip);
            }
        }
        else
        {
            return false;
        }

        return true;
    }

    private static function createDir($path)
    {
        if (!is_dir($path))
        {
            $directoryPath = '';
            $directories = explode('/', $path);
            array_pop($directories);
            foreach($directories as $directory)
            {
                $directoryPath .= $directory . '/';
                if (!is_dir($directoryPath))
                {
                    mkdir($directoryPath);
                    chmod($directoryPath, 0777);
                }
            }
        }
    }

    public static function deleteDir($target)
    {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK );
            foreach( $files as $file )
                self::deleteDir($file);
            rmdir($target);
        } elseif(is_file($target)) {
            unlink($target);
        }
    }
}