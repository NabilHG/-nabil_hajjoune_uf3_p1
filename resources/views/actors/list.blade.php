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

@if (empty($actors))
<div class="col text-center">
    <div class="alert alert-danger">
        <FONT style="font-family:monospace; font-weight: bold; margin-left: 11%" COLOR="red">Did not found any actor</FONT>
    </div>
</div>
@else
<div align="center">
    <table border="1x solid" style=" border-collapse: collapse;
            width: 50%;  background-color:#bee5eb; color: black; font-family: monospace;">
        <tr>
            @foreach ($actors as $actor)
            @foreach (array_keys($actor) as $key)
            <th style=" padding: 8px; text-align: left; border: 3px solid #ddd;">
                {{ $key }}
            </th>
            @endforeach
            @break
            @endforeach 
        </tr>

        @foreach ($actors as $actor)
            <tr style="background-color: #bee5eb;">
                <td style=" padding: 8px;text-align: left;border: 3px solid #ddd;">
                    {{ $actor->name }} {{ $actor->surname }}
                </td>
                <td style=" padding: 8px;text-align: left;border: 3px solid #ddd;">
                    {{ $actor->birthdate }}
                </td>
                <td style=" padding: 8px;text-align: left;border: 3px solid #ddd;">
                    {{ $actor->country }}
                </td>
                <td style=" padding: 8px;text-align: left;border: 3px solid #ddd;">
                    {{ $actor->img_url }}
                </td>
                <td style=" padding: 8px;text-align: left;border: 3px solid #ddd;">
                    {{ $actor->agencia }}
                </td>
            </tr>
        @endforeach
    </table>
</div>

@endif
@include('layout.footer')