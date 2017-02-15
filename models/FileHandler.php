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
    public static function getDownloadLink($url, $xPath, $fileIndex)
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
        $link = $domXPath->query($xPath)[$fileIndex]->getAttribute('href');
        $caption = $domXPath->query($xPath)[$fileIndex]->nodeValue;
        $page = explode('/', $url);
        $page = array_slice($page, 0, count($page) - 1);
        $link = implode('/', $page) . '/' . $link;
        return [
            'link' => $link,
            'caption' => $caption
        ];
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
        $zip = new \ZipArchive();
        if ($zip->open($srcFile) === true) {
            $splitter = ($createZipNameDir === true) ? "." : "/";
            if ($destDir === false)
                $destDir = substr($srcFile, 0, strrpos($srcFile, $splitter)) . "/";
            self::createDir($destDir);
            $zip->extractTo($destDir);
            $zip->close();
            return true;
        }
        return false;
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