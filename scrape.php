<?php

// Function to download the M3U8 file
function downloadM3U8File($url, $saveTo) {
    // Use file_get_contents to download the file or cURL if you need more control
    $content = file_get_contents($url);
    
    if ($content === false) {
        die("Failed to download the M3U8 file.");
    }
    
    // Save the content to a file
    file_put_contents($saveTo, $content);
    return $saveTo;
}

// Function to modify group-title variables in the M3U8 file
function modifyGroupTitle($filePath, $newGroupTitles) {
    // Read the content of the M3U8 file
    $content = file_get_contents($filePath);

    if ($content === false) {
        die("Failed to read the M3U8 file.");
    }

    // Replace group-title= with the new group-title values
    foreach ($newGroupTitles as $oldTitle => $newTitle) {
        // Use regex to replace all occurrences of group-title="<oldTitle>"
        $content = preg_replace('/group-title="(' . preg_quote($oldTitle, '/') . ')"/', 'group-title="' . $newTitle . '"', $content);
    }

    // Save the modified content back to the file
    file_put_contents($filePath, $content);
}

// Example usage
$url = 'https://raw.githubusercontent.com/dtankdempse/daddylive-m3u/refs/heads/main/tivimate_playlist.m3u8';  // URL of the M3U8 file
$localFile = 'dlhd.m3u8';  // New local file name for the M3U8 file

// Download the M3U8 file
downloadM3U8File($url, $localFile);

// Define the group-title changes (old value => new value)
$newGroupTitles = [
    'USA (DADDY LIVE)' => 'United States',
    'SPORTS (DADDY LIVE)' => 'Sport',
    'UK (DADDY LIVE)' => 'United Kingdom',
    'Canada (DADDY LIVE)' => 'Canada',  
    'SPORTS MISC (DADDY LIVE)' => 'Sport',  
    'Events (DADDY LIVE)' => 'Events',  
    // Add more as needed
];

// Modify the group-title values in the M3U8 file
modifyGroupTitle($localFile, $newGroupTitles);

echo "M3U8 file modified successfully.\n";

?>
