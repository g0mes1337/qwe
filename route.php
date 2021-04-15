<?php
include_once "application/config/route_pages.php";
include_once "application/core/database/connect.php";

$current = $pages[$routes[1]];
if (isset($current['onload'])) $current['onload']();
if ($current == null) $current = $pages['404'];
$content = file_get_contents(__DIR__ . '/application/template/' . $current['link']);
if (isset($current['scripts'])) {
    foreach ($current['scripts'] as $script) {
        $scripts .= "<script rel=\"script\" type=\"application/javascript\" src=\"/assets/js/${script}.js\"></script>";
    }
}
include __DIR__ . "/application/template/page.php";

