<?php

namespace mavoc\core;

use HTMLPurifier_Config;
use HTMLPurifier;

use DateTime;
use DateTimeZone;

// Use it by calling:
// $rss = new RSS('https://example.com/rss');
// echo $rss->title;
// echo $rss->link;
// foreach($rss->items as $item) {
// }
//
// Note you may need to install php-xml for this to work. Something like:
// sudo apt install php-xml
//
// You may need to update the HTMLPurifier serializer directory so that it can cache files:
// chmod -R 0777 vendor/ezyang/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer
class RSS {
    public $title = '';
    public $link = '';
    public $description = '';
    public $language = '';
    public $url = '';

    public $data = [];
    public $items = [];

    // Right now, only accepting URLs as input but may accept strings or files in the future.
    public function __construct($input, $headers = []) {
        $rest = new REST();
        // Set response type to string
        $response = $rest->get($input, $headers, ['string']); 

        // Don't output parse warnings
        libxml_use_internal_errors (true);
        $this->data = simplexml_load_string($response);
        if($this->data === false) {
            throw new \Exception('The URL does not appear to be valid XML. Please enter a valid RSS feed.');
        }

        // RSS feeds are wrapped in channel and atom feeds are not.
        if(!isset($this->data->channel->title) && !isset($this->data->title)) {
            throw new \Exception('The URL does not appear to be a valid RSS feed. Please enter a valid RSS feed.');
        }

        $this->title = $this->meta('title');
        $this->link = $this->meta('link');
        $this->description = $this->meta('description');
        $this->language = $this->meta('language');

        if(isset($this->data->channel->item)) {
            // RSS
            foreach($this->data->channel->item as $item) {
                $temp = [];

                $temp['title'] = $this->item($item, 'title');
                $temp['link'] = $this->item($item, 'link');
                $temp['guid'] = $this->item($item, 'guid');
                $temp['pub_date'] = $this->item($item, 'pubDate');
                $temp['description'] = $this->item($item, 'description');

                $utc = new DateTimeZone('UTC');
                try {
                    $temp['published_at'] = new DateTime($temp['pub_date']);
                    $temp['published_at']->setTimezone($utc);
                } catch(\Exception $e) {
                    // Empty: Just ignore the pub_date
                }

                $this->items[] = $temp;
            }
        } elseif(isset($this->data->entry)) {
            // Atom
            foreach($this->data->entry as $item) {
                $temp = [];

                $temp['title'] = $this->item($item, 'title');
                $temp['link'] = $this->item($item, 'link');
                $temp['guid'] = $this->item($item, 'id');
                $temp['pub_date'] = $this->item($item, 'updated');
                $temp['description'] = $this->item($item, 'content');

                $utc = new DateTimeZone('UTC');
                $temp['published_at'] = new DateTime($temp['pub_date']);
                $temp['published_at']->setTimezone($utc);

                $this->items[] = $temp;
            }
        }

        // Later will need to parse the URL and find the real RSS feed (if the passed in URL is not the real feed).
        $this->url = $input;
    }

    public function item($item, $type) {
        $output = '';
        if(isset($item->{$type})) {
            $temp = (string) $item->{$type};
            if(in_array($type, ['description', 'content'])) {
                $config = HTMLPurifier_Config::createDefault();
                $purifier = new HTMLPurifier($config);
                $temp = $purifier->purify($temp);
            } elseif($type == 'link' && isset($item->{$type}->attributes()['href'])) {
                $temp = (string) $item->{$type}->attributes()['href'];
            } else {
                $temp = strip_tags($temp);
            }

            $output = $temp;
        }

        return $output;
    }

    public function meta($type) {
        $output = '';

        if(isset($this->data->channel->{$type})) {
            // RSS
            $temp = (string) $this->data->channel->{$type};
            $temp = strip_tags($temp);

            $output = $temp;
        } elseif(isset($this->data->{$type})) {
            // Atom
            if($type == 'link') {
                $temp = (string) $this->data->{$type}->attributes()['href'];
            } else {
                $temp = (string) $this->data->{$type};
                $temp = strip_tags($temp);
            }

            $output = $temp;
        }

        return $output;
    }
}

