<?php

require_once ROOT_DIR . '/app/services/utils/AuthorizationUtils.php';
require_once ROOT_DIR . '/app/services/docbook/DocBookService.php';

class DocBookController
{
    public static function getDocBookDocument(Request $request) : void
    {
        $jwt = Headers::getHeaderValue($request->headers, 'Authorization');
        if(!AuthorizationUtils::isAdminAuthorized($jwt)) {
            Response::unauthorized();
            return;
        }

        $docBookDocument = DocBookService::createDocBookDocument();

        Response::setHeaders(
            ["Content-Type: application/xml; charset=utf-8",
            "Content-Disposition: attachment; filename=docbook.xml"] );

        Response::successRaw($docBookDocument);
    }
}