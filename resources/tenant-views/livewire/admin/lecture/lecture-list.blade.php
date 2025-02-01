<div>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>#</th><th>@lang('site.title')</th>
            <th>{{__('site.content')}}</th>
            <th>{{ __('site.files') }}</th>

            <th>@lang('site.actions')</th>
        </tr>
        </thead>
        <tbody wire:sortable="updateTaskOrder">
        @foreach($lectures as $item)
            <tr  wire:sortable.item="{{ $item->id }}" wire:key="task-{{ $item->id }}" >
                <td class="draggable"   wire:sortable.handle><i class="fa fa-grip-vertical"></i></td>
                <td >{{ $loop->iteration }}</td>
                <td >{{ $item->title }}</td>
                <td><a href="{{ route('admin.lectures.lecture-pages.index',['lecture'=>$item->id]) }}">{{ $item->lecturePages()->count()  }} {{ __('site.items') }}</a></td>
                <td>{{ $item->lectureFiles()->count() }}</td>
                <td>
                    <a href="{{ route('admin.lectures.lecture-pages.index',['lecture'=>$item->id]) }}" class="btn btn-sm btn-success"><i class="fa fa-file-video"></i> {{ __('site.manage-content') }}</a>

                    <div class="btn-group dropup">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ni ni-settings"></i> @lang('site.actions')
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.lecture.files',['lecture'=>$item->id]) }}">@lang('site.files')</a>

                            <a class="dropdown-item" href="{{ route('admin.classes.lectures.edit',['lesson'=>$item->lesson_id,'lecture'=>$item->id]) }}">@lang('site.edit')</a>

                            <a class="dropdown-item" href="#" onclick="$('#deleteForm{{ $item->id }}').submit()">@lang('site.delete')</a>

                        </div>
                    </div>

                    <form  onsubmit="return confirm(&quot;@lang('site.confirm-delete')&quot;)"   id="deleteForm{{ $item->id }}"  method="POST" action="{{ route('admin.classes.lectures.destroy',['lecture'=>$item->id,'lesson'=>$item->lesson_id]) }}" accept-charset="UTF-8" class="int_inlinedisp""display:inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
