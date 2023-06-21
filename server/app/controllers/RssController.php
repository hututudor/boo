<?php

require_once ROOT_DIR . '/app/services/rss/RssService.php';

class RssController
{
    public static function getFeed(Request $request): void
    {
        $jwt = Headers::getHeaderValue($request->headers, 'Authorization');

        if (!AuthorizationUtils::isSimpleAuthorized($jwt)) {
            Response::unauthorized();
            return;
        }

        $xml = RssService::generateRssFeed($jwt);

        Response::setHeaders(['Content-Type: application/rss+xml; charset=utf-8']);
        Response::success($xml);
    }
}