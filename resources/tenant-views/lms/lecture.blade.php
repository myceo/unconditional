@extends('lms.course-layout')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('site.my-courses') }}">@lang('site.my-courses')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('lms.landing',['course'=>$course->id]) }}">@lang('site.introduction')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('lms.lesson',['course'=>$course->id,'lesson'=>$lecture->lesson_id]) }}">@lang('site.class')</a></li>
    <li class="breadcrumb-item">@lang('site.lecture')</li>
@endsection
@section('page-title',limitLength($lecture->title,55))
@section('page-subtile',limitLength($lecture->lesson->name,55))

@section('content')
   <ul   class="nav nav-pills border-0 " id="myTab1" role="tablist">
                                           <li class="nav-item">
                                             <a class="nav-link active border-0" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true"><i
                                                     class="fa fa-desktop"
                                                     aria-hidden="true"></i> @lang('site.lecture')</a>
                                           </li>
                                           <li class="nav-item">
                                             <a class="nav-link border-0" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false"><i
                                                     class="fa fa-download" aria-hidden="true"></i> @lang('site.resources')</a>
                                           </li>
                                           <li class="nav-item">
                                             <a class="nav-link border-0" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false"><i
                                                     class="fa fa-list" aria-hidden="true"></i> @lang('site.class-index')</a>
                                           </li>
                                         </ul>
                                         <div class="tab-content border-0 p-0 pt-2" id="myTabContent1">
                                           <div class="tab-pane fade show active border-0" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                               <!-- Nav tabs -->
                                               <ul class="nav nav-tabs scroll-tab button-tab2" role="tablist">

                                                   @foreach($lecture->lecturePages()->ordered()->get() as $page)
                                                       <li class="nav-item"><a  class="nav-link @if($loop->first) active @endif lecture-tabs"  id="tablink{{  $page->id  }}" href="#pagetab{{  $page->id  }}" role="tab" data-toggle="tab"><i class="fa fa-@php  switch($page->type){

                                                                case 'v':
                                                                    echo 'file-video';
                                                                    break;
                                                                case 't':
                                                                    echo 'book-open';
                                                                    break;
                                                                case 'i':
                                                                    echo 'image';
                                                                    break;
                                                                case 'q':
                                                                    echo 'question-circle';
                                                                    break;
                                                                case 'z':
                                                                    echo 'video';
                                                                    break;
                                                            }  @endphp"></i>  {{  $page->title }}</a></li>


                                                   @endforeach

                                               </ul>

                                               <!-- Tab panes -->
                                               <div class="tab-content gallery pl-0 pr-0 pt-2 border-0">

                                                   @foreach($lecture->lecturePages()->ordered()->get() as $page)
                                                   <div  class="tab-pane  fade show  @if($loop->first) active @endif" id="pagetab{{  $page->id  }}">
                                                       <div class="card" >
                                                           <div class="card-body">
                                                               <div>
                                                                   @if($page->type=='v')
                                                                      <div class="embed-responsive embed-responsive-16by9">
                                                                          {!! $page->content !!}
                                                                      </div>
                                                                   @elseif($page->type=='i')
                                                                   <div  class="text-center"><a data-img-url="{{ $page->content }}" class="fullsizable" href="#"><img class="gallery-item img-fluid" data-image="{{ asset($page->content) }}" data-title="{{ $page->title }}"   src="{{ asset($page->content) }}" /></a>
                                                                       <div><small>{{  __('site.click-to-enlarge')  }}</small></div>
                                                                   </div>
                                                                   @elseif($page->type=='q')
                                                                   <div class="quizbox " id="quiz{{ $page->id }}">
                                                                       <h1 class="quizName"><!-- where the quiz name goes --></h1>

                                                                       <div class="quizArea">
                                                                           <div class="quizHeader">
                                                                               <a class="button startQuiz" href="#">{{  __('site.get-started')  }}</a>
                                                                           </div>
                                                                       </div>

                                                                       <div class="quizResults">
                                                                           <h3 class="quizScore">{{  __('site.you-scored')  }}: <span><!-- where the quiz score goes --></span></h3>

                                                                           <h3 class="quizLevel"><strong>{{  __('site.ranking')  }}:</strong> <span><!-- where the quiz ranking level goes --></span></h3>

                                                                           <div class="quizResultsCopy">
                                                                               <!-- where the quiz result copy goes -->
                                                                           </div>
                                                                       </div>
                                                                   </div>
                                                                       @section('footer')
                                                                           @parent
                                                                       <script>
                                                                           $(function(){
                                                                               $('#quiz{{ $page->id }}').slickQuiz({!! $page->content  !!});
                                                                           })
                                                                       </script>
                                                                       @endsection
                                                                   @elseif($page->type=='z')
                                                                       @php
                                                                           $zoomData = @unserialize($page->content);
                                                                       @endphp
                                                                       @if($zoomData && is_array($zoomData))
                                                                           <div class="alert alert-success" role="alert">
                                                                               <strong>{{  __('site.meeting-id')  }}</strong>: {{ trim($zoomData['meeting_id']) }}
                                                                               <br/>
                                                                               <strong>{{  __('site.password')  }}</strong>: {{ trim($zoomData['password']) }}
                                                                               <br/>
                                                                               {{ nl2br($zoomData['instructions']) }}</div>
                                                                           <div class="text-center">
                                                                               <a href="#" onclick="startMeeting('{{ trim($zoomData['meeting_id']) }}','{{ trim($zoomData['password']) }}','{{ generateSignatureZoom(setting('zoom_key'), setting('zoom_secret'), trim($zoomData['meeting_id']), 0) }}')" class="btn btn-primary btn-lg"><i class="fa fa-video"></i> @lang('site.join-meeting')</a>
                                                                           </div>
                                                                       @endif

                                                                   @else
                                                                   {!! $page->content !!}
                                                                   @endif
                                                               </div>



                                                           </div>
                                                       </div>


                                                           <form action="{{ route('lms.log-lecture',['course'=>$course->id,'lecture'=>$lecture->id]) }}" method="post">
                                                               @csrf
                                                               <div class="mt-5" style=" clear: both;" >
                                                                   @if($loop->first)
                                                                       @if($previous)
                                                                       <a  style="margin-bottom: 20px"  class="btn btn-primary btn-lg" href="{{  route('lms.lecture',['course'=>$course->id,'lecture'=>$previous->id])  }}"><i class="fa fa-chevron-left"></i> {{  __('site.previous-lecture')  }}</a>
                                                                       @elseif($previousLesson)
                                                                       <a  style="margin-bottom: 20px"  class="btn btn-primary btn-lg" href="{{  route('lms.lesson',['course'=>$course->id,'lesson'=>$previousLesson->id])  }}"><i class="fa fa-chevron-left"></i> {{  __('site.previous-class')  }}</a>
                                                                       @else
                                                                       <a  style="margin-bottom: 20px"  class="btn btn-primary btn-lg" href="{{  route('lms.lesson',['course'=>$course->id,'lesson'=>$lecture->lesson_id])  }}"><i class="fa fa-chevron-left"></i> {{  __('site.class-details')  }}</a>
                                                                       @endif
                                                                   @endif


                                                                   @php  $previousPage = $page->getPrevious();   @endphp
                                                                   @if($previousPage)
                                                                   <button type="button" style="margin-bottom: 20px" data-page="{{  $previousPage->id  }}" class="btn btn-primary btn-lg prevButton prevbtn"><i class="fa fa-chevron-left"></i> {{  __('site.previous')  }}</button>
                                                                   @endif



                                                                   @php  $nextPage = $page->getNext(); @endphp
                                                                   @if($nextPage)


                                                                   <button type="button" data-page="{{  $nextPage->id  }}" class="btn btn-primary btn-lg prevButton float-right nextbtn">{{  __('site.next')  }} <i class="fa fa-chevron-right"></i></button>

                                                                   @else

                                                                   <input type="hidden" name="course_id" value="{{  $course->id }}"/>
                                                                   <input type="hidden" name="lecture_id" value="{{  $lecture->id  }}"/>
                                                                   <button class="btn btn-success btn-lg float-right" type="submit"><i class="fa fa-check-circle"></i> {{  __('site.complete-lecture')  }}</button>
                                                                   <p style="clear: both" class="text-right">
                                                                       {{  __('site.complete-lecture-note')  }}
                                                                   </p>

                                                                   @endif
                                                               </div>
                                                           </form>


                                                   </div>
                                                   @endforeach
                                               </div>
                                           </div>
                                           <div class="tab-pane fade pt-3" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                            <div class="card">

                                            <div class="card-body">

                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>@lang('site.file')</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($lecture->lectureFiles as $file)
                                                    <tr>
                                                        <td scope="row">{{ $file->name }}</td>
                                                        <td>@livewire('utils.download-button',['filePath'=>$file->path,'fileName'=>$file->name])</td>
                                                    </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>

                                            </div>
                                            </div>
                                           </div>
                                           <div class="tab-pane fade pt-3" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                               @foreach($lecture->lesson->lectures()->ordered()->get() as $lecture)

                                                   <div class="list-group mb-3">
                                                       <a href="{{ route('lms.lecture',['course'=>$course->id,'lecture'=>$lecture->id]) }}" class="list-group-item active text-decoration-none">{{ $lecture->title }} <span class="float-right text-white"><i class="fa fa-play-circle"></i></span></a>
                                                       @foreach($lecture->lecturePages()->ordered()->get() as $lecturePage)
                                                           <div class="list-group-item pl-5">{{$lecturePage->title}}           <span class="badge badge-pill badge-primary float-right">

                                                               @php
                                                                   switch($lecturePage->type){
                                                                       case 't':
                                                                           echo __('site.text');
                                                                       break;
                                                                       case 'v':
                                                                           echo  __('site.video');
                                                                       break;
                                                                       case 'c':
                                                                           echo __('site.html-code');
                                                                       break;
                                                                       case 'i':
                                                                           echo __('site.image');
                                                                           break;
                                                                       case 'q':
                                                                           echo __('site.quiz');
                                                                           break;
                                                                       case 'l':
                                                                           echo __('site.video');
                                                                           break;
                                                                       case 'z':
                                                                           echo __('site.zoom-meeting');
                                                                           break;
                                                                   } @endphp
                                                           </span></div>
                                                       @endforeach

                                                   </div>



                                               @endforeach
                                           </div>
                                         </div>
@endsection


@section('header')
    @livewireStyles
    @if($zoom)
    <link rel="stylesheet" href="{{ asset('vendor/izitoast/css/iziToast.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('vendor/scrolltabs/jquery.scrolling-tabs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/jquery-fullsizable-2.1.0/css/jquery-fullsizable.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/jquery-fullsizable-2.1.0/css/jquery-fullsizable-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/slickquiz/css/slickQuiz.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/slickquiz/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/chocolat/dist/css/chocolat.css') }}">

    <style>
       body.skydash div.main-panel .footer {
            background: #F5F7FF;
            padding: 30px 2.45rem;
            transition: all 0.25s ease;
            -moz-transition: all 0.25s ease;
            -webkit-transition: all 0.25s ease;
            -ms-transition: all 0.25s ease;
            font-size: calc(0.875rem - 0.05rem);
            font-family: "Nunito", sans-serif;
            font-weight: 400;
            border-top: 1px solid rgba(0, 0, 0, 0.06);
            position: static;
        }
       .sidebar .nav.sub-menu .nav-item {
          position: relative;
       }

    </style>

@endsection

@section('footer')
    @livewireScripts
    <script src="{{  asset('vendor/scrolltabs/jquery.scrolling-tabs.min.js') }}"></script>
    <script src="{{  asset('vendor/jquery-fullsizable-2.1.0/js/jquery-fullsizable.js') }}"></script>
    <script src="{{  asset('vendor/slickquiz/js/slickQuiz.js') }}"></script>
    <script src="{{ asset('vendor/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('vendor/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script>
        function scrollTo(element){
            $('html, body').animate({
                scrollTop: ($(element).offset().top)
            },500);
        }
        function initTab(){
            $('.scroll-tab').scrollingTabs({enableSwiping: true, bootstrapVersion: 4,  cssClassLeftArrow: 'fa fa-chevron-left',
                cssClassRightArrow: 'fa fa-chevron-right' });
        }

        $(document).on('shown.bs.tab', 'a.top-nav', function (e) {
            console.log('clicked');
            $('.scrtabs-tab-scroll-arrow').trigger('click');
        })

        $('#myTab1').scrollingTabs();

        initTab();

        $('.prevButton').click(function(e){
            e.preventDefault();
            console.log('clicked btn');
            var page = $(this).attr('data-page');
            console.log('Page is: '+page);
            $('#tablink'+page).tab('show');
            $('.scroll-tab').scrollingTabs('scrollToActiveTab');
            scrollTo('#myTab1');
        });

        //attach event handlers

        $(document).on('click','.chocolat-right',function(){
            console.log('clicked');
            $('#myTabContent2 div.tab-content > div.active .nextbtn:first').trigger('click');
        });

        $(document).on('click','.chocolat-left',function(){
            console.log('clicked');
            $('#myTabContent2 div.tab-content > div.active .prevbtn:first').trigger('click');
        });

        document.addEventListener("next_image", function(e) {
            console.log(e.detail);
            $('#myTabContent2 div.tab-content > div.active .nextbtn:first').trigger('click');
        });

        document.addEventListener("prev_image", function(e) {
            console.log(e.detail);
            $('#myTabContent2 div.tab-content > div.active .prevbtn:first').trigger('click');
        });

        //handing next scrolling
        $('a.fsnext').click(function(e){
            console.log('next clicked');
        });

        $('a.fsprev').click(function(){
            console.log('prev clicked');
        });

        @if(isset($_GET['page']))
        $(function(){
            $('#tablink'+{{  $_GET['page']  }}).tab('show');
            $('.scroll-tab').scrollingTabs('scrollToActiveTab');
        });
        @endif

        $(function(){

            // Gallery
            $(".gallery .gallery-item").each(function() {
                var me = $(this);

                me.attr('href', me.data('image'));
                me.attr('title', me.data('title'));
                if(me.parent().hasClass('gallery-fw')) {
                    me.css({
                        height: me.parent().data('item-height'),
                    });
                    me.find('div').css({
                        lineHeight: me.parent().data('item-height') + 'px'
                    });
                }
                me.css({
                    backgroundImage: 'url("'+ me.data('image') +'")'
                });
            });

            if(jQuery().Chocolat) {
                $(".gallery").Chocolat({
                    className: 'gallery',
                    imageSelector: '.gallery-item',
                });
            }

            // Background
            $("[data-background]").each(function() {
                var me = $(this);
                me.css({
                    backgroundImage: 'url(' + me.data('background') + ')'
                });
            });

            // Custom Tab
            $("[data-tab]").each(function() {
                var me = $(this);

                me.click(function() {
                    if(!me.hasClass('active')) {
                        var tab_group = $('[data-tab-group="' + me.data('tab') + '"]'),
                            tab_group_active = $('[data-tab-group="' + me.data('tab') + '"].active'),
                            target = $(me.attr('href')),
                            links = $('[data-tab="'+me.data('tab') +'"]');

                        links.removeClass('active');
                        me.addClass('active');
                        target.addClass('active');
                        tab_group_active.removeClass('active');
                    }
                    return false;
                });
            });

            // Bootstrap 4 Validation
            $(".needs-validation").submit(function() {
                var form = $(this);
                if (form[0].checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.addClass('was-validated');
            });

            // alert dismissible
            $(".alert-dismissible").each(function() {
                var me = $(this);

                me.find('.close').click(function() {
                    me.alert('close');
                });
            });

            if($('.main-navbar').length) {
            }

            // Image cropper
            $('[data-crop-image]').each(function(e) {
                $(this).css({
                    overflow: 'hidden',
                    position: 'relative',
                    height: $(this).data('crop-image')
                });
            });

            // Slide Toggle
            $('[data-toggle-slide]').click(function() {
                let target = $(this).data('toggle-slide');

                $(target).slideToggle();
                return false;
            });

            // Dismiss modal
            $("[data-dismiss=modal]").click(function() {
                $(this).closest('.modal').modal('hide');

                return false;
            });

            // Width attribute
            $('[data-width]').each(function() {
                $(this).css({
                    width: $(this).data('width')
                });
            });

            // Height attribute
            $('[data-height]').each(function() {
                $(this).css({
                    height: $(this).data('height')
                });
            });

            // Chocolat
            if($('.chocolat-parent').length && jQuery().Chocolat) {
                $('.chocolat-parent').Chocolat();
            }
        });

    </script>
    @if ($zoom)

        <script src="{{ asset('vendor/izitoast/js/iziToast.min.js') }}" type="text/javascript"></script>

        <div class="modal fade modal-fullscreen" id="zoomModal" tabindex="-1" role="dialog" aria-labelledby="zoomModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="zoomModalLabel">@lang('site.zoom-meeting')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="zmmtg-root"></div>
                        <div id="aria-notify-area"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('site.close')</button>

                    </div>
                </div>
            </div>
        </div>

        <script src="https://source.zoom.us/2.9.5/lib/vendor/react.min.js"></script>

        <script src="https://source.zoom.us/2.9.5/lib/vendor/react-dom.min.js"></script>

        <script src="https://source.zoom.us/2.9.5/lib/vendor/redux.min.js"></script>

        <script src="https://source.zoom.us/2.9.5/lib/vendor/redux-thunk.min.js"></script>

        <script src="https://source.zoom.us/2.9.5/lib/vendor/lodash.min.js"></script>

        <script src="https://source.zoom.us/zoom-meeting-2.9.5.min.js"></script>

        <script src="{{  asset('js/zoom.js') }}"></script>

        <script>
            @php
            $langList = [
                'en'=>'en-US',
                'de'=>'de-DE',
                'es'=>'es-ES',
                'fr'=>'fr-FR',
                'jp'=>'jp-JP',
                'pt'=>'pt-PT',
                'ru'=>'ru-RU',
                'zh'=>'zh-CN',
                'ko'=>'ko-KO',
                'it'=>'it-IT',
                'vi'=>'vi-VN'
            ];
            //get current lang
            $lang = setting('config_language');
            if(empty($lang)){
                $lang = 'en';
            }

           @endphp

            function startMeeting(meetingId,password,signature){

                $('#zoomModal').modal();

                ZoomMtg.init({
                    leaveUrl: '{{ selfUrl() }}',
                    isSupportAV: true,
                    success: function() {
                        @if(isset($langList[$lang]))
                        ZoomMtg.i18n.load("{{ $langList[$lang] }}");
                        ZoomMtg.reRender({lang: "{{ $langList[$lang] }}"});
                        @endif

                        ZoomMtg.join({
                            signature: signature,
                            meetingNumber: meetingId,
                            userName: '{{ addslashes(Auth()->user()->name) }}',
                            sdkKey: '{{ setting('zoom_key') }}',
                            userEmail: '{{  addslashes(Auth()->user()->email) }}',
                            passWord: password,
                            success: (success) => {
                                console.log(success)
                            },
                            error: (error) => {
                                console.log(error);
                                if(error.result){
                                    iziToast.error({
                                        title: '@lang('site.error')',
                                        message: error.result
                                    });
                                }
                                // alert(error.result);
                            }
                        })
                    }
                });



            }
            $("body").css({
                "min-width": "400px",
                "overflow": "auto",

            });
            $("html").css({
                "min-width": "400px",
                "overflow": "auto",
            });
        </script>



    @endif



@endsection
