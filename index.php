<?php
$startTime = microtime(true);

//load Spout Library
set_time_limit(500);
require_once 'spout-master/src/Spout/Autoloader/autoload.php';

//lets Use the Spout Namespaces
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
$filePath = "test2.xlsx";
$reader->open($filePath);

$data = array();
foreach ($reader->getSheetIterator() as $sheet) {
    foreach ($sheet->getRowIterator() as $rowIndex => $row) {
		if ($row[4] == "sv."){
			if($row[3] == "UKUPNO"){
				$data[] = array('Name' => $row[2], 'Population' => $row[5]);
			}else{
				$data[] = array('Name' => $row[3], 'Population' => $row[5]);
			}
		}
    }
}

echo '<pre>'; print_r($data); echo '</pre>';

$timeElapsed = round(microtime(true) - $startTime, 2);
echo "Elapsed time: {$timeElapsed}s\n";

$reader->close();
?>