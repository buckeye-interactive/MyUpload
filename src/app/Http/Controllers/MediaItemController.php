<?php

namespace App\Http\Controllers;

use App\MediaItem as MediaItem;
use App\User as User;
use App\Mail\MediaSubmitted;
use App\Mail\MediaApproved;
use App\Mail\MediaRejected;
use App\WantedPhoto as WantedPhoto;
use Spatie\MediaLibrary\Models\Media as Media;
use Illuminate\Http\Request;
use App\Exports\MediaItemExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaStream;
use Illuminate\Support\Facades\Mail;

class MediaItemController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $wantedPhotos = WantedPhoto::all()->first();

        if ($wantedPhotos) {
            $wantedPhotos = [
                $wantedPhotos->photo_priority_one,
                $wantedPhotos->photo_priority_two,
                $wantedPhotos->photo_priority_three,
                $wantedPhotos->photo_priority_four,
                $wantedPhotos->photo_priority_five,
            ];
        }

        return view('media-item.create', compact(['wantedPhotos']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(503);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MediaItem  $mediaItem
     * @return \Illuminate\Http\Response
     */
    public function show(MediaItem $mediaItem)
    {
        return $mediaItem->getMedia('media')->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MediaItem  $mediaItem
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MediaItem $mediaItem)
    {
        $totalQueueSize = MediaItem::forSession($request->session()->getId())
            ->orderBy('created_at', 'asc')
            ->count();

        $completedQueueSize = MediaItem::forSession($request->session()->getId())
            ->pending()
            ->orderBy('created_at', 'asc')
            ->count() + 1;

        $previousItem = MediaItem::forSession($request->session()->getId())
            ->pending()
            ->orderBy('updated_at', 'desc')
            ->first();

        return view('media-item.edit', compact([
            'mediaItem',
            'totalQueueSize',
            'completedQueueSize',
            'previousItem',
        ]));
    }

    /**
     * Show the form for bulk editing the specified resource.
     *
     * @param  \App\MediaItem  $mediaItem
     * @return \Illuminate\Http\Response
     */
    public function bulk(Request $request)
    {
        $totalQueueSize = MediaItem::forSession($request->session()->getId())
            ->orderBy('created_at', 'asc')
            ->count();

        $completedQueueSize = MediaItem::forSession($request->session()->getId())
            ->pending()
            ->orderBy('created_at', 'asc')
            ->count() + 1;
        $mediaItem = null;
        $previousItem = null;

        return view('media-item.bulk', compact([
            'totalQueueSize',
            'completedQueueSize',
            'mediaItem',
            'previousItem',
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MediaItem  $mediaItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MediaItem $mediaItem)
    {
        $request->validate([
            "original_creator" => config('myupload.author_not_required') ? '' : "required",
            "title" => "required",
            "description" => "required",
            "credit" => config('myupload.credit_disabled') ? '' : "required",
            "copyright" => config('myupload.copyright_disabled') ? '' : "required",
            "authorization" => "required"
        ],[
            'authorization.required' => 'Check the accuracy verification box.',
        ]);


        $mediaItem->update($request->all());

        $mediaItem->update([
            'status' => MediaItem::PENDING,
        ]);

        return $this->batchSubmit($request, $mediaItem, false);
    }

    /**
     * Bulk update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MediaItem  $mediaItem
     * @return \Illuminate\Http\Response
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            "original_creator" => config('myupload.author_not_required') ? '' : "required",
            "title" => "required",
            "description" => "required",
            "credit" => config('myupload.credit_disabled') ? '' : "required",
            "copyright" => config('myupload.copyright_disabled') ? '' : "required",
            "authorization" => "required"
        ]);

        $sessionId = $request->session()->getId();
        $media = MediaItem::unsubmitted()
            ->where('user_session_id', '=', $sessionId)
            ->get();

        foreach ($media as $mediaItem) {
            $mediaItem->update($request->all());

            $mediaItem->update([
                'status' => MediaItem::PENDING,
            ]);
        }

        return $this->completed($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MediaItem  $mediaItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(MediaItem $mediaItem)
    {
        $deleted = $mediaItem->destroy($mediaItem->id);

        if ($deleted) {
            return back()->withSuccess('Media successfully deleted!');
        } else {
            return back()->withErrors('There was a problem with deleting the media. Please refresh the page and try again.');
        }
    }

    public function approved(Request $request)
    {
        $redirect = $this->forceDateRange($request);
        if ($redirect) return $redirect;

        $approved = MediaItem::approved()->range($request->start, $request->end)->get();

        return view('media-item.index', [
            'single' => true,
            'mediaItems' => $approved,
            'title' => 'Approved'
        ]);
    }

    public function rejected(Request $request)
    {
        $redirect = $this->forceDateRange($request);
        if ($redirect) return $redirect;

        $rejected = MediaItem::rejected()->range($request->start, $request->end)->get();

        return view('media-item.index', [
            'single' => true,
            'mediaItems' => $rejected,
            'title' => 'Rejected'
        ]);
    }

    public function adminDashboard(Request $request, MediaItem $mediaItem)
    {
        $user = $request->user();


        if ($user->is_admin) {
            $mediaItems = MediaItem::pending()->get();

            return view('auth.admin-dashboard', compact([
                'mediaItems'
            ]));
        }

        abort(403);
    }

    public function adminBulkApprove(Request $request)
    {
        $request->validate(['items' => 'required']);
        foreach ($request->items as $item) {
            $mediaItem = MediaItem::find($item);
            if (!$mediaItem) continue;

            $this->approve($mediaItem, $request->user());
        }
        return back()->withSuccess('Media successfully approved!');
    }

    public function adminBulkReject(Request $request)
    {
        $request->validate(['items' => 'required']);
        foreach ($request->items as $item) {
            $mediaItem = MediaItem::find($item);
            if (!$mediaItem) continue;

            $this->reject($mediaItem, $request->user());
        }
        return back()->withSuccess('Media successfully rejected!');
    }

    public function adminApprove(Request $request, MediaItem $mediaItem)
    {
        $this->approve($mediaItem, $request->user());
        return back()->withSuccess('Media successfully approved!');
    }

    public function adminReject(Request $request, MediaItem $mediaItem)
    {
        $this->reject($mediaItem, $request->user(), $request->comment);
        return back()->withSuccess('Media successfully rejected!');
    }

    private function approve(MediaItem $mediaItem, User $user)
    {
        $mediaItem->update([
            'status' => MediaItem::APPROVED,
            'reviewed_by' => $user->name,
            'reviewed_at' => Carbon::now(),
        ]);
        $email = $mediaItem->user_email;
        if(!config('myupload.approval_emails_disabled',false)) {
            Mail::to($email)->send(new MediaApproved($mediaItem));
        }
    }
    private function reject(MediaItem $mediaItem, User $user, $comment = null)
    {
        $mediaItem->update([
            'status' => MediaItem::REJECTED,
            'comment' => $comment,
            'reviewed_by' => $user->name,
            'reviewed_at' => Carbon::now(),
        ]);
        $email = $mediaItem->user_email;
        if(!config('myupload.approval_emails_disabled',false)) {
            Mail::to($email)->send(new MediaRejected($mediaItem));
        }
    }

    public function export(Request $request)
    {
        return Excel::download(new MediaItemExport($request->start, $request->end), 'media-items.xlsx');
    }

    public function downloadApproved(Request $request, MediaItem $mediaItem)
    {
        $approved = $mediaItem->approved()->range($request->start, $request->end)->get()->map(function ($mi) {
            return $mi->getMedia('media');
        })->flatten();

        return MediaStream::create('approved-media.zip')
            ->addMedia($approved);
    }

    public function topFive()
    {
        $wantedPhoto = WantedPhoto::first();

        if ($wantedPhoto === null) {
            $wantedPhoto = WantedPhoto::create([
                'photo_priority_one' => null,
                'photo_priority_two' => null,
                'photo_priority_three' => null,
                'photo_priority_four' => null,
                'photo_priority_five' => null,
            ]);
        }

        return view('media-item.top-five', compact(['wantedPhoto']));
    }

    public function addTopFive(Request $request)
    {
        $wantedPhoto = WantedPhoto::first();
        $wantedPhoto->update($request->all());

        return back()->with('wantedPhoto', $wantedPhoto)->with('success', 'Updated Sucessfully');
    }

    public function batchSubmit(Request $request, MediaItem $mediaItem, $json = true)
    {
        $sessionId = $request->session()->getId();
        $media = MediaItem::unsubmitted()
            ->where('user_session_id', '=', $sessionId)
            ->orderBy('created_at', 'asc')
            ->first();

        if ($media) {
            if ($json) {
                return response()->json($media->id);
            }
            return redirect()->route('media-item.edit', [$media->id]);
        } else {
            if ($json) {
                return response()->json('', 422);
            }
            if($request->user()) {
                return redirect()->route('admin');
            }
            return $this->completed($request);
        }
    }

    public function completed(Request $request)
    {
        $id = $request->session()->getId();
        $email = $request->session()->get('user_email');
        $media = MediaItem::forSession($id)->pending()->get();

        if ($request->user()) {
            $email = $request->user()->email;
        }

        Mail::to($email)->send(new MediaSubmitted($media));

        return view('media-item.upload-more');
    }

    public function cancel(Request $request)
    {
        $request->session()->pull('user_email');
        $request->session()->pull('human');
        $request->session()->regenerate();

        return redirect()->route('welcome');
    }

    private function forceDateRange(Request $request)
    {
        if (!$request->start || !$request->end) {
            $end = Carbon::now()->format('Y-m-d');
            $start = Carbon::now()->subMonth()->format('Y-m-d');
            return redirect($request->url() . "?start=$start&end=$end");
        }
    }
}
