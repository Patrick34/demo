<?php

namespace App\Http\Controllers\Admin\Charts\Pies;

use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Highcharts\Chart;

class HighchartsPieController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();

        $this->chart->dataset('Red', 'pie', [10, 20, 80, 30])
                    ->color([
                        'rgb(70, 127, 208)',
                        'rgb(77, 189, 116)',
                        'rgb(96, 92, 168)',
                        'rgb(255, 193, 7)',
                    ]);

        // OPTIONAL
        $this->chart->displayAxes(false);
        $this->chart->displayLegend(true);

        // MANDATORY. Set the labels for the dataset points
        $this->chart->labels(['HTML', 'CSS', 'PHP', 'JS']);
    }
}
