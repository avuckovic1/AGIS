<?php
// 1.) Query an OSM Overpass API Endpoint
$query = 'area[name~"Hrvatska"];node(area)["population"~".*"];out;';

$context = stream_context_create(['http' => [
    'method'  => 'POST',
    'header' => ['Content-Type: application/x-www-form-urlencoded'],
    'content' => 'data=' . urlencode($query),
]]);

# please do not stress this service, this example is for demonstration purposes only.
$endpoint = 'http://overpass-api.de/api/interpreter';
libxml_set_streams_context($context);
$start = microtime(true);

$result = simplexml_load_file($endpoint);
printf("Query returned %2\$d node(s) and took %1\$.5f seconds.\n\n", microtime(true) - $start, count($result->node));

$data = array();

// 2.) Work with the XML Result
# nodes with xpath
$xpath = '//node[tag[@k = "population"]]';
$nas = $result->xpath($xpath);
foreach ($nas as $index => $naselje)
{
    # Get the name
    list($name) = $naselje->xpath('tag[@k = "name"]/@v') + ['(unnamed)'];
	list($population) = $naselje->xpath('tag[@k = "population"]/@v') + ['(unnamed)'];

	$data[] = array('Name' => "$name", 'Population' => "$population");
}

echo '<pre>'; print_r($data); echo '</pre>';
?>