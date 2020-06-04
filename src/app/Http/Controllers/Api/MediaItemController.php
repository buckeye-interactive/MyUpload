<?php

namespace App\Http\Controllers\Api;

use App\MediaItem as MediaItem;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class MediaItemController extends Controller
{
    public function store(Request $request)
    {
        $sessionId = $request->session()->getId();
        $media = $request->file('file');

        if (!empty($media)) {
            $userEmail = $request->session()->get('user_email');
            if ($request->user()) {
                $userEmail = $request->user()->email;
            }

            $mediaItem = new MediaItem([
                'user_session_id'      => $sessionId,
                'submitted_users_name' => $request->submitted_users_name,
                'phone_number'         => $request->phone_number,
                'user_email'           => $userEmail,
            ]);

            $mediaItem->save();

            // If upload is an image, check the orientation
            if (substr($media->getMimeType(), 0, 5) == 'image' && Arr::exists(['jpg', 'jpeg', 'png', 'gif', 'webp'], $media->getClientOriginalExtension())) {
                $filename = '/tmp/' . $mediaItem->id;

                // Set correct orientation
                $img = \Image::make($media->getRealpath());
                $img->orientate();
                $img->save($filename);

                // Save to disk
                $mediaItem
                    ->addMedia($filename)
                    ->setFileName($media->getClientOriginalName())
                    ->setName(pathinfo($media->getClientOriginalName(), PATHINFO_FILENAME))
                    ->toMediaCollection('media');
            } else {
                $mediaItem->addMediaFromRequest('file')->toMediaCollection('media');
            }
        }
    }
}
