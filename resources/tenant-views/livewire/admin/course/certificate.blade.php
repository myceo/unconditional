<div>

        <img  wire:loading class="float-right" src="{{ asset('img/ajax-loader.gif') }}">



      <ul class="nav nav-pills" id="myTab1" role="tablist">
                                              <li class="nav-item" wire:ignore>
                                                <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true">@lang('site.design')</a>
                                              </li>
                                              <li class="nav-item" wire:ignore>
                                                <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">@lang('site.settings')</a>
                                              </li>

                                            </ul>
                                            <div class="tab-content" id="myTabContent1">
                                              <div wire:ignore.self class="tab-pane fade show active pt-3" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                                  <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                      <i class="fa fa-cogs"></i>  {{ __('site.options') }}
                                                  </a>
                                                  <button type="button" id="save-button" class="btn btn-success float-right"><i class="fa fa-save"></i> @lang('site.save')</button>
                                                  @section('footer')
                                                      @parent
                                                      <script>
                                                          $(function(){
                                                              $('#save-button').on('click',function(){
                                                                  var html = $('#canvas').html();
                                                                  $('#certificate_html').val(html);
                                                                  $('#certificate-form').submit();

                                                              });
                                                          });
                                                      </script>
                                                  @endsection
                                                  <form method="post" id="certificate-form" action="{{ route('admin.courses.update-certificate',['course'=>$course->id]) }}">
                                                      @csrf
                                                      <input type="hidden" id="certificate_html" name="certificate_html">

                                                  </form>


                                                  <div class="collapse mt-1" id="collapseExample">
                                                      <div class="well">
                                                          @php $elements = [
                            'student_name','course_name','course_start_date','course_end_date','date_generated','company_name'
                        ];  @endphp

                                                          <div class="row">
                                                              @foreach($elements as $element)
                                                              <div class="col-md-2">
                                                                  <input class="item_control" checked type="checkbox" id="control_{{ $element}}" data-target="box_{{ $element}}" value="{{ $element}}" name="control_{{ $element}}"/> {{ ucfirst(str_replace('_',' ',$element)) }}
                                                              </div>

                                                              @endforeach
                                                          </div>




                                                          <div>
                                                              <hr class="mt-2 mb-2"/>
                                                              <h4 class="ml-3">{{ __('site.set-font-size') }}</h4>

                                                              <div class="row mb-2">
                                                                  <div class="col-md-4">
                                                                      <select class="form-control" name="element_selector" id="element_selector">
                                                                          <option value="">{{ __('site.select-an-element') }}</option>
                                                                          @foreach($elements as $element)
                                                                          <option value="{{ $element }}">{{ ucfirst(str_replace('_',' ',$element)) }}</option>
                                                                          @endforeach
                                                                      </select>
                                                                  </div>
                                                                  <div class="col-md-2">
                                                                      <input value="14" placeholder="e.g. 14" type="number" name="font_size" id="font_size" class="form-control number"/>
                                                                  </div>


                                                              </div>

                                                          </div>
                                                      </div>
                                                  </div>

                                                  <div id="canvas_wrapper" style="overflow: auto" class="mt-2">

                                                      <div id="canvas" style="border:  solid 1px #CCCCCC; font-size: 14px; margin:0px auto; position: relative; width: {{ $width }}px; height: {{ $height }}px; overflow: hidden; @if(!empty($course->certificate_image)) background: url({{ asset($course->certificate_image) }});   background-repeat: no-repeat;  background-position: center;   background-size: cover;  @endif " >
                                                      @if(empty($course->certificate_html))

                                                          <div class="canvas_item" id="box_student_name" style=" position: absolute; top: 20px; left: 20px; width: 20px; height: 20px; white-space: nowrap;" >
                                                              [STUDENT_NAME]
                                                          </div>

                                                          <div class="canvas_item" id="box_course_name" style=" position: absolute; top: 50px; left: 20px; width: 20px; height: 20px; white-space: nowrap;" >
                                                              [COURSE_NAME]
                                                          </div>

                                                          <div class="canvas_item" id="box_course_start_date" style=" position: absolute; top: 80px; left: 20px; width: 20px; height: 20px; white-space: nowrap;" >
                                                              [COURSE_START_DATE]
                                                          </div>

                                                          <div class="canvas_item" id="box_course_end_date" style=" position: absolute; top: 110px; left: 20px; width: 20px; height: 20px; white-space: nowrap;" >
                                                              [COURSE_END_DATE]
                                                          </div>

                                                          <div class="canvas_item" id="box_date_generated" style=" position: absolute; top: 140px; left: 20px; width: 20px; height: 20px; white-space: nowrap;" >
                                                              [DATE_GENERATED]
                                                          </div>

                                                          <div class="canvas_item" id="box_company_name" style=" position: absolute; top: 170px; left: 20px; width: 20px; height: 20px; white-space: nowrap;" >
                                                              [COMPANY_NAME]
                                                          </div>
                                                      @else
                                                          {!! $course->certificate_html !!}
                                                      @endif


                                                      </div>



                                                  </div>


                                              </div>
                                              <div wire:ignore.self class="tab-pane fade pt-3" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                                  <form action="{{ route('admin.courses.update-certificate',['course'=>$course->id]) }}" method="post" enctype="multipart/form-data">
                                                      @csrf



                                                      <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="file">@lang('site.image')</label>
                                                            <input type="file" class="form-control-file"
                                                                   name="file" id="file"
                                                                   placeholder="@lang('site.select-image')"
                                                                   aria-describedby="fileHelpId">

                                                            <small id="fileHelpId" class="form-text text-muted">@lang('site.certificate-image-hint')</small>
                                                        </div>



                                                    </div>
                                                    @if(!empty($course->certificate_image))
                                                    <div class="col-md-6">
                                                            <img src="{{ asset($course->certificate_image) }}" class="img-fluid">
                                                            <br>
                                                        <br>
                                                        <a class="btn btn-danger" onclick="return confirm('@lang('site.delete-prompt')')" href="{{ route('admin.courses.certificate-image',['course'=>$course->id]) }}"><i class="fa fa-trash"></i> @lang('site.delete')</a>
                                                    </div>
                                                    @endif

                                                     </div>
                                                      <div class="row mt-4">
                                                      <div class="col-md-6">
                                                          <div class="form-group">
                                                              <label for="enabled">@lang('site.status')</label>
                                                              <select class="form-control" name="certificate_enabled" id="certificate_enabled">
                                                                  @foreach(['1'=>__('site.enabled'),'0'=>__('site.disabled')] as $key=>$value)
                                                                      <option @if($key==old('certificate_enabled',$course->certificate_enabled)) selected @endif value="{{ $key }}">{{ $value }}</option>
                                                                  @endforeach
                                                              </select>
                                                          </div>
                                                      </div>
                                                      <div class="col-md-6">

                                                          <div class="form-group">
                                                              <label for="enabled">@lang('site.orientation')</label>
                                                              <select class="form-control" name="certificate_orientation" id="certificate_orientation">
                                                                  @foreach(['p'=>__('site.portrait'),'l'=>__('site.landscape')] as $key=>$value)
                                                                      <option @if($key==old('certificate_orientation',$course->certificate_orientation)) selected @endif value="{{ $key }}">{{ $value }}</option>
                                                                  @endforeach
                                                              </select>
                                                          </div>

                                                      </div>
                                                  </div>
                                                      <button class="btn btn-success btn-block  " type="submit"><i class="fa fa-save"></i> @lang('site.save')</button>


                                                  </form>
                                              </div>

                                            </div>
</div>

@section('header')
    @parent
    <style>
        .canvas_item{
            cursor: move;
        }
    </style>

@endsection


@section('footer')
    @parent
    <script>
        $('#font_size').change(function(){
            console.log('buttoncliced');
            //get the selected element
            var element =  $('#element_selector').val();
            var size= $('#font_size').val();
            if(element.length==0 || size.length==0){
                alert('Please select an element and enter a font size');
            }
            else{
                $('#box_'+element).css('font-size',size+'px');
                console.log('size set');
            }

        });
        $('#element_selector').change(function(){
            var val= $(this).val();
            if(val.length>0){
                var size = $('#box_'+val).css('font-size');
                size = parseInt(size);
                if(size < 1 ){
                    size =14;
                }
                $('#font_size').val(parseInt(size));
            }
        });

        $('.item_control').click(function(){
            console.log($(this).attr('data-target'));
            $('#'+$(this).attr('data-target')).toggle(this.checked);
        });

        $('.canvas_item').each(function(){
            var isVisible = $(this).is(':visible');
            $('input[data-target='+$(this).attr('id')+']').prop('checked',isVisible);

        })

        $(function(){
            $( ".canvas_item" ).draggable({
                containment: "parent"
            });
        });
    </script>
@endsection
