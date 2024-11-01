<?php 

class WPS_file_util{

    /**
     * Copy directory content
     *
     * @since 1.0
     * @return void
     */


    static function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    self::recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

	static function create_dir($dirpath='')
    {
        $res = true;
        if ($dirpath != ''){
            if (!file_exists($dirpath)){
                $res = mkdir($dirpath, 0755);
            }
        }
        return $res;
    }


    /* 
     * php delete function that deals with directories recursively, deletes the directory as well
     */
    static function delete_files( $dirname , $parent = '' ) {
        $parent_path = '';
        $current_path = '';

        //stop the parent being deleted if it passed when called
        if( $parent != '' ){
            $parent_path = pathInfo( $parent )['dirname'];
            $current_path = pathInfo( $dirname )['dirname'];
        }
        // return;

        if ( is_dir( $dirname ) ){
            $dir_handle = opendir($dirname);
                if (!$dir_handle){
                    return false;
                } 
                while($file = readdir($dir_handle)) {
                    if ($file != "." && $file != "..") {
                        if (!is_dir($dirname."/".$file)){
                            unlink($dirname."/".$file);
                        } else {
                            self::delete_files($dirname.'/'.$file , '');
                        }
                    }
                }
            closedir($dir_handle);

            //options to avoid deleting the parent
            if( $parent == '' ){
                    rmdir($dirname);
            }
            if( $parent == '' ){
                if( $parent_path != $current_path){
                    rmdir($dirname);
                }
            }
            return true;
        }
    }




      /**
       * Add files and sub-directories in a folder to zip file.
       * @param string $folder
       * @param ZipArchive $zipFile
       * @param int $exclusiveLength Number of text to be exclusived from the file path.
       */
      private static function folderToZip($folder, &$zipFile, $exclusiveLength) {
        $handle = opendir($folder);
        while (false !== $f = readdir($handle)) {
          if ($f != '.' && $f != '..') {
            $filePath = "$folder/$f";
            // Remove prefix from file path before add to zip.
            $localPath = substr($filePath, $exclusiveLength);
            if (is_file($filePath)) {
              $zipFile->addFile($filePath, $localPath);
            } elseif (is_dir($filePath)) {
              // Add sub-directory.
              $zipFile->addEmptyDir($localPath);
              self::folderToZip($filePath, $zipFile, $exclusiveLength);
            }
          }
        }
        closedir($handle);
      }

      /**
       * Zip a folder (include itself).
       * Usage:
       *   HZip::zipDir('/path/to/sourceDir', '/path/to/out.zip');
       *
       * @param string $sourcePath Path of directory to be zip.
       * @param string $outZipPath Path of output zip file.
       */
      public static function zipDir($sourcePath, $outZipPath){

        $pathInfo = pathInfo($sourcePath);
        $parentPath = $pathInfo['dirname'];
        $dirName = $pathInfo['basename'];

        $z = new ZipArchive();
        $z->open($outZipPath, ZIPARCHIVE::CREATE);
        $z->addEmptyDir($dirName);
        self::folderToZip($sourcePath, $z, strlen("$parentPath/"));
        $z->close();

      }





}