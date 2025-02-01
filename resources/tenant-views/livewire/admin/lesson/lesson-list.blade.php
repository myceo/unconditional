<div>

    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>#</th><th>@lang('site.name')</th>
            <th>@lang('site.lectures')</th>
            <th>@lang('site.actions')</th>
        </tr>
        </thead>
        <tbody wire:sortable="updateTaskOrder">
        @foreach($lessons as $item)
            <tr   wire:sortable.item="{{ $item->id }}" wire:key="task-{{ $item->id }}" >
                <td class="draggable"   wire:sortable.handle><i class="fa fa-grip-vertical"></i></td>
                <td   >{{ $loop->iteration + ( (Request::get('page',1)-1) *$perPage) }}</td>
                <td  >{{ $item->name }}</td>
                <td  >{{ $item->lectures()->count() }}</td>
                <td>

                    <a class="btn btn-success btn-sm " href="{{ route('admin.classes.lectures.index',['lesson'=>$item->id]) }}"><i class="fa fa-chalkboard-teacher"
                                                                  aria-hidden="true"></i> @lang('site.manage-lectures')</a>

                    <div class="btn-group dropup">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ni ni-settings"></i> @lang('site.actions')
                        </button>
                        <div class="dropdown-menu">
                            <!-- Dropdown menu links -->

                            <a  data-toggle="modal"
                                data-target="#classModal{{ $item->id }}" class="dropdown-item" href="#">@lang('site.details')</a>



                            <a class="dropdown-item" href="{{ route('admin.courses.classes.edit',['course'=>$course->id,'lesson'=>$item->id]) }}">@lang('site.edit')</a>



                            <a class="dropdown-item" href="#" onclick="$('#deleteForm{{ $item->id }}').submit()">@lang('site.delete')</a>




                        </div>
                    </div>

                    <form  onsubmit="return confirm(&quot;@lang('site.delete-prompt')&quot;)"   id="deleteForm{{ $item->id }}"  method="POST" action="{{  route('admin.courses.classes.destroy',['course'=>$course->id,'lesson'=>$item->id])  }}" accept-charset="UTF-8" class="int_inlinedisp"  >
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                    </form>
                </td>
            </tr>
        @section('footer')
            @parent


            <!-- Modal -->
            <div class="modal fade" id="classModal{{ $item->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="classModalTitle{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $item->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h6 surtitle text-muted">@lang('site.name')</span>
                                    <span class="d-block">{{ $item->name }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span class="h6 surtitle text-muted">@lang('site.description')</span>
                                    <p>{!! $item->description !!}</p>
                                </div>
                            </div>
                            @if(file_exists($item->picture))
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 surtitle text-muted">@lang('site.picture')</span>
                                        <div>
                                            <img src="{{ asset($item->picture) }}" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col">
                                    <span class="h6 surtitle text-muted">@lang('site.sort-order')</span>
                                    <span class="d-block">{{ $item->sort_order }}</span>
                                </div>
                            </div>
                            @if(isset($item->test) && $item->test->exists())
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 surtitle text-muted">@lang('site.test')</span>
                                        <span class="d-block">{{ $item->test->name }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col">
                                    <span class="h6 surtitle text-muted">@lang('site.enforce-lecture-order')</span>
                                    <span class="d-block">{{ boolToString($item->enforce_lecture_order) }}</span>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"
                                    data-dismiss="modal">@lang('site.close')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
        @endforeach
        </tbody>
    </table>

</div>
