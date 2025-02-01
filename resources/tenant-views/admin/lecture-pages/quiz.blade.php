@extends('layouts.admin')

@section('pageTitle',__('site.lecture').': '.limitLength($lecturePage->lecture->title,50))
@section('innerTitle',__('site.quiz').': '.$lecturePage->title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">@lang('site.courses')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.classes.index',['course'=>$lecturePage->lecture->lesson->course_id]) }}">@lang('site.classes')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.classes.lectures.index',['lesson'=>$lecturePage->lecture->lesson_id]) }}">@lang('site.lectures')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.lectures.lecture-pages.index',['lecture'=>$lecturePage->lecture_id]) }}">@lang('site.content')</a></li>
    <li class="breadcrumb-item"><a href="#">@lang('site.quiz')</a></li>
@endsection


@section('content')
    <div   ng-app="myApp" ng-controller="myCtrl" >
        <button ng-click="submit()" class="btn btn-primary float-right"><i class="fa fa-save"></i> {{ __('site.save') }}</button>

        <ul class="nav nav-pills" id="myTab3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-info-circle"></i> {{ __('site.info') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false"><i class="fa fa-question-circle"></i> {{ __('site.questions') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#contact3" role="tab" aria-controls="contact" aria-selected="false"><i class="fa fa-cogs"></i> {{ __('site.options') }}</a>
            </li>
        </ul>
        <div class="tab-content mt-3" id="myTabContent2">
            <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">

                    <div  >
                        <div class="form-group">
                            <label for="name">{{ __('site.name') }}</label>
                            <input class="form-control" type="text" name="name" ng-model="quiz.json.info.name" />
                        </div>
                        <div class="form-group">
                            <label for="mail">{{ __('site.description') }}</label>
                            <textarea class="form-control" name="main" id="main" cols="30" rows="4"  ng-model="quiz.json.info.main" ></textarea>
                        </div>
                        <div class="form-group" style="display: none">
                            <label for="name">{{ __('site.sort-order') }}</label>
                            <input class="form-control number" type="text" name="sort_order" ng-model="sortOrder" />
                        </div>
                        <div class="form-group">
                            <label for="mail">{{ __('site.post-quiz-text') }}</label>
                            <textarea class="form-control" name="main" id="results" cols="30" rows="4"  ng-model="quiz.json.info.results" ></textarea>
                            <p class="help-block">{{ __('site.post-quiz-help') }}</p>
                        </div>

                        <h3>{{ __('site.levels') }}</h3>
                        <p class="help-block">{{ __('site.type-message') }}</p>
                        <div class="form-group">
                            <label for="name">{{ __('site.level') }} 1</label>
                            <input class="form-control" type="text" name="name" ng-model="quiz.json.info.level1" />
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('site.level') }} 2</label>
                            <input class="form-control" type="text" name="name" ng-model="quiz.json.info.level2" />
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('site.level') }} 3</label>
                            <input class="form-control" type="text" name="name" ng-model="quiz.json.info.level3" />
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('site.level') }} 4</label>
                            <input class="form-control" type="text" name="name" ng-model="quiz.json.info.level4" />
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('site.level') }} 5</label>
                            <input class="form-control" type="text" name="name" ng-model="quiz.json.info.level5" />
                        </div>



                    </div>

            </div>
            <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                <div class="accordion" id="accordionExample">
                    <div class="card"  ng-repeat="question in quiz.json.questions"  >
                        <div class="card-header" id="headingOne@{{ $index }}">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne@{{ $index }}" aria-expanded="true" aria-controls="collapseOne@{{ $index }}">
                                    {{ __('site.question') }}: @{{ question.q }}
                                </button>
                            </h2>
                        </div>

                        <div id="collapseOne@{{ $index }}" class="collapse show" aria-labelledby="@{{ $index }}" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="question">{{ __('site.question') }}</label>
                                    <textarea class="form-control"  ng-model="question.q"  ></textarea>
                                </div>

                                <h3>{{ __('site.options') }}</h3>
                                <hr/>
                                <table class="table table-stripped">
                                    <thead>
                                    <tr>
                                        <th style="width: 10%;"></th>
                                        <th>{{ __('site.option') }}</th>
                                        <th>{{ __('site.correct') }}?</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr ng-repeat="option in question.a">
                                        <td><button class="btn btn-danger btn-sm" ng-click="removeOption(question.a,$index)"><i class="fa fa-trash"></i> {{ __('admin.remove') }}</button></td>
                                        <td><input ng-model="option.option" class="form-control" type="text"/></td>
                                        <td><input ng-model="option.correct" type="checkbox" ng-value="true"/></td>
                                    </tr>

                                    </tbody>
                                </table>
                                <br>
                                <button class="btn btn-primary btn-sm" ng-click="addOption(question)"><i class="fa fa-plus"></i> {{ __('site.add-option') }}</button>




                                <div style="margin-top: 50px" class="form-group">
                                    <label for="correct">{{ __('site.correct-response') }}</label>
                                    <textarea class="form-control"  ng-model="question.correct"  placeholder="{{ __('site.answer-is-correct') }}"  ></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="correct">{{ __('site.incorrect-response') }}</label>
                                    <textarea class="form-control"  ng-model="question.incorrect" placeholder="{{ __('site.answer-is-incorrect') }}"  ></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" ng-value="true" ng-model="question.select_any" /> {{ __('site.select-any') }}
                                    <p class="help-block">{{ __('site.select-any-text') }}</p>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" ng-value="true" ng-model="question.force_checkbox" /> {{ __('site.force-checkbox') }}
                                    <p class="help-block">{{ __('site.force-checkbox-help') }}</p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button ng-click="removeQuestion($index)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> {{ __('site.delete-question') }}</button>
                            </div>
                        </div>
                    </div>
                </div>




                <button ng-click="addQuestion()" class="btn btn-primary"><i class="fa fa-plus"></i> {{ __('site.add-question') }}</button>




            </div>
            <div class="tab-pane fade" id="contact3" role="tabpanel" aria-labelledby="contact-tab3">


                    <div>
                        <form class="form-horizontal" onsubmit="return false">
                            <div class="form-group">
                                <label class="control-label">{{ __('site.checked-answer-text') }}:</label>
                                <div>
                                    <input class="form-control" type="text" ng-model="quiz.checkAnswerText"/>
                                    <p class="help-block">
                                        {{ __('site.checked-answer-text-help') }}
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label   class=" control-label">{{ __('site.next-question-text') }}</label>
                                <div class="">
                                    <input class="form-control" type="text" ng-model="quiz.nextQuestionText"/>
                                    <p class="help-block">
                                        {{ __('site.new-question-text-help') }}
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label   class=" control-label">{{ __('site.completed-quiz-text') }}</label>
                                <div class="">
                                    <input class="form-control" type="text" ng-model="quiz.completeQuizText"/>
                                    <p class="help-block">
                                        {{ __('site.completed-quiz-help') }}
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label   class=" control-label">{{ __('site.back-button-text') }}</label>
                                <div class="">
                                    <input class="form-control" type="text" ng-model="quiz.backButtonText"/>
                                    <p class="help-block">
                                        {{ __('site.back-button-help') }}
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label   class=" control-label">{{ __('site.try-again-text') }}</label>
                                <div class="">
                                    <input class="form-control" type="text" ng-model="quiz.tryAgainText"/>
                                    <p class="help-block">
                                        {{ __('site.try-again-help') }}
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label   class=" control-label">{{ __('site.prevent-unanswered-text') }}</label>
                                <div class="">
                                    <input class="form-control" type="text" ng-model="quiz.preventUnansweredText"/>
                                    <p class="help-block">
                                        {{ __('site.prevent-unanswered-help') }}
                                    </p>
                                </div>
                            </div>


                            <div class="form-group">
                                <label   class=" control-label">{{ __('site.question-count-text') }}</label>
                                <div class="">
                                    <input class="form-control" type="text" ng-model="quiz.questionCountText"/>
                                    <p class="help-block">
                                        {{ __('site.question-count-help') }}
                                    </p>
                                </div>
                            </div>


                            <div class="form-group">
                                <label   class=" control-label">{{ __('site.question-template-text') }}</label>
                                <div class="">
                                    <input class="form-control" type="text" ng-model="quiz.questionTemplateText"/>
                                    <p class="help-block">
                                        {{ __('site.question-template-help') }}
                                    </p>
                                </div>
                            </div>


                            <div class="form-group">
                                <label   class=" control-label">{{ __('site.score-template-text') }}</label>
                                <div class="">
                                    <input class="form-control" type="text" ng-model="quiz.scoreTemplateText"/>
                                    <p class="help-block">
                                        {{ __('site.score-template-help') }}
                                    </p>
                                </div>
                            </div>


                            <div class="form-group">
                                <label   class=" control-label">{{ __('site.name-template-text') }}</label>
                                <div class="">
                                    <input class="form-control" type="text" ng-model="quiz.nameTemplateText"/>
                                    <p class="help-block">
                                        {{ __('site.name-template-help') }}
                                    </p>
                                </div>
                            </div>



                            <div class="form-check">
                                <label   class=" control-label">
                                    <input type="checkbox" ng-value="true" ng-model="quiz.skipStartButton"/>
                                    {{ __('site.skip-start-button') }}

                                </label>
                                <p class="help-block">
                                    {{ __('site.skip-start-help') }}
                                </p>

                            </div>



                            <div class="form-check">
                                <label   class=" control-label">
                                    <input type="checkbox" ng-value="true" ng-model="quiz.randomSortQuestions"/>
                                    {{ __('site.random-sort-questions') }}</label>
                                <p class="help-block">
                                    {{ __('site.random-sort-help') }}
                                </p>

                            </div>



                            <div class="form-check">
                                <label   class=" control-label">
                                    <input type="checkbox" ng-value="true" ng-model="quiz.randomSortAnswers"/>
                                    {{ __('site.random-sort-answers') }}</label>
                                <p class="help-block">
                                    {{ __('site.random-sort-a-help') }}
                                </p>

                            </div>


                            <div class="form-check">
                                <label   class=" control-label">
                                    <input type="checkbox" ng-value="true" ng-model="quiz.preventUnanswered"/>
                                    {{ __('site.prevent-unanswered') }}</label>

                                <p class="help-block">
                                    {{ __('site.prevent-unanswered-helper') }}
                                </p>

                            </div>

                            <div class="form-check">
                                <label   class=" control-label">
                                    <input type="checkbox" ng-value="true" ng-model="quiz.perQuestionResponseMessaging"/>

                                    {{ __('site.per-question-response') }}</label>
                                <p class="help-block">
                                    {{ __('site.per-question-help') }}
                                </p>
                            </div>

                            <div class="form-check">
                                <label   class=" control-label">
                                    <input type="checkbox" ng-value="true" ng-model="quiz.perQuestionResponseAnswers"/>

                                    {{ __('site.per-question-answers') }}</label>
                                <p class="help-block">
                                    {{ __('site.per-question-helper') }}
                                </p>

                            </div>

                            <div class="form-check">
                                <label class=" control-label">
                                    <input type="checkbox" ng-value="true" ng-model="quiz.completionResponseMessaging"/>
                                    {{ __('site.completion-response') }}</label>
                                <p class="help-block">
                                    {{ __('site.completion-response-help') }}
                                </p>
                            </div>

                            <div class="form-check">
                                <label   class=" control-label">
                                    <input type="checkbox" ng-value="true" ng-model="quiz.displayQuestionCount"/>

                                    {{ __('site.display-question-count') }}</label>
                                <p class="help-block">
                                    {{ __('site.display-question-help') }}
                                </p>
                            </div>

                            <div class="form-check">
                                <label   class=" control-label">
                                    <input type="checkbox" ng-value="true" ng-model="quiz.displayQuestionNumber"/>

                                    {{ __('site.display-question-number') }}</label>
                                <p class="help-block">
                                    {{ __('site.display-ques-number-help') }}
                                </p>
                            </div>

                            <div class="form-check">
                                <label class=" control-label">
                                    <input type="checkbox" ng-value="true" ng-model="quiz.disableScore"/>
                                    {{ __('site.disable-score') }}</label>
                                <p class="help-block">
                                    {{ __('site.disable-score-help') }}
                                </p>
                            </div>

                            <div class="form-check">
                                <label   class=" control-label">
                                    <input type="checkbox" ng-value="true" ng-model="quiz.disableRanking"/>
                                    {{ __('site.disable-ranking') }}</label>
                                <p class="help-block">
                                    {{ __('site.disable-ranking-help') }}
                                </p>

                            </div>


                            <div class="form-check">
                                <label   class=" control-label">
                                    <input type="checkbox" ng-value="true" ng-model="quiz.scoreAsPercentage"/>
                                    {{ __('site.score-as-percentage') }}</label>
                                <p class="help-block">
                                    {{ __('site.score-as-percentage-help') }}
                                </p>
                            </div>


                        </form>

                    </div>



            </div>
        </div>

    </div>
    </div>
@endsection


@section('header')
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/slickquiz/css/slickQuiz.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/slickquiz/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/loader/css/jquery.loadingModal.min.css') }}">

@endsection

@section('footer')
    <script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('js/admin/textrte.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/slickquiz/js/slickQuiz.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/angular/angular.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/loader/js/jquery.loadingModal.min.js') }}"></script>
    <script>
        var app = angular.module('myApp', []);
        app.controller('myCtrl', function($scope,$http) {
            // $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
            $scope.quiz = {!! $lecturePage->content !!};

            $scope.sortOrder = {{ intval($lecturePage->sort_order) }};


            $scope.submit = function(){
                console.log($scope.quiz);
                //  return;
                $('body').loadingModal({
                    text: '{{__('site.saving-quiz')}}'
                })
                var data = {
                    'content':$scope.quiz,
                    'sort_order':$scope.sortOrder,
                    'title':$scope.quiz.json.info.name,
                    '_token': '{{ csrf_token() }}'
                };
                $.post('{{ route('admin.lecture.save-quiz',['lecturePage'=>$lecturePage->id])}}',data,function(data){

                    if(data){
                        document.location.replace('{{ route('admin.lectures.lecture-pages.index',['lecture'=>$lecturePage->lecture_id]) }}')
                    }
                    else{
                        alert('{{__('site.submission-failed')}}')
                    }
                },'json').fail(function(){
                    alert('{{__('site.network-error')}}');
                }).always(function() {
                    $('body').loadingModal('hide');
                });

            }

            $scope.addQuestion= function(){

                console.log('adding a question');
                $scope.quiz.json.questions.push({
                    q: "",
                    a: [],
                    correct: "{{__('site.is-correct')}}",
                    incorrect: "{{__('site.is-incorrect')}}"
                });

                // $('.collapse').collapse('hide');
                $('.collapse').removeClass('in');
                var index = $scope.quiz.json.questions.length -1;
                console.log(index);

                setTimeout(function(){
                    //  $('#collapseOne'+index).collapse('show')
                    $('#collapseOne'+index).addClass('in');
                }, 500);
            }

            $scope.addOption = function(question){
                question.a.push({"option": "", "correct": false});
            }

            $scope.removeOption = function(options,index){
                if(confirm('{{__('site.conf-delete')}}?')){
                    options.splice(index,1);
                }

            }

            $scope.removeQuestion = function(index){
                if(confirm('{{__('site.conf-delete')}}?')){
                    $scope.quiz.json.questions.splice(index,1);
                }
            }


        });


    </script>
@endsection
