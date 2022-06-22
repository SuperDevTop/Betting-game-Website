<?php

namespace App\Traits;

use Image;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

trait FileManipulationTrait
{
    protected $fileDisk ='public';
    /**
     * [setUploadDisk : Disk Setter]
     * @param [type] $disk [local/s3/rackspace]
     */
    public function setUploadDisk($disk)
    {
        $this->fileDisk = $disk;
        return $this;
    }
    /**
     * [getUploadDisk : Fetch Disc Name]
     * @return [type] [description]
     */
    public function getUploadDisk()
    {
        return $this->fileDisk;
    }

    /**
     * [setFilePrivacy : Set file Privacy]
     * @param [type] $privacy [public/private]
     */
    public function setFilePrivacy($filePath, $privacy = 'public')
    {
        return Storage::setVisibility("$filePath", "$privacy");
    }

    /**
     * [getOrginalFileName : Fetching file original Name]
     * @param  [FILE OBJ] $file [description]
     * @return [STRING]       [Name Of the File]
     */
    public function getOrginalFileName($file)
    {
        return $file->getClientOriginalName();
    }

    /**
     * [getFileExtension : Fetch File Extenstion]
     * @param  [FILE OBJ] $file [description]
     * @return [STRING]       [extension of the file]
     */
    public function getFileExtension($file)
    {
        return $file->getClientOriginalExtension();
    }

    /**
     * [generateFileName : File name generator based on current Name]
     * @param  [FILE OBject] $file [description]
     * @return [String]       [New Name for the file]
     */
    public function generateFileName($file)
    {
        $fileOrgName = clean($this->getOrginalFileName($file));
        $fileExt     = $this->getFileExtension($file);
        $fileName    = $fileOrgName.'_'.time().'.'.$fileExt;

        if (strlen($fileName) >= 255) {
            $fileName = time().'.'.$fileExt;
        }
        return $fileName;
    }

    /**
     * [quickUpload description]
     * @param  [FILE] $fileObj   [description]
     * @param  [STRING] $directory [description]
     * @return [STRING]            [path of the file]
     */
    public function quickUpload($fileObj, $directory)
    {
        $path = $fileObj->store($directory, $this->getUploadDisk());
        return $path;
    }

    /**
     * [uploadAs description]
     * @param  [type] $fileObj   [description]
     * @param  [type] $directory [description]
     * @param  string $fileName  [description]
     * @return [type]            [description]
     */
    public function uploadAs($fileObj, $directory, $fileName='')
    {
        $name = ($fileName == '')? $this->generateFileName($fileObj): $fileName;
        $path = $fileObj->storeAs($directory, $name, $this->getUploadDisk());
        return $path;
    }

    public function copyFile($oldFile, $dirname, $newFile)
    {
        $old = './public/'.$oldFile;
        $new =  'public/'.$dirname.'/'.$newFile;

        Storage::copy($old, $new);
        $this->setFilePrivacy($new);

        return $new;
    }

    /**
     * [getFileUrl : Get FIle URL]
     * @param  [STRING] $fileName [Path of the fille]
     * @return [STRING]           [URL]
     */
    public function getFileUrl($fileName)
    {
        $url = Storage::url($fileName);
        return asset($url);
    }

    /**
     * [destoryFile : Remove file]
     * @param  [STRING] $file [File name with path]
     * @return [BOOLEAN]       [description]
     */
    public function destoryFile($file)
    {
        return Storage::delete($file);
    }

    /**
     * [destoryFiles : Remove Multiple files]
     * @param  [ARRAY] $file [ARRAY OF File name with path]
     * @return [BOOLEAN]       [description]
     */
    public function destoryFiles($files)
    {
        return Storage::delete($files);
    }

    /**
     * ############ DIRECTORY FUNCTIONS ############
     */

    /**
     * [getFolderFiles : Get the all files in the particular directory]
     * @param  [STRING] $directory [Directory path]
     * @return [ARRAY]            [Array of files Name]
     */
    public function getFolderFiles($directory)
    {
        $disk = $this->getUploadDisk();
        return Storage::disk($disk)->allFiles("$directory");
    }

    /**
     * [getDirectories : Get Inner Direcories]
     * @param  [STRING] $directory [Name of directory with path : After storage/app/]
     * @return [ARR]            [Get all sub-directories]
     */
    public function getDirectories($directory)
    {
        $disk = $this->getUploadDisk();
        return Storage::disk($disk)->directories($directory);
    }

    /**
     * [createDir : Make A directory inside storage folder]
     * @param  [name of directory] $directory [description]
     * @return [STRING]            [Path of directory]
     */
    public function createDir($directory)
    {
        return Storage::makeDirectory($directory);
    }

    /**
     * [destroyDirectory : Distroy Particular DIr]
     * @param  [STRING] $directory [Path of directory]
     * @return [type]            [description]
     */
    public function destroyDirectory($directory)
    {
        $disk = $this->getUploadDisk();
        Storage::disk($disk)->deleteDirectory("$directory");
    }

    public function resizeImg($source, $size, $destination)
    {
        $img = Image::make($source);
        // Ratio wise resizing
        $img->resize($size, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($destination);
    }

    /**
     * [exifFixer : Fix Image exif issue]
     * @param  [type] $source [description]
     * @return [type]         [description]
     */
    public function exifFixer($source)
    {
        $img  = Image::make($source);
        $exif = $img->exif();

        if (array_has($exif, 'Orientation')) {
            switch ($exif['Orientation']) {
                case 3:
                    $img->rotate(180);
                    $img->save();
                    break;

                case 8:
                    $img->rotate(270);
                    $img->save();
                    break;

                case 6:
                    $img->rotate(90);
                    $img->save();
                    break;

                default:
                    # code...
                    break;
            }
        }
    }

    /**
     * [transferToS3 description]
     * @param  [type] $directory [description]
     * @return [type]            [description]
     */
    public function transferToS3($directory)
    {
        $files = $this->getFolderFiles($directory);
        foreach ($files as $file) {
            $sourceInfo = pathinfo($file);
            extract($sourceInfo);

            $s3File = $dirname.'/'.$basename;
            $source = base_path('storage/app/public/'.$s3File);
            Storage::disk('s3')->put($s3File, file_get_contents($source));
        }
        $this->destroyDirectory($directory);
    }

    public function getS3Url($fileName)
    {
        return s3URL.$fileName;
    }
}
