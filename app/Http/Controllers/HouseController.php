<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HouseController extends Controller
{
    public function store(Request $request)
    {
        $filename = $request->file('photo')->store('houses');

        House::create([
            'name' => $request->name,
            'photo' => $filename,
        ]);

        return 'Success';
    }

    public function update(Request $request, House $house)
    {
        $oldPhotoPath = $house->photo;
        $filename = $request->file('photo')->store('houses');

        // TASK: Delete the old file from the storage
        if ($oldPhotoPath) {
            Storage::delete($oldPhotoPath);
        }
        
        $house->update([
            'name' => $request->name,
            'photo' => $filename,
        ]);

        return 'Success';
    }

    public function download(House $house)
    {
        // TASK: Return the $house->photo file from "storage/app/houses" folder
        // for download in browser
        $photoPath = $house->photo;

    // 如果照片路徑存在
        if ($photoPath) {

            $filePath = storage_path('app/' . $photoPath);

            if (file_exists($filePath)) {
                return response()->download($filePath);
            }
        }
    }
}
