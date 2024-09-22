<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;

class ItemController extends Controller
{
    /**
     * Upload an image for the specified Item.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request, $id)
    {
        try {
            $item = Item::find($id);

            if (!$item) {
                return response()->json(['error' => 'Item not found'], 404);
            }


            if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
                return response()->json(['error' => 'Invalid image file'], 400);
            }
            

            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();

            $item->imgUrl = $uploadedFileUrl;
            $item->save();

            return response()->json([
                'message' => 'Image uploaded successfully',
                'imgUrl' => $uploadedFileUrl
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to upload image',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
