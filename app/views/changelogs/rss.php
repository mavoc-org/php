<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>                  
        <title>PipeRiv Changelog</title>
        <link><?php uri('changelog'); ?></link>
        <description>A list of updates to the PipeRiv site.</description>
        <language>en-us</language>
        <atom:link href="<?php uri('changelog/rss'); ?>" rel="self" type="application/rss+xml" />
    
        <?php foreach($items as $item): ?>
        <item>                 
            <title><?php esc($item->data['title']); ?></title>
            <link><?php esc($item->data['permalink']); ?></link>
            <guid><?php esc($item->data['permalink']); ?></guid>
            <pubDate><?php esc($item->data['created_at']->format('r')); ?></pubDate> 
            <description><![CDATA[<?php md($item->data['content']); ?>]]></description>
        </item>                
        <?php endforeach; ?>   
    
    </channel>                 
</rss>
