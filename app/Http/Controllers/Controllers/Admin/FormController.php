<?php

namespace App\Http\Controllers\Admin;

use App\Models\Forms\FormEntry;
use App\Models\Forms\Form;
use App\Models\Forms\FormEntryItem;
use App\Models\Forms\FormQuestion;
use App\Models\Forms\FormQuestionType;
use App\Services\Uploaders\FormEntryItemUploader;
use App\Traits\CanCreateSlug;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class FormController extends Controller
{
    use CanCreateSlug;

    public function __construct(Form $model, FormEntryItemUploader $uploader)
    {
        $this->model = $model;
        $this->uploader = $uploader;
    }

    public function index(){
        $data = $this->model->with('entries')->get();
        return view('admin.forms.index',compact('data'));
    }

    public function create(){
        $data['types'] = FormQuestionType::pluck('name','slug');

        return view('admin.forms.create',compact('data'));
    }

    public function store(Request $request){
        $formData = $request->input('form');
        $questions = $request->input('question');

        $formData['slug'] = $this->generateSlug($formData['title']);

        $form = $this->model->create($formData);

        if($form)
        {
            if(count($questions)){
                foreach ($questions as $question){
                    $type = FormQuestionType::where('slug',$question['type'])->pluck('id')->first();

                    if($type){
                        $question['form_question_type_id'] = $type;
                        $newQ = $form->questions()->create($question);


                        if($newQ && $question['choices']){

                            foreach($question['choices'] as $choice){
                                $data = [];
                                $ch = $choice['choice'];

                                if(trim($ch['en']) && trim($ch['ar'])){
                                    $data['value'] = $ch['en'];
                                    $data['value_ar'] = $ch['ar'];
                                    $newQ->choices()->create($data);
                                }
                            }
                        }
                    }
                }
            }
            return redirect()->to('admin/forms/show/'.$form->id);
        }
    }

    public function update(Request $request){
        $formData = $request->input('form');

        $questions = $request->input('question');
        $file = $request->file('thumbnail');

        $form = $this->model->find($request->input('id'));

        if($form){

            if($form->title != $formData['title'])
                $formData['slug'] = $this->generateSlug($formData['title']);

            $form->update($formData);
            $form->questions()->delete();

            foreach ($questions as $id=>$question){

                $type = FormQuestionType::where('slug',$question['type'])->pluck('id')->first();

                if($type){
                    $question['form_question_type_id'] = $type;

                    $newQ = $form->questions()->create($question);

                    if($newQ && isset($question['choices'])){
                        foreach($question['choices'] as $choice){
                            $ch = $choice['choice'];

                            if(trim($ch['en']) && trim($ch['ar'])){
                                $data['value'] = $ch['en'];
                                $data['value_ar'] = $ch['ar'];

                                $newQ->choices()->create($data);
                            }
                        }
                    }
                }
            }
            return redirect()->to('admin/forms/show/'.$form->id);
        }
    }

    public function show($id){
        $form = $this->model->find($id);

        if($form){

            $data['types'] = FormQuestionType::pluck('name','slug');

            $form->load('questions.type','questions.choices');

            return view('admin.forms.show',compact('data','form'));
        }
    }

    public function storeEntry(Request $request){
        $answers = $request->input('questions');
        $answerFiles = $request->file('questions');
        $form = Form::find($request->input('id'));
        $entry = $form->entries()->create([]);

        foreach ($answers as $question_id => $answer){
            if(!is_array($answer))
                $entry->items()->create(['form_question_id'=>$question_id, "value" => $answer]);
            else
                foreach ($answer as $item)
                    $entry->items()->create(['form_question_id'=>$question_id, "value" => $item]);
        }

        foreach ($answerFiles as $question_id => $file){
            $upload = ($file != null ? $this->uploader->upload($file) : false);
            $entryItem = $entry->items()->create(['form_question_id'=>$question_id, "value" => $upload[0]['path'].'/'.$upload[0]['file_name'] ]);
            $entryItem->uploads()->create($upload);
        }

        Session::flash('message','Done');
        return redirect()->back();
    }

    public function showPage($id){
        $data = Form::find($id);

        if($data) {
            $data->load('questions.type', 'questions.choices');
            return view('pages.form',compact('data'));
        }
    }

    public function preview($id){
        $data = Form::find($id);

        if($data){
            $data->load('questions.type','questions.choices');

            return view('admin.forms.preview',compact('data'));
        }
    }

    public function togglePublish($id){
        $data = $this->model->find($id);

        if($data){
            if($data->is_active)
            {
                $data->is_active = 0;
                Session::flash('message','Form unpublished.');
            }
            else
            {
                $data->is_active = 1;
                Session::flash('message','Form published.');
            }

            $data->save();

            return redirect()->back();
        }
    }

    public function excel($id){
        $form = $this->model->find($id);

        if($form){
            $data = [];

            foreach ($form->questions  as $index=>$question){
                $data[] = $question->question;
            }
            $data[] = 'Date Created';

            $header = $data;
            $col = [];
            $entries = [];

            foreach ($form->entries as $e){
                $col = [];

                foreach ($form->questions  as $index=>$question){

                        $items = '';

                        $rows = FormQuestionAnswerItem::where('form_question_answer_id',$e->id)->where('form_question_id',$question->id)->get();

                        if(count($rows)>0){
                            if(count($rows)>1){
                                foreach ($rows as $x=>$row)
                                    $items .= $row->value.( $x+1 <count($rows) ? ',' : '');
                            } else {
                                $items = $rows[0]->value;
                            }
                        } else {
                            foreach ($question->choices as $choice){
                                $rating = FormQuestionChoiceRating::where('form_question_choice_id',$choice->id)->where('form_question_answer_id',$e->id)->first();

                                if ($rating)
                                    $items .= $choice->value.': '.$rating->value. ' , ';
                            }
                        }

                        $col[] = $items;
                }

                $col[] = $e->created_at->format('d/m/Y H:s');
                $entries[] = $col;
            }

            Excel::create($form->title, function($excel) use($header,$entries) {

                $excel->sheet('Sheetname', function($sheet) use($header,$entries) {

                    $sheet->appendRow($header);

                    foreach ($entries as $t)
                        $sheet->appendRow($t);

                });

            })->export('xls');

            $form->load('questions.type','questions.choices');

            return view('admin.forms.show',compact('data','form'));
        }
    }

    public function showEntries($id){
        $entries = FormEntry::where('form_id',$id)->get();

        if($entries){
            $entries->load('items');
            return view('admin.forms.entries.index',compact('entries'));
        }
    }

    public function showEntryItems($id){
        $questions = FormEntryItem::where('form_entry_id',$id)->groupBy('form_question_id')->select('form_entry_id','form_question_id')->get();

        $entries = [];
        foreach ($questions as $question){
            $entries[$question['form_question_id']]['question'] = $question->question()->first()->question .' / '. $question->question()->first()->question_ar;

            $ens = FormEntryItem::where('form_entry_id',$question->form_entry_id)->where('form_question_id',$question->form_question_id)->get();

            $activeQuestion = FormQuestion::find($question->form_question_id);
            $questionType = FormQuestionType::find($activeQuestion->form_question_type_id);

            if($questionType->slug=='file')
                $entries[$question['form_question_id']]['is_file'] = true;

            foreach ($ens as $en){
                $entries[$question['form_question_id']]['values'][] = $en->value;
            }
        }

        if($entries){
            return view('admin.forms.entries.show',compact('entries'));
        }
    }

    public function delete($id){
        $form = Form::find($id);

        if($form){
            $form->delete();

            Session::flash('message','Form Deleted.');

            return redirect()->route('admin.forms.index');
        }
    }

    public function deleteEntry($id){
        $entry = FormQuestionAnswer::find($id);
        $form_id = $entry->form->id;

        if($entry){
            $entry->delete();
            return redirect()->back();
        }
    }

    public function showEntry($form_id,$entry_id){
        $questions = FormQuestion::where('form_id',$form_id)->get();
        $form = Form::find($form_id);

        if($questions && $form){
            $data = [];

            foreach($questions as $index=>$question){
                $data[$index]['question'] = $question->question;

                if($question->type->slug=='rate'){
                    foreach($question->choices as $choice){
                        $data[$index]['choices'][$choice->id]['choice'] = $choice->value;
                        $data[$index]['choices'][$choice->id]['rate'] = FormQuestionChoiceRating::where('form_question_answer_id',$entry_id)
                            ->where('form_question_choice_id',$choice->id)->pluck('value')->first();
                    }
                } else {
                    $data[$index]['data'] = FormQuestionAnswerItem::where('form_question_answer_id',$entry_id)->where('form_question_id',$question->id)->get();
                }
            }

            return view('admin.forms.entries.show',compact('data','form'));
        }
    }

}
