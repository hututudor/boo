<?php

require_once ROOT_DIR . '/app/services/rss/RssService.php';
require_once ROOT_DIR . '/app/services/utils/AuthorizationUtils.php';

class RssController
{
    public static function getFeed(Request $request): void
    {
        $userId = $request->params['user_id'];

        $xml = RssService::generateRssFeed($userId);

        Response::setHeaders(['Content-Type: application/rss+xml; charset=utf-8']);
        Response::successRaw($xml);
    }
}