<?php

namespace App\Models\Virtual;


use Carbon\Carbon;
use SimpleXMLElement;

class News
{

    public string $title;
    public string $category;
    public string $guid;
    public string $description;
    public string $postedAt;
    public string $imageUrl;
    public string $imageType;

    public function __construct(SimpleXMLElement $xml)
    {
        $this->title = (string)$xml->title;
        $this->category = (string)$xml->category;
        $this->guid = (string)$xml->guid;
        $this->description = htmlspecialchars_decode((string)$xml->description);
        $this->postedAt = Carbon::parse($xml->pubDate)->format('d.m.Y H:i');
        $this->imageUrl = (string)$xml->enclosure['url'];
        $this->imageType = (string)$xml->enclosure['type'];
    }
}
