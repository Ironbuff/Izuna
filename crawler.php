<?php

class PyPICrawler
{
    private $baseUrl = 'https://pypi.org';

    public function crawlPackages($keyword, $pages = 3)
    {
        $packages = [];

        for ($page = 1; $page <= $pages; $page++) {
            $url = "{$this->baseUrl}/search/?q={$keyword}&o=-last_updated&page={$page}";
            $html = $this->fetchUrl($url);

            preg_match_all('/<a class="package-snippet" href="(.*?)">/s', $html, $matches);

            foreach ($matches[1] as $packageUrl) {
                $packageDetails = $this->crawlPackageDetails($this->baseUrl . $packageUrl);
                $packages[] = $packageDetails;
            }
        }

        return $packages;
    }

    private function crawlPackageDetails($url)
    {
        $html = $this->fetchUrl($url);

        preg_match('/<h1 class="package-header__name">(.*?)<\/h1>/s', $html, $nameMatch);
        preg_match('/<p class="package-header__pip-instructions">(.*?)<\/p>/s', $html, $installMatch);
        preg_match('/<p class="package-header__date">(.*?)<\/p>/s', $html, $dateMatch);
        preg_match('/<p class="package-description__summary">(.*?)<\/p>/s', $html, $descMatch);
        preg_match('/<meta name="author" content="(.*?)">/s', $html, $authorMatch);
        preg_match_all('/<a href="\/user\/.*?">(.*?)<\/a>/s', $html, $maintainerMatches);

        return [
            'Package Name' => trim(strip_tags($nameMatch[1] ?? '')),
            'Installation Instruction' => trim(strip_tags($installMatch[1] ?? '')),
            'Released Date' => trim(strip_tags($dateMatch[1] ?? '')),
            'Short Description' => trim(strip_tags($descMatch[1] ?? '')),
            'Author' => trim($authorMatch[1] ?? ''),
            'Maintainer' => implode(' | ', $maintainerMatches[1] ?? [])
        ];
    }

    private function fetchUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }

    public function saveToCsv($data, $filename)
    {
        $fp = fopen($filename, 'w');
        
        // Write headers
        fputcsv($fp, array_keys($data[0]));
        
        // Write data
        foreach ($data as $row) {
            fputcsv($fp, $row);
        }
        
        fclose($fp);
    }
}

// Usage
$crawler = new PyPICrawler();
$packages = $crawler->crawlPackages('date', 3);
$crawler->saveToCsv($packages, 'pypi_packages.csv');

echo "Crawling completed. Data saved to pypi_packages.csv";

?>