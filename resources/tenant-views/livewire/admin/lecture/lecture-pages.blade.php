<div>

                <div class="dropdown d-inline mr-2">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-plus"></i>  <span class="contentmode">{{ __('site.add') }}</span> {{ __('site.lecture-content') }} <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu  wide-btn">
                        <li><a  class="dropdown-item show-modal" data-toggle="modal" data-target="#addText" href="#"><span class="title"><i class="fa fa-file-word"></i> {{ __('site.text') }}</span></a></li>
                        <li><a class="dropdown-item show-modal" data-type="v" data-toggle="modal"  data-target="#addvurl" href="#"><span class="title"><i class="fa fa-file-video"></i> {{ __('site.video') }}</span></a></li>
                        <li><a class="dropdown-item show-modal" data-type="i" data-toggle="modal"   data-target="#addi" href="#"><span class="title"><i class="fa fa-image"></i> {{ __('site.image') }}</span></a></li>
                        <li><a class="dropdown-item show-modal" data-type="q" data-toggle="modal"   data-target="#addq" href="#"><span class="title"><i class="fa fa-question-circle"></i> {{ __('site.quiz') }}</span></a></li>
                        <li><a class="dropdown-item show-modal-nc" data-type="z" data-toggle="modal"   data-target="#addz" href="#"><span class="title"><i class="fa fa-video"></i> {{ __('site.zoom-meeting') }}</span></a></li>
                        <li role="separator" class="divider dropdown-divider"></li>
                        <li><a class="dropdown-item "  href="{{ route('admin.lecture-pages.import',['lecture'=>$lectureId]) }}"><span class="title"><i class="fa fa-image"></i> {{ __('site.import-images') }}</span></a></li>
                    </ul>
                </div>


                <span class="float-right">
                       <span wire:loading>
                    <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </span>
                    <small>@lang('site.drag-message')</small></span>


                <br/>
                <br/>
                <div class="table-responsive">
                    <form id="msg-list"   action="{{ route('admin.lecture-pages.delete-multiple') }}" method="post">
                        @csrf
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                <div class="btn-toolbar float-left" role="toolbar"   >

                                    <div class="btn-group" role="group" aria-label="First group">
                                        <button  type="button" class="check btn btn-success btn-sm"><i class="fa fa-check"></i></button>
                                        <button onclick="return confirm('@lang('site.delete-prompt')')" title="@lang('site.delete')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </div>

                                </div>

                            </th>
                            <th colspan="2" >
                                @lang('site.title')</th><th>@lang('site.type')</th><th>@lang('site.actions')</th>
                        </tr>
                        </thead>
                        <tbody  wire:sortable="updateTaskOrder">
                        @foreach($lecturepages as $item)
                            <tr  wire:sortable.item="{{ $item->id }}" wire:key="task-{{ $item->id }}" >
                                <td class="text-center"><input name="{{ $item->id }}" value="{{ $item->id }}" type="checkbox" class="int_ml0"  ></td>
                                <td class="draggable"   wire:sortable.handle ><i class="fa fa-grip-vertical"></i></td>
                                <td  >{{ $item->title }}</td>
                                <td>@php
                                        switch($item->type){
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
                                        } @endphp</td>
                                <td>

                                    <button type="button" data-toggle="modal"
                                            data-target="#viewContent{{ $item->id }}" class="btn btn-sm btn-icon btn-success" title="@lang('site.view')"><i class="fa fa-eye"></i></button>
                                    @if($item->type=='q')
                                        <a href="{{ route('admin.lecture.edit-quiz',['lecturePage'=>$item->id]) }}" class="btn btn-sm btn-icon btn-primary" title="@lang('site.edit')"><i class="fa fa-edit"></i></a>
                                    @elseif($item->type=='t')
                                        <a href="#"  data-toggle="modal"
                                           data-target="#editModal{{ $item->id }}"  class="btn btn-sm btn-icon btn-primary" title="@lang('site.edit')"><i class="fa fa-edit"></i></a>
                                        @section('footer')
                                            @parent
                                        <!-- Modal -->
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                             role="dialog"
                                             aria-labelledby="editModalTitle{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <form method="post" action="{{ route('admin.lectures.lecture-pages.update',['lecture'=>$item->lecture_id,'lecture_page'=>$item->id]) }}">
                                                    @csrf
                                                    @method('patch')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ $item->title }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="title">@lang('site.title')</label>
                                                            <input value="{{ $item->title }}" required type="text"
                                                                   class="form-control" name="title" id="title{{ $item->id }}" aria-describedby="titleId"
                                                                   placeholder="@lang('site.title')">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="text">@lang('site.text')</label>
                                                            <textarea class="form-control rte" name="content" id="text{{ $item }}" rows="5">{{ $item->content }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">@lang('site.close')
                                                        </button>
                                                        <button type="submit"
                                                                class="btn btn-primary">@lang('site.save')</button>
                                                    </div>
                                                </div>
                                                 </form>
                                            </div>
                                        </div>
                                    @endsection
                                    @elseif($item->type=='z')
                                        <a href="#"  data-toggle="modal"   data-target="#editModal{{ $item->id }}"  class="btn btn-sm btn-icon btn-primary" title="@lang('site.edit')"><i class="fa fa-edit"></i></a>
                                    @section('footer')
                                        @parent
                                        @php
                                            $zoomData = @unserialize($item->content);
                                        @endphp
                                    <!-- Modal -->
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                             role="dialog"
                                             aria-labelledby="editModalTitle{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <form method="post" action="{{ route('admin.lectures.lecture-pages.update',['lecture'=>$item->lecture_id,'lecture_page'=>$item->id]) }}">
                                                    @csrf
                                                    @method('patch')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ $item->title }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">



                                                            <div class="form-group">
                                                                <label for="">{{ __('site.title') }}</label>
                                                                <input name="title" class="form-control"    required="required" value="{{ $item->title }}" type="text">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">{{ __('site.meeting-id') }}</label>
                                                                <input required="required" class="form-control" type="text" value="{{ @$zoomData['meeting_id'] }}" name="meeting_id" placeholder="{{ __('site.zoom-placeholder') }}"/>

                                                            </div>


                                                            <div class="form-group">
                                                                <label for="">{{ __('site.meeting-password') }}</label>
                                                                <input required="required" class="form-control" type="text" value="{{@$zoomData['password']}}" name="password" />

                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{ __('site.instructions') }} ({{ __('admin.optional') }})</label>
                                                                <textarea class="form-control" name="instructions"  >{{@$zoomData['instructions']}}</textarea>

                                                            </div>



                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">@lang('site.close')
                                                            </button>
                                                            <button type="submit"
                                                                    class="btn btn-primary">@lang('site.save')</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endsection

                                    @elseif($item->type=='i')
                                        <a href="#" data-toggle="modal" data-target="#editModal{{ $item->id }}" class="btn btn-sm btn-icon btn-primary" title="@lang('site.edit')"><i class="fa fa-edit"></i></a>
                                        @section('footer')
                                            @parent
                                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog " role="document">
                                                    <div class="modal-content">
                                                        <form method="post" enctype="multipart/form-data" class="form" action="{{ route('admin.lectures.lecture-pages.update',['lecture'=>$lecture->id,'lecture_page'=>$item->id]) }}">
                                                            @csrf
                                                            @method('patch')
                                                            <input type="hidden" name="id" value="0"/>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><span class="contentmode">{{ __('site.edit') }}</span> {{ __('site.lecture-content') }} ({{ __('site.image') }})</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="">{{ __('site.title') }}</label>
                                                                    <input  name="title" class="form-control" id="imagetitle{{ $item->id }}" required="required" value="{{ $item->title }}" type="text">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <img src="{{ asset($item->content) }}" alt="{{ $item->title }}" class="img-fluid">
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                            @lang('site.change')
                                                                            <div class="form-group">
                                                                                <label for="picture">@lang('site.image')</label>
                                                                                <input   type="file" class="form-control-file" name="picture" id="picture{{ $item->id }}"
                                                                                       placeholder="@lang('site.file')"
                                                                                       aria-describedby="pictureId">
                                                                                <small id="pictureId" class="form-text text-muted">@lang('site.select-image')</small>
                                                                            </div>


                                                                    </div>

                                                                </div>






                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('site.close') }}</button>
                                                                <button type="submit" class="btn btn-primary">{{ __('site.save-changes') }}</button>
                                                            </div>
                                                        </form>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        @endsection
                                    @elseif($item->type=='v')
                                        <a href="#" data-toggle="modal" data-target="#editModal{{ $item->id }}"  class="btn btn-sm btn-icon btn-primary" title="@lang('site.edit')"><i class="fa fa-edit"></i></a>
                                    @section('footer')
                                        @parent
                                    <!-- Modal -->
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                             role="dialog"
                                             aria-labelledby="editModalTitle{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <form method="post" action="{{ route('admin.lectures.lecture-pages.update',['lecture'=>$item->lecture_id,'lecture_page'=>$item->id]) }}">
                                                    @csrf
                                                    @method('patch')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ $item->title }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="title">@lang('site.title')</label>
                                                                <input value="{{ $item->title }}" required type="text"
                                                                       class="form-control" name="title" id="title{{ $item->id }}" aria-describedby="titleId"
                                                                       placeholder="@lang('site.title')">
                                                            </div>

                                                            <div class="embed-responsive embed-responsive-16by9">
                                                                {!! $item->content !!}
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">@lang('site.close')
                                                            </button>
                                                            <button type="submit"
                                                                    class="btn btn-primary">@lang('site.save')</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endsection

                                    @endif



                                   <button type="button" onclick="confirm('@lang('site.confirm-delete')') || event.stopImmediatePropagation()"  wire:click="delete({{ $item->id }})" class="btn btn-sm btn-icon btn-danger" title="@lang('site.delete')"><i class="fa fa-trash"></i></button>



                                    <!-- Modal -->
                                    <div class="modal fade" id="viewContent{{ $item->id }}" tabindex="-1" role="dialog"
                                         aria-labelledby="viewContentTitle{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-{{ $item->type=='t'?'xl':'lg' }}" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $item->title }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    @if($item->type=='i')
                                                        <img src="{{ asset($item->content) }}" class="img-fluid">
                                                    @elseif($item->type=='v')
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                             {!! $item->content !!}
                                                        </div>
                                                    @elseif($item->type=='q')
                                                        <div class="quizbox " id="quiz{{$item->id}}">
                                                            <h1 class="quizName"><!-- where the quiz name goes --></h1>

                                                            <div class="quizArea">
                                                                <div class="quizHeader">
                                                                    <!-- where the quiz main copy goes -->

                                                                    <a class="button startQuiz" href="#">{{ __('site.get-started') }}!</a>
                                                                </div>

                                                                <!-- where the quiz gets built -->
                                                            </div>

                                                            <div class="quizResults">
                                                                <h3 class="quizScore">{{ __('site.you-scored') }}: <span><!-- where the quiz score goes --></span></h3>

                                                                <h3 class="quizLevel"><strong>{{ __('site.ranking') }}:</strong> <span><!-- where the quiz ranking level goes --></span></h3>

                                                                <div class="quizResultsCopy">
                                                                    <!-- where the quiz result copy goes -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @section('footer')
                                                        @parent
                                                        <script>
                                                            $(function(){
                                                                $('#quiz{{$item->id}}').slickQuiz({!! $item->content !!});
                                                            })
                                                        </script>
                                                        @endsection
                                                    @elseif($item->type=='z')
                                                        @php
                                                            $zoomData = @unserialize($item->content);
                                                        @endphp
                                                        @if($zoomData && is_array($zoomData))
                                                            <div class="list-group">
                                                                <a href="#" class="list-group-item active">
                                                                    {{ __('site.meeting-id') }}
                                                                </a>
                                                                <a href="#" class="list-group-item">{{$zoomData['meeting_id']}}</a>
                                                                <a href="#" class="list-group-item active">
                                                                    {{ __('site.meeting-password') }}
                                                                </a>
                                                                <a href="#" class="list-group-item">{{$zoomData['password']}}</a>
                                                                <a href="#" class="list-group-item active">
                                                                    {{ __('site.instructions') }}
                                                                </a>
                                                                <a href="#" class="list-group-item">{{$zoomData['instructions']}}</a>

                                                            </div>
                                                        @endif


                                                    @else
                                                        {!! $item->content !!}
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                            data-dismiss="modal">@lang('site.close')
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </form>
                </div>






<!-- Modal -->
<div class="modal fade" id="addText" tabindex="-1" role="dialog" aria-labelledby="addText" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('admin.lectures.lecture-pages.store',['lecture'=>$lecture->id]) }}" method="post">
            @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('site.add-text')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="title">@lang('site.title')</label>
                    <input required type="text"
                           class="form-control" name="title" id="title" aria-describedby="titleId"
                           placeholder="@lang('site.title')">
                </div>

                <div class="form-group">
                    <label for="text">@lang('site.text')</label>
                    <textarea class="form-control rte" name="content" id="text" rows="5"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                 <button type="submit" class="btn btn-primary">@lang('site.save')</button>
            </div>
        </div>
            <input type="hidden" name="type" value="t">
        </form>
    </div>
</div>

<div class="modal fade" id="addvurl" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <form method="post" class="form" action="{{ route('admin.lectures.lecture-pages.store',['lecture'=>$lecture->id]) }}">
                @csrf    <input type="hidden" name="type" value="v"/>
                <div class="modal-header">
                    <h5 class="modal-title"><span class="contentmode">{{ __('site.add') }}</span> {{ __('site.lecture-content') }} ({{ __('site.video') }})</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">{{ __('site.video-url') }}</label>
                        <input class="form-control" type="text" name="url" placeholder="Video Url"/>
                        <p class="help-block" >
                        {{ __('site.video-field-desc') }}
                        <ul>
                            <li>Youtube ({{ __('site.example') }}: https://www.youtube.com/watch?v=MG8KADiRbOU)</li>
                            <li>Vimeo ({{ __('site.example') }}: https://vimeo.com/20732587)</li>
                            <li>Instagram ({{ __('site.example') }}: https://www.instagram.com/p/BZQm9cSA6iK)</li>
                        </ul>


                        </p>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('site.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('site.save-changes') }}</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="addi" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" class="form" action="{{ route('admin.lectures.lecture-pages.store',['lecture'=>$lecture->id]) }}">
                @csrf  <input type="hidden" name="type" value="i"/>
                <input type="hidden" name="id" value="0"/>
                <div class="modal-header">
                    <h5 class="modal-title"><span class="contentmode">{{ __('site.add') }}</span> {{ __('site.lecture-content') }} ({{ __('site.image') }})</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{ __('site.title') }}</label>
                        <input name="title" class="form-control" id="imagetitle" required="required" value="" type="text">
                    </div>
                    <div class="form-group">

                        <div class="form-group">
                            <label for="picture">@lang('site.image')</label>
                            <input required type="file" class="form-control-file" name="picture" id="picture"
                                   placeholder="@lang('site.file')"
                                   aria-describedby="pictureId">
                            <small id="pictureId" class="form-text text-muted">@lang('site.select-image')</small>
                        </div>

                    </div>





                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('site.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('site.save-changes') }}</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="addq" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <form method="post" class="form" action="{{ route('admin.lectures.lecture-pages.store',['lecture'=>$lecture->id]) }}">
                @csrf
                <input type="hidden" name="type" value="q"/>

                <div class="modal-header">
                    <h5 class="modal-title"><span class="contentmode">{{ __('site.add') }}</span> {{ __('site.quiz') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{ __('site.title') }}</label>
                        <input name="title" class="form-control"  required="required" value="" type="text">
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('site.quiz-description') }}</label>
                        <textarea class="form-control" id="quizcontent" name="content" ></textarea>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('site.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('site.save-changes') }}</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="addz" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <form method="post" class="form" action="{{ route('admin.lectures.lecture-pages.store',['lecture'=>$lecture->id]) }}">
                @csrf
                <input type="hidden" name="type" value="z"/>
                <input type="hidden" name="id" value="0"/>
                <div class="modal-header">
                    <h5 class="modal-title"><span class="contentmode">{{ __('site.add') }}</span> {{ __('site.lecture-content') }} ({{ __('site.zoom-meeting') }})</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">{{ __('site.title') }}</label>
                        <input name="title" class="form-control"   required="required" value="{{ __('site.zoom-meeting') }}" type="text">
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('site.meeting-id') }}</label>
                        <input required="required" class="form-control" type="text" name="meeting_id" placeholder="{{ __('site.zoom-placeholder') }}"/>

                    </div>


                    <div class="form-group">
                        <label for="">{{ __('site.meeting-password') }}</label>
                        <input required="required" class="form-control" type="text" name="password" />

                    </div>

                    <div class="form-group">
                        <label for="">{{ __('site.instructions') }} ({{ __('admin.optional') }})</label>
                        <textarea class="form-control" name="instructions"  ></textarea>

                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('site.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('site.save-changes') }}</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>


