@extends('layouts.email')

@section('response')
    Approved
@endsection

@section('content')
    <table style='margin-bottom: 20px; width: 50%;'>
        <thead>
            <tr>
                <td style='font-weight: bold;'>
                   Title 
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $media->title }}</td>
            </tr>
        </tbody>
    </table>
@endsection