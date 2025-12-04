<?php
/**
 * Script to check and clean malicious content from database
 * Run this script from command line: php check_malicious_content.php
 */

require __DIR__.'/bootstrap/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use Illuminate\Support\Facades\DB;

echo "Checking for malicious content in database...\n\n";

$maliciousKeywords = ['batmantoto', 'toto', 'slot', 'gacor', 'togel', 'gambling', 'casino'];
$tables = ['pages', 'posts', 'stores', 'spaces', 'publications', 'podcasts', 'materials', 'triennial2023s'];

$found = false;

foreach ($tables as $table) {
    try {
        $columns = DB::select("SHOW COLUMNS FROM `{$table}`");
        $textColumns = [];
        
        foreach ($columns as $column) {
            $type = strtolower($column->Type);
            if (strpos($type, 'varchar') !== false || 
                strpos($type, 'text') !== false || 
                strpos($type, 'longtext') !== false) {
                $textColumns[] = $column->Field;
            }
        }
        
        foreach ($textColumns as $column) {
            foreach ($maliciousKeywords as $keyword) {
                $results = DB::table($table)
                    ->where($column, 'LIKE', "%{$keyword}%")
                    ->get();
                
                if ($results->count() > 0) {
                    $found = true;
                    echo "⚠️  FOUND malicious content in table: {$table}, column: {$column}\n";
                    echo "   Keyword: {$keyword}\n";
                    echo "   Records found: " . $results->count() . "\n";
                    
                    foreach ($results as $result) {
                        echo "   - ID: {$result->id}\n";
                        if (isset($result->title)) {
                            echo "     Title: " . substr($result->title, 0, 100) . "...\n";
                        }
                    }
                    echo "\n";
                }
            }
        }
    } catch (Exception $e) {
        // Table might not exist, skip it
        continue;
    }
}

if (!$found) {
    echo "✅ No malicious content found in database tables.\n";
} else {
    echo "\n⚠️  WARNING: Malicious content found!\n";
    echo "Please review the records above and clean them manually.\n";
    echo "You can use the following SQL queries to clean:\n\n";
    echo "-- Example: UPDATE pages SET title = 'Sharjah Architecture Triennial' WHERE title LIKE '%batmantoto%';\n";
}

echo "\nDone.\n";




