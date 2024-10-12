<?php
/*
 * Sitemap Generator PHP Script (File System Based)
 */

// Configuration
$base_url = 'https://www.lbliagalaxy.com'; // Base URL of your website
$root_dir = './'; // Root directory to scan for files
$exclude_dirs = array('admin', 'login'); // Directories to exclude from the sitemap
$exclude_files = array('sitemap.php'); // Files to exclude from the sitemap

// Get all files and directories from the file system
$urls = array();
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root_dir));
foreach ($iterator as $file) {
    if ($file->isFile() && !in_array($file->getFilename(), $exclude_files)) {
        $url = $base_url . '/' . str_replace($root_dir, '', $file->getPathname());
        $urls[] = $url;
    }
}

// Generate the sitemap XML
$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

foreach ($urls as $url) {
    $xml .= '<url>';
    $xml .= '<loc>' . $url . '</loc>';
    $xml .= '<changefreq>weekly</changefreq>'; // Update frequency
    $xml .= '<priority>0.8</priority>'; // Priority
    $xml .= '</url>';
}

$xml .= '</urlset>';

// Output the sitemap XML
header('Content-Type: application/xml');
echo $xml;

// Save the sitemap to a file (optional)
file_put_contents('sitemap.xml', $xml);
