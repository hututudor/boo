<?php

require_once ROOT_DIR . '/app/services/csv/CsvService.php';
require_once ROOT_DIR . '/app/services/utils/AuthorizationUtils.php';
class CsvController
{
    public static function getCsv(Request $request) : void
    {
        $jwt = Headers::getHeaderValue($request->headers, 'Authorization');
        if(!AuthorizationUtils::isSimpleAuthorized($jwt)) {
            Response::unauthorized();
        }

        $csvFilePath = CsvService::generateCsv($jwt);

        if($csvFilePath == null) {
            Response::internalServerError();
        }

        Response::setHeaders(['Content-Type: text/csv; charset=utf-8',
            'Content-Disposition: attachment; filename="database.csv"',
            'Content-Length: ' . filesize($csvFilePath)]);

        Response::successRaw(file_get_contents($csvFilePath));

        CsvService::deleteTempFile($csvFilePath);
    }
}