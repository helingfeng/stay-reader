<?php
/**
 * User: Chester
 */

namespace App\Crawler;


use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Downloader
{
    protected $client = null;
    protected $downloadPath = 'app/public/download';

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $url
     * @param $params
     * @return string
     */
    public function downloadTextFile($url = '', $params)
    {
        $fileName = storage_path($this->downloadPath) . '/' . $params['id'] . '.txt';

        if (!file_exists($fileName)) {
            $handle = fopen($url . '?' . http_build_query($params), 'r');
            $fh = fopen($fileName, 'w');

            while (!feof($handle)) {
                $output = fgets($handle);
                fwrite($fh, $this->encodeConvertToUtf8($output));
            }

            fclose($handle);
            fclose($fh);
        }
        return $fileName;
    }

    /**
     * @param string $data
     * @return null|string|string[]
     */
    protected function encodeConvertToUtf8($data = '')
    {
        $fileType = mb_detect_encoding($data, array('UTF-8', 'GBK', 'LATIN1', 'BIG5', 'GB2312'));
        if ($fileType != 'UTF-8') {
            $data = mb_convert_encoding($data, 'utf-8', $fileType);
        }
        return $data;
    }


    /**
     * @param string $url
     * @param int $book_id
     * @return null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function downloadBookSummary($url = '', $book_id = 0)
    {
        $response = $this->client->request('GET', $url . "0_{$book_id}");
        $summary = null;
        if ($response->getStatusCode() == '200') {
            $contents = $response->getBody()->getContents();
            $crawler = new Crawler($contents);
            $summary['book_id'] = $book_id;
            $summary['name'] = $crawler->filterXPath('//*[@id="info"]/h1')->text();
            $summary['author'] = $crawler->filterXPath('//*[@id="info"]/p[1]')->text();

            if (strpos($summary['author'], '：') !== false) {
                $summary['author'] = array_get(explode('：', $summary['author']), 1);
            }
            $summary['abstract'] = $crawler->filterXPath('//*[@id="intro"]/p')->text();
            $summary['abstract'] = trim($summary['abstract']);

            $summary['image'] = $crawler->filterXPath('//*[@id="fmimg"]/img')->attr('src');

            if ($summary['image']) {
                $summary['image'] = trim($url, '/') . '/' . trim($summary['image'], '/');
            }

            $summary['category'] = $crawler->filterXPath('//*[@class="con_top"]')->text();
            $arr = explode('>', $summary['category']);
            $summary['category'] = trim($arr[1]);

            $summary['modified_date'] = date('Y-m-d H:i:s');
            $summary['created_date'] = date('Y-m-d H:i:s');
        } else {
            abort('500', '图书概述下载失败');
        }
        return $summary;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function downALLNovelsIDs()
    {
        $bookArray = [];
        $response = $this->client->request('GET', 'https://www.booktxt.net/xiaoshuodaquan/');
        if ($response->getStatusCode() == '200') {
            $contents = $response->getBody()->getContents();
            $crawler = new Crawler($contents);
            $crawler->filterXPath('//*[@id="main"]/div/ul/li/a')->each(function (Crawler $node) use (&$bookArray) {
                $href = $node->attr('href');
                $arr = explode('_', $href);
                if (isset($arr[1]) && intval($arr[1])) {
                    array_push($bookArray, intval($arr[1]));
                }
            });
        }
        return $bookArray;
    }
}