@include("layout.header")
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
<h1 style="color: #bee5eb; font-family:monospace; font-weight: bold; margin-left: 11%; font-size: 3em;">{{ $title }}</h1>
@if (empty($actors))
<div class="col text-center">
    <div class="alert alert-danger">
        <FONT style="font-family:monospace; font-weight: bold; margin-left: 11%" COLOR="red">Did not found any actor</FONT>
    </div>
</div>
@else
<div>
    <FONT style="color: #bee5eb; font-family:monospace;  margin-left: 11%; font-size: 2em" COLOR="black">Total amount of actors: {{ $actors }}</FONT>
</div>
@endif
@include("layout.footer")