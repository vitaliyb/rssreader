<?php

namespace App\Services\News;


class Delfi extends Base
{

    protected function getURL(): string
    {
        return 'https://www.delfi.lv/rss/?channel=delfi';
    }

    protected function getLimit(): int
    {
        return 20;
    }
}
