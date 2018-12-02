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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function downloadTextFile($url = '', $params)
    {
        $response = $this->client->request('GET', $url . '?' . http_build_query($params));
        $fileName = storage_path($this->downloadPath) . '/' . date('YmdHis') . '.txt';
        if ($response->getStatusCode() == '200') {
            $contents = $response->getBody()->getContents();
            $data = $this->encodeConvertToUtf8($contents);
            file_put_contents($fileName, $data);
        } else {
            abort('500', '图书章节下载失败');
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
            $summary['image'] = $crawler->filterXPath('//*[@id="fmimg"]/img')->attr('src');

            if ($summary['image']) {
                $summary['image'] = trim($url, '/') . '/' . trim($summary['image'], '/');
            }

            $summary['modified_date'] = date('Y-m-d H:i:s');
            $summary['created_date'] = date('Y-m-d H:i:s');
        } else {
            abort('500', '图书概述下载失败');
        }
        return $summary;
    }
}