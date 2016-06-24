<?php

namespace BrngyWiFi\Http\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
//use BrngyWiFi\Jobs\SendLogsEmail;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function createLog(Request $request)
    {
        if (!is_dir('error-logs')) {
            mkdir('error-logs', 0777);
        }
        $fileName = date('Y-m-d_H-i-s') . '.txt';

        $file = fopen('error-logs/' . $fileName, 'w') or die('Could not create report file: ' . $fileName);

        foreach ($request->all() as $key => $value) {
            $reportLine = $key . " = " . $value . " \n";

            fwrite($file, $reportLine) or die('Could not write to report file ' . $reportLine);
        }

        fclose($file);

        //$this->dispatch(new SendLogsEmail($fileName));

        return array('result' => 'success');
    }
}
