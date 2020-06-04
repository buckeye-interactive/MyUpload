@extends('layouts.email')

@section('response')
    Rejected
@endsection

@section('content')
    <table style='margin-bottom: 20px; width: 50%;'>
        <thead>
            <tr>
                <td style='font-weight: bold;'>
                   Title 
                </td>
                <td style='font-weight: bold;'>
                    Reason for Rejection
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $media->title }}</td>
                <td>{{ $media->comment }}</td>
            </tr>
        </tbody>
    </table>
@endsection