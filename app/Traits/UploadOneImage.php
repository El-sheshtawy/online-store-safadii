<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UploadOneImage
{
    public function uploadImageDB(Request $request, $inputName, $model)
    {
        if (!$request->hasFile($inputName)) {
                return $model->$inputName;
        }
        $image = $request->file($inputName);
        $imageName = time().'.'.$image->getClientOriginalExtension();
        return $imageName;
    }

    public function storeImageDisk(Request $request, $inputName, $folderPath, $storageDisk)
    {
        if (!$request->hasFile($inputName)) {
            return;
        }
        $image = $request->file($inputName);
        $imageName = time().'.'.$image->getClientOriginalExtension();
        return $image->storeAs($folderPath, $imageName, $storageDisk);
    }

    public function removeImageDisk($model, $inputName, $folderPath)
    {
        $modelImage = $model->$inputName;
        if (!$modelImage) {
            return;
        }
        if (file_exists(public_path("{$folderPath}/{$modelImage}"))) {
            unlink(public_path("{$folderPath}/{$modelImage}"));
        }
    }
}
