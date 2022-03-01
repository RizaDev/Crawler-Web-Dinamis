<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Datama;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;

class CrawlWeb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:url {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl Website using Panther Symfony';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = $this->argument('url');

        $_SERVER['PANTHER_NO_HEADLESS'] = false;
        $_SERVER['PANTHER_NO_SANDBOX'] = true;

        try {
            $client = Client::createChromeClient(base_path("drivers/chromedriver"), null, ["port" => 9558]);

            $this->info("Start processing");

            $client->request('GET', $url);

            $crawler = $client->waitFor('#grid');
            $crawler = $client->waitForVisibility('#grid');
            
            
            $crawler->filter('#grid > div.list')->each(function (Crawler $parentCrawler, $i) {
                // DO THIS: specify the parent tag too
                $titleCrawler = $parentCrawler->filter('#grid > div.list > div.content > h1');
                $dateCrawler = $parentCrawler->filter('#grid > div.list > div.content > p');
                $imageCrawler = $parentCrawler->filter('#grid > div.list > div.thumb > img');
                $urlCrawler = $parentCrawler->filter('#grid > div.list > div.content > h1 > a');
                
                
               

                $news = new Datama();
                $news->title = $titleCrawler->getText() ?? "";
                $news->published_at = $dateCrawler->getText() ?? "";
                $news->image_url = $imageCrawler->getAttribute("src") ?? "";
                $news->news_url = $urlCrawler->getAttribute("href") ?? "";

                //check news update
                $duplicat = Datama::where('title', $news->title)->first();
                // var_dump($duplicat);
                if(!$duplicat){
                    $news->save();
                    $this->info("Item retrieved and saved");
                }else{
                    $this->info("Item retrieved but not saved");
                }   

            });

            $client->quit();

        } catch (\Exception $ex) {
            $this->error("Error: " . $ex->getMessage());
            dd($ex->getMessage());
        } finally {
            $this->info("Finished processing");
            $client->quit();
        }
    }
}
