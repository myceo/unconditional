@extends('layouts.admin')

@section('pageTitle',__('site.class').': '.$lecture->lesson->name)
@section('innerTitle',__('site.import-images').': '.limitLength($lecture->title,50))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">@lang('site.courses')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.classes.index',['course'=>$lecture->lesson->course_id]) }}">@lang('site.classes')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.classes.lectures.index',['lesson'=>$lecture->lesson_id]) }}">@lang('site.lectures')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.lectures.lecture-pages.index',['lecture'=>$lecture->id]) }}">@lang('site.content')</a></li>
    <li class="breadcrumb-item"><a href="#">@lang('site.import-images')</a></li>
@endsection


@section('content')
    <div class="container-fluid">

        <p>     {{ __('site.add-mul-img-lect') }}</p>


        <div class="row">
            <div class="col-md-12">
                <!-- The file upload form used as target for the file upload widget -->
                <form id="fileupload" action="{{ route('admin.lecture-pages.import-save',['lecture'=>$lecture->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                    <noscript>
                        {{ __('site.enable-javascript-img') }}
                    </noscript>
                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                    <div class="row mb-2 fileupload-buttonbar">
                        <div class="col-lg-7">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn btn-success  btn-sm fileinput-button">
                    <i class="fa fa-plus-circle"></i>
                    <span>{{ __('site.add-images') }}...</span>
                    <input type="file" name="picture" multiple>
                </span>
                            <button type="submit" class="btn btn-primary btn-sm start">
                                <i class="fa fa-upload"></i>
                                <span>{{ __('site.start-upload') }}</span>
                            </button>
                            <button type="reset" class="btn btn-warning  btn-sm cancel">
                                <i class="fa fa-ban"></i>
                                <span>{{ __('site.cancel-upload') }}</span>
                            </button>

                            <input style="display: none" type="checkbox" class="toggle">
                            <!-- The global file processing state -->
                            <span class="fileupload-process"></span>
                        </div>
                        <!-- The global progress state -->
                        <div class="col-lg-5 fileupload-progress fade">
                            <!-- The global progress bar -->
                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                            </div>
                            <!-- The extended global progress state -->
                            <div class="progress-extended">&nbsp;</div>
                        </div>
                    </div>
                    <!-- The table listing the files available for upload/download -->
                    <div class="card">
                        <div class="card-body">
                            <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                        </div>
                    </div>

                </form>

            </div>
        </div>

        <!-- The blueimp Gallery widget -->
        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>


    </div>
@endsection


@section('header')
    <link rel="stylesheet" href="{{ asset('vendor/gallery/css/blueimp-gallery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/jquery-file-upload/css/jquery.fileupload.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/jquery-file-upload/css/jquery.fileupload-ui.css') }}">

@endsection

@section('footer')
    <!-- The template to display files available for upload -->
    <script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">{{ __('site.processing') }}...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>{{ __('site.start') }}</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>{{ __('site.cancel') }}</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error:</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>{{ __('site.delete') }}</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } %}

        </td>
    </tr>
{% } %}
</script>

    <script src="{{ asset('vendor/jquery-ui-1.11.4/jquery-ui.min.js') }}"></script>

    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="{{ asset('vendor/javascript-templates/js/tmpl.min.js') }}"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="{{ asset('vendor/javascript-load-image/js/load-image.all.min.js') }}"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="{{ asset('vendor/javascript-canvas-to-blob/js/canvas-to-blob.min.js') }}"></script>
    <!-- blueimp Gallery script -->
    <script src="{{ asset('vendor/gallery/js/jquery.blueimp-gallery.min.js') }}"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="{{ asset('vendor/jquery-file-upload/js/jquery.iframe-transport.js') }}"></script>
    <!-- The basic File Upload plugin -->
    <script src="{{ asset('vendor/jquery-file-upload/js/jquery.fileupload.js') }}"></script>
    <!-- The File Upload processing plugin -->
    <script src="{{ asset('vendor/jquery-file-upload/js/jquery.fileupload-process.js') }}"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="{{ asset('vendor/jquery-file-upload/js/jquery.fileupload-image.js') }}"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="{{ asset('vendor/jquery-file-upload/js/jquery.fileupload-audio.js') }}"></script>
    <!-- The File Upload video preview plugin -->
    <script src="{{ asset('vendor/jquery-file-upload/js/jquery.fileupload-video.js') }}"></script>
    <!-- The File Upload validation plugin -->
    <script src="{{ asset('vendor/jquery-file-upload/js/jquery.fileupload-validate.js') }}"></script>
    <!-- The File Upload user interface plugin -->
    <script src="{{ asset('vendor/jquery-file-upload/js/jquery.fileupload-ui.js') }}"></script>

<script src="{{ asset('vendor/jquery-file-upload/js/cors/jquery.xdr-transport.js') }}"></script>
<![endif]-->

    <script>
        $(function () {
            'use strict';

            // Initialize the jQuery File Upload widget:
            $('#fileupload').fileupload({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                url: '{{route('admin.lecture-pages.import-save',['lecture'=>$lecture->id])}}',
                maxFileSize: 209715200,
                acceptFileTypes: /(\.|\/)(jpg|jpeg|png|gif)$/i
            });


        });

    </script>

@endsection
