<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter File Helpers Extension
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 */

// ------------------------------------------------------------------------

/**
 * Recursively Clone Directory
 *
 * Copy files from specfied in the soucre path to destination path and returns TRUE if success.
 *
 * @access	public
 * @param	string path to source & destination 
 * @return	bool
 */
if ( ! function_exists('recurse_copy'))
{
    function recurse_copy($source, $dest)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            recurse_copy("$source/$entry", "$dest/$entry");
        }

        // Clean up
        $dir->close();
        return true;
    }
}