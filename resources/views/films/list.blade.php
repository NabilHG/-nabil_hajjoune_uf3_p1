@include('layout.header')
<div style="
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        opacity: 1;
        background-color:papayawhip; 
        filter: ightness(0.9);
        background-size: cover;
        box-shadow: inset 0 4px 15px rgba(0, 0, 0, 0.9);">
</div>
<h1 style="color: #bee5eb; font-family: monospace; font-weight: bold; margin-left: 11%">{{ $title }}</h1>

@if (empty($films))
<div class="col text-center">
    <div class="alert alert-danger">
        <FONT style="font-family:monospace; font-weight: bold; margin-left: 11%" COLOR="red">Did not found any film</FONT>
    </div>
</div>
@else
<div align="center">
    <table border="1x solid" style=" border-collapse: collapse;
            width: 50%;  background-color:#bee5eb; color: black; font-family: monospace;">
        <tr>
            @foreach ($films as $film)
            @foreach (array_keys($film) as $key)
            <th style=" padding: 8px; text-align: left; border: 3px solid #ddd;">
                {{ $key }}
            </th>
            @endforeach
            @break
            @endforeach
        </tr>

        @foreach ($films as $film)
        <tr style="background-color: #bee5eb;">
            <td style=" padding: 8px;text-align: left;border: 3px solid #ddd;">
                {{ $film['name'] }}
            </td>
            <td style=" padding: 8px;text-align: left;border: 3px solid #ddd;">
                {{ $film['year'] }}
            </td>
            <td style=" padding: 8px;text-align: left;border: 3px solid #ddd;">
                {{ $film['genre'] }}
            </td>
            <td style=" padding: 8px;text-align: left;border: 3px solid #ddd;">
                {{ $film['country'] }}
            </td>
            <td style=" padding: 8px;text-align: left;border: 3px solid #ddd;">
                {{ $film['duration'] }}
            </td>
            <td style=" padding: 8px;text-align: left;border: 3px solid #ddd;"><img src={{ $film['img_url'] }} style="width: 100px; height: 120px;" /></td>

        </tr>
        @endforeach
    </table>
</div>

@endif
@include('layout.footer')