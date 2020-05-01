<?php

namespace App\Http\Controllers;

use App\Services\Export\ExportDataFactory;
use Illuminate\Http\Request;

class ExportDataController extends Controller
{
    public function export(string $method='') {
        if (!isset(ExportDataFactory::$availableMethods[$method])) {
            abort(500, 'Unknown export method');
        }

        $isEncoded =  (bool) request()->get('is_encrypted', true);

        try {
            $exporter = ExportDataFactory::getExportIntance($method);
            $content = $exporter->getStringData($isEncoded);

            return response($content)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="data.csv"');
        } catch (\Exception $e) {
            throw new \Exception($e);
        }

    }
}
