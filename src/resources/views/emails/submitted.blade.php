@extends('layouts.email')

@section('response')
    Submitted
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
            @foreach ($media as $item)

                @if($loop->iteration  % 2 == 0)
                
                    <tr style='background: #F5F5F5;'>
                        <td>{{ $item->title }}</td>
                    </tr>

                @else

                    <tr>
                        <td>{{ $item->title }}</td>
                    </tr>

                @endif
            
            @endforeach
        </tbody>
    </table>
@endsection