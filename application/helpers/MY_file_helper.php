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


/**
 * Deletes a directory and all files and folders under it
 * @return TRUE
 * @param $directory String Directory Path
 * @param $empty Boolean Wheater directory is empty or not
 */
if ( ! function_exists('remove_directory'))
{
    function remove_directory($directory, $empty=FALSE)
    {
        if(substr($directory,-1) == '/') {
            $directory = substr($directory,0,-1);
        }

        if(!file_exists($directory) || !is_dir($directory)) {
            return FALSE;
        } elseif(!is_readable($directory)) {

        return FALSE;

        } else {

            $handle = opendir($directory);
            while (FALSE !== ($item = readdir($handle)))
            {
                if($item != '.' && $item != '..') {
                    $path = $directory.'/'.$item;
                    if(is_dir($path)) {
                        remove_directory($path);
                    }else{
                        unlink($path);
                    }
                }
            }
            closedir($handle);
            if($empty == FALSE)
            {
                if(!rmdir($directory))
                {
                    return FALSE;
                }
            }
        return TRUE;
        }
    }
}