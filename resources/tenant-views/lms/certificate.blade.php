<!DOCTYPE html>
<html>
<head>
    <style>
        @if($course->orientation == 'p')
        @page { margin: 0; }
        @page { size: 597px 842px; page-break-inside: avoid; }
    @else
        @page { margin: 0; }
        @page { size: 842px 597px; page-break-inside: avoid;}
        @endif
    </style>


</head>
<body>

<div id="canvas_wrapper" style="overflow: auto" class="mt-2">

    <div id="canvas" style="border:  solid 1px #CCCCCC; font-size: 14px; margin:0px auto; position: relative; width: {{ $width }}px; height: {{ $height }}px; overflow: hidden; @if(!empty($course->certificate_image)) background: url({{ asset($course->certificate_image) }});   background-repeat: no-repeat;  background-position: center;   background-size: cover;  @endif " >

        {!! $html !!}



    </div>



</div>


</body>
</html>

