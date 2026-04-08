<?php
$symlinkPath = 'C:\\xampp\\htdocs\\sneaker_id\\public\\storage';

echo "Attempting to fix symlink...\n";
echo "Symlink path: $symlinkPath\n";

// Check current status
if (is_link($symlinkPath)) {
    echo "Current symlink detected.\n";
    $target = readlink($symlinkPath);
    echo "Current target: $target\n";
    
    // Try to unlink
    if (unlink($symlinkPath)) {
        echo "Symlink deleted successfully.\n";
    } else {
        echo "Failed to delete symlink with unlink().\n";
        // Try rmdir for directory symlinks
        if (rmdir($symlinkPath)) {
            echo "Symlink deleted with rmdir.\n";
        } else {
            echo "Failed to delete with rmdir too.\n";
        }
    }
} elseif (is_dir($symlinkPath)) {
    echo "It's a regular directory, not a symlink.\n";
} else {
    echo "Path doesn't exist or is something else.\n";
}

// Try to create symlink
echo "\nCreating new symlink...\n";
$target = 'C:\\xampp\\htdocs\\sneaker_id\\storage\\app\\public';
try {
    // For Windows, we need to use either symlink or junction
    // PHP's symlink may require admin privileges
    $result = symlink($target, $symlinkPath);
    if ($result) {
        echo "Symlink created successfully!\n";
    } else {
        echo "symlink() returned false.\n";
        echo "This might require admin privileges on Windows.\n";
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}

// Verify
if (is_link($symlinkPath)) {
    echo "Verification: Symlink is valid!\n";
    echo "Target: " . readlink($symlinkPath) . "\n";
} else {
    echo "Verification failed: Symlink not valid.\n";
}
?>
