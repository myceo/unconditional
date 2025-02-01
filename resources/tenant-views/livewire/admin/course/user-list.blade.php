<div>

       <ul class="nav nav-pills" id="myTab1" role="tablist">
                                               <li class="nav-item">
                                                 <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true"><i
                                                         class="fa fa-users"
                                                         aria-hidden="true"></i> @lang('site.students')</a>
                                               </li>

                                               <li class="nav-item">
                                                 <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false"><i
                                                         class="fa fa-user-plus"
                                                         aria-hidden="true"></i> @lang('site.add-students')</a>
                                               </li>
                                               <li class="nav-item">
                                                   <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false"><i
                                                           class="fa fa-envelope"
                                                           aria-hidden="true"></i> @lang('site.send-message')</a>
                                               </li>

                                             </ul>
                                             <div class="tab-content" id="myTabContent1">
                                               <div class="tab-pane fade show active pt-3" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                                   <div class="row">

                                                       <div class="col-md-8">
                                                           {{ $course->users()->nonAdmins()->count() }} @lang('site.students')
                                                       </div>
                                                       <div class="col-md-4">
                                                           <input class="form-control" type="text" wire:model.live="search" placeholder="@lang('site.search')..." />
                                                       </div>
                                                   </div>



                                                   <table class="table mt-2">
                                                       <thead>
                                                       <tr>
                                                           <th>@lang('site.student')</th>
                                                           <th style="width: 120px;" class="text-center">@lang('site.classes')</th>
                                                           <th  style="width: 120px;" class="text-center">@lang('site.tests')</th>
                                                           <th class="text-center">@lang('site.completed')</th>
                                                           <th></th>
                                                       </tr>
                                                       </thead>
                                                       <tbody>
                                                       @foreach ($users as $user)
                                                           <tr>
                                                               <td>{{ $user->name }} ({{ $user->email }})</td>
                                                               <td>
                                                                   @if($course->lessons()->count()>0)
                                                                       @php
                                                                           $attended = $user->lessons()->where('course_id',$course->id)->count();
                                                                           $totalLessons = $course->lessons()->count();
                                                                           $percent = 100 * @($attended/($totalLessons));
                                                                       @endphp
                                                                       <div class="text-center">
                                                                           {{ $attended }} / {{ $totalLessons  }}
                                                                       </div>
                                                                       <div class="text-center">

                                                                           <div class="progress progress_sm"  >
                                                                               <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="{{ $percent }}" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}"></div>
                                                                           </div>

                                                                       </div>
                                                                   @endif
                                                               </td>
                                                               <td>
                                                                   @if($course->tests()->count()>0)
                                                                       @php
                                                                           $passed = totalUserCourseTests($user,$course);
                                                                           $totalTests = $course->tests()->count();
                                                                           $percent = 100 * @($passed/($totalTests));
                                                                       @endphp
                                                                       <div class="text-center">
                                                                           {{ $passed }} / {{ $totalTests  }}
                                                                       </div>
                                                                       <div class="text-center">

                                                                           <div class="progress progress_sm"  >
                                                                               <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="{{ $percent }}" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}"></div>
                                                                           </div>

                                                                       </div>
                                                                   @endif
                                                               </td>
                                                               <td class="text-center">{{ boolToString(courseCompleted($user,$course)) }}</td>
                                                               <td>
                                                                   <a class="btn btn-sm btn-primary" href="{{ url('/admin/members/' . $user->id) }}" target="_blank"><i class="fa fa-user"></i> @lang('site.view')</a>

                                                                   <button  onclick="confirm('@lang('site.confirm-delete')') || event.stopImmediatePropagation()"  wire:click="removeUser('{{ $user->id }}')" class="btn btn-sm btn-icon btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>

                                                               </td>
                                                           </tr>
                                                       @endforeach
                                                       </tbody>
                                                   </table>

                                                   {{ $users->links() }}
                                               </div>

                                               <div class="tab-pane fade pt-3" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                                   <form action="{{ route('admin.courses.add-students',['course'=>$course->id]) }}" method="post">
                                                       @csrf
                                                       <div class="form-group ">

                                                           <label for="candidates">@lang('site.members')</label>

                                                           <select required multiple name="users[]" id="users" class="form-control">
                                                               <option></option>
                                                           </select>


                                                       </div>
                                                       <button type="submit" class="btn btn-primary">@lang('site.add')</button>

                                                   </form>
                                               </div>
                                             <div class="tab-pane fade pt-3" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                                <h5>@lang('site.send-message-hint')</h5>
                                                 <form method="post" action="{{ route('admin.courses.message-students',['course'=>$course->id]) }}">
                                                     @csrf
                                                     <div class="form-group">
                                                         <label for="subject">@lang('site.subject')</label>
                                                         <input required type="text"
                                                                class="form-control" name="subject" id="subject"
                                                                aria-describedby="subject-help" placeholder="">
                                                     </div>

                                                     <div class="form-group">
                                                         <label for="message">@lang('site.message')</label>
                                                         <textarea required class="form-control rte" name="message" id="message"
                                                                   rows="3"></textarea>
                                                     </div>

                                                     <button type="submit"
                                                             class="btn btn-primary rte">@lang('site.submit')</button>

                                                 </form>
                                             </div>






                                             </div>



</div>
