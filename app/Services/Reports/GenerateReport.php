<?php namespace BrngyWiFi\Services\Reports;

class GenerateReport
{
    private $excel;

    public function __construct(\Excel $excel)
    {
        $this->excel = $excel;
    }

    public function generate($reportType)
    {
        $headers = array();
        $valueArray = array();

        \Excel::create('BRGY COMMS REPORT', function ($excel) use ($reportType, $headers, $valueArray) {

            foreach ($reportType as $tyKey => $rtVal) {

                $excel->sheet($tyKey, function ($sheet) use ($rtVal, $headers, $valueArray) {

                    foreach ($rtVal as $rtValKey => $v) {

                        foreach ($v as $key => $value) {
                            $headers[$key] = $key;
                            $valueArray[] = $value;
                        }

                    }

                    $sheet->loadView('reports.emergency_report', array('report' => $headers, 'testArray' => $valueArray));
                });
            }
        })->download('xlsx');
    }
}
