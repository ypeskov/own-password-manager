<?php

namespace App\Http\Controllers;

use App\Services\Export\ExportDataDownloadable;
use App\Services\Export\ExportDataFactory;
use App\Services\Export\ExportDataSendable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportDataController extends Controller
{
    public function export(string $method='') {
        if (!isset(ExportDataFactory::$availableMethods[$method])) {
            abort(500, 'Unknown export method');
        }

        $isEncrypted =  (bool) request()->get('is_encrypted', true);

        try {
            $exporter = ExportDataFactory::getExportIntance($method);

            if ($exporter instanceof ExportDataDownloadable)
            {
                $content = $exporter->getStringData(Auth::user(), $isEncrypted);

                return response($content)
                    ->header('Content-Type', 'text/csv')
                    ->header('Content-Disposition', 'attachment; filename="data.csv"');
            } else if ($exporter instanceof ExportDataSendable) {
                ddd($exporter);
            } else {
                throw new Exception('Unknown export method');
            }

        } catch (\Exception $e) {
            throw new \Exception($e);
        }

    }
}
