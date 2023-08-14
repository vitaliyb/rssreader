<?php

namespace Tests\Feature\Services\News;

use Tests\TestCase;
use App\Services\News\Delfi;
use VCR\VCR;

class DelfiTest extends TestCase
{
    public function test_it_works(): void
    {
        VCR::configure()
            ->setStorage('json')
            ->setMode(VCR::MODE_ONCE)
            ->setCassettePath('tests/cassettes');

        VCR::turnOn();

        VCR::insertCassette('services/news/delfi/default.json');
        /**
         * @var $service Delfi
         */
        $service = app(Delfi::class);
        $news = $service->getNews();

        $this->assertEquals(1, $news->count());

        $article = $news->first();
        $this->assertEquals('https://test.com/image.jpg', $article->imageUrl);
        $this->assertEquals('14.08.2023 20:31', $article->postedAt);
        $this->assertEquals('https://www.test.com', $article->guid);
        $this->assertEquals('TestDescription', $article->description);
        $this->assertEquals('TestTitle', $article->title);
        $this->assertEquals('TestCategory', $article->category);
        $this->assertEquals('image/png', $article->imageType);

        VCR::turnOff();
    }
}
