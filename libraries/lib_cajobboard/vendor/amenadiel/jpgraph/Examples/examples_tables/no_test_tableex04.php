<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
require_once 'jpgraph/jpgraph_canvas.php';
require_once 'jpgraph/jpgraph_table.php';

$data = [['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    ['Team 1', '15.2', '12.5', '9.9', '70.0', '22.4', '21.5'],
    ['Team 2', '23.9', '14.2', '18.6', '71.3', '66.8', '42.6'],
    ['Sum:'],
];

$r = count($data);
$c = 7;

for ($i = 1; $i < $c; ++$i) {
    $tmp = 0;
    for ($j = 1; $j < $r - 1; ++$j) {
        $tmp += $data[$j][$i];
    }
    $data[3][$i] = sprintf('%2.1f', $tmp);
}

$__width  = 350;
$__height = 200;
$graph    = new CanvasGraph($__width, $__height);

$table = new GTextTable();
$table->Init();
$table->Set($data);
$table->SetBorder(2, 'black');

// Highlight summation row
$table->SetRowFillColor($r - 1, 'yellow');
$table->SetCellAlign($r - 1, 0, 'right');

// Setup row and column headers
$table->SetRowFont(0, FF_ARIAL, FS_NORMAL, 10);
$table->SetRowColor(0, 'navy');
$table->SetRowFillColor(0, 'lightgray');

$table->SetColFont(0, FF_ARIAL, FS_NORMAL, 10);
$table->SetColColor(0, 'navy');
$table->SetColFillColor(0, 'lightgray');

$table->SetRowGrid($r - 1, 1, 'black', TGRID_DOUBLE);

$graph->Add($table);
$graph->Stroke();
