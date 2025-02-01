<?php

namespace App\Http\Controllers\Tenant\Training;

use App\Course;
use App\Http\Controllers\Tenant\Controller;
use App\Lecture;
use App\Lesson;
use Barryvdh\DomPDF\PDF;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LmsController extends Controller
{

    public function landing(Course $course){
       return view('lms.landing');
    }

    public function resume(Course $course){
            $user = Auth::user();
            //loop through lessons
            $route = route('lms.landing',['course'=>$course->id]);
            foreach($course->lessons()->ordered()->get() as $lesson){
                if(!$user->completedLesson($lesson)){
                    foreach ($lesson->lectures()->ordered()->get() as $lecture){
                        if(!$user->completedLecture($lecture)){
                            $route = route('lms.lecture',['course'=>$course->id,'lecture'=>$lecture->id]);
                            return redirect($route);
                        }
                    }
                }
            }

            return redirect($route);

    }

    public function start(Course $course){

        //get first class
        $lesson = $course->lessons()->ordered()->first();
        if(!$lesson){
            flashMessage(__('site.no-classes'));
            return back();
        }
        return redirect()->route('lms.lesson',['course'=>$course->id,'lesson'=>$lesson->id]);
    }


    public function lesson(Course $course,Lesson $lesson){
        //verify this lecture belongs to this coruse
        if(!($lesson->course_id==$course->id)){
            abort(404);
        }
        //get first lecture
        $firstLecture = $lesson->lectures()->ordered()->first();
        if(!$firstLecture){
            flashMessage(__('site.no-lectures'));
            return back();
        }
        return view('lms.lesson',compact('lesson','firstLecture'));
    }

    public function lecture(Course $course,Lecture $lecture){
        //verify this lecture belongs to this coruse
        if(!($lecture->lesson->course_id==$course->id)){
            abort(404);
        }
        $zoom = false;
        foreach ($lecture->lecturePages as $page){
            if($page->type =='z'){
                $zoom = true;
            }
        }
        $previous = $lecture->getPrevious();
        $previousLesson = $lecture->lesson->getPreviousLesson();
        return view('lms.lecture',compact('lecture','zoom','previous','previousLesson'));
    }

    public function logLecture(Course $course,Lecture $lecture){

            $user = Auth::user();

            if(!$user->completedLecture($lecture)){
                $user->lectures()->attach($lecture->id);
            }

            if($user->completedLesson($lecture->lesson) && !$user->lessons()->find($lecture->lesson_id)){
                $user->lessons()->attach($lecture->lesson_id);
            }

            $nextLecture = $lecture->getNext();
            $nextLesson = $lecture->lesson->getNextLesson();
            if($nextLecture){
                return redirect()->route('lms.lecture',['course'=>$course->id,'lecture'=>$nextLecture->id]);
            }
            elseif($nextLesson){
                return redirect()->route('lms.lesson',['course'=>$course->id,'lesson'=>$nextLesson->id]);
            }
            elseif (lessonsCompleted($user,$course) && !testsCompleted($user,$course)){
                //redirect to tests page
                flashMessage(__('site.take-tests'));
                return redirect(route('lms.landing',['course'=>$course->id]).'?test=1')->with('flash_message',__('site.test-completed'));
            }
            elseif(courseCompleted($user,$course)){
                flashMessage(__('site.course-completed-message',['name'=>$course->name]));
                return redirect()->route('lms.landing',['course'=>$course->id]);
            }
            else{
                return redirect()->route('lms.landing',['course'=>$course->id]);
            }


    }

    public function certificate(Course $course)
    {
        $user = Auth::user();
        if(!courseCompleted($user,$course)){
            flashMessage(__('site.course-incomplete'));
            return back();
        }

        $html = $course->certificate_html;

        $elements = [
          'STUDENT_NAME'=>$user->name,
            'COURSE_NAME'=>$course->name,
            'COURSE_START_DATE'=>dateString($course->start_date),
            'COURSE_END_DATE'=>dateString($course->end_date),
            'DATE_GENERATED'=>date('d-M-Y'),
            'COMPANY_NAME'=>setting('general_site_name')
        ];

        foreach ($elements as $element=>$value) {
            $element= "[$element]";
            $html = str_ireplace($element,$value,$html);
        }

        if($course->certificate_orientation=='p'){
            $width = 595;
            $height = 842;
        }
        else{
            $width = 842;
            $height = 595;
        }

        while(preg_match('#inset#',$html)){

            $pos = stripos($html,'inset:');

            $append = substr($html,$pos);

            $pos = stripos($append,';');
            $insetLine= substr($append,0,$pos);

            $cleanInset = str_ireplace('inset:','',$insetLine);
            $cleanInset = str_ireplace('auto','',$cleanInset);
            $cleanInset = trim($cleanInset);

            $positions  = explode(' ',$cleanInset);

            $top = $positions[0];
            $left = end($positions);

            $newCssRule = "top: {$top}; left: {$left}";

            $html = str_ireplace($insetLine,$newCssRule,$html);


        }
        $pdfHtml = view('lms.certificate',compact('course','html','width','height'))->render();


        if(useDomPdf()){
            $contxt = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed'=> TRUE
                ]
            ]);


            $orientation = ($course->certificate_orientation=='p')?'portrait':'landscape';
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('defaultFont', 'DejaVu Sans');

            $dompdf = new Dompdf($options);
            $dompdf->setHttpContext($contxt);
            $path = realpath('./');
            $dompdf->getOptions()->setChroot($path);

           $dompdf->loadHtml($pdfHtml);
            $dompdf->setPaper('A4', $orientation);
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream(safeUrl($course->name).'.pdf');
        }
        else{

            $fileName  = safeUrl($course->name).'.pdf';

            $orientation = ($course->certificate_orientation=='p')?'portrait':'landscape';

            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($pdfHtml)->setPaper('a4')->setOrientation($orientation)->setOption('margin-bottom', 0)->setOption('margin-top', 0)->setOption('margin-right', 0)->setOption('margin-left', 0)->setOption('page-width',162)->setOption('page-height',230)->setOption('disable-smart-shrinking',true);
            return $pdf->download($fileName);
        }




    }

}
