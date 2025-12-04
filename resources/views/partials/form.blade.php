<div class="row">
    <div class="col-md-6 text-left">
        <h3 class="panel-title">{{ $formdata->title }}</h3>
        {!! $formdata->description !!}
    </div>
    <div class="col-md-6 text-right">
        <h3 class="panel-title">{{ $formdata->title_ar }}</h3>
        {!! $formdata->description_ar  !!}
    </div>
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <form action="{{ url('forms/store') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" value="{!! csrf_token() !!}" name="_token">
            <input type="hidden" name="id" value="{{ $formdata->id }}">
            @foreach($formdata->questions as $index=>$question)
                <?php $qID = $formdata->questions[$index]->id; ?>
                <div class="row">
                    <div class="col-md-12">
                        <strong>{{ $question->question }}</strong>
                        <div class="row">
                            @if($question->type->slug=='radio' || $question->type->slug=='checkbox')
                                @foreach($question->choices as $index=>$choice)
                                    <div class="col-md-12">
                                        <input id="{{$choice->id}}"  {{ $index==0 ? 'checked' : '' }} type="{{ $question->type->slug }}" name="questions[{{$qID}}][]" value="{{$choice->value}}">
                                        <label for="{{$choice->id}}">{{$choice->value}}</label>
                                    </div>
                                @endforeach
                            @elseif($question->type->slug=='textarea')
                                <div class="col-md-12"><textarea name="questions[{{$qID}}]" {{ $question->is_required ? 'required="required"' : '' }}></textarea></div>
                            @elseif($question->type->slug=='file')
                                <div class="col-md-12">
                                    <input type="file" name="questions[{{$qID}}]" {{ $question->is_required ? 'required="required"' : '' }}>
                                </div>
                            @elseif($question->type->slug=='date')
                                <div class="col-md-12"><input type="text" class="datepicker" name="questions[{{$qID}}]" {{ $question->is_required ? 'required="required"' : '' }}></div>
                            @else
                                <div class="col-md-12"><input type="text" name="questions[{{$qID}}]" {{ $question->is_required ? 'required="required"' : '' }}></div>
                            @endif
                        </div>
                    </div>
                </div>
                <br/><br/>
            @endforeach
            <input type="submit" class="en" value="Submit">
        </form>
    </div>

    <div class="col-md-6 text-right">
        <form action="{{ url('forms/store') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" value="{!! csrf_token() !!}" name="_token">
            <input type="hidden" name="id" value="{{ $formdata->id }}">
            @foreach($formdata->questions as $index=>$question)
                <?php $qID = $formdata->questions[$index]->id; ?>
                <div class="row">
                    <div class="col-md-12">
                        <strong>{{ $question->question_ar }}</strong>
                        <div class="row" dir="rtl">
                            @if($question->type->slug=='radio' || $question->type->slug=='checkbox')
                                @foreach($question->choices as $index=>$choice)
                                    <div class="col-md-12">
                                        <input id="{{$choice->id}}"  {{ $index==0 ? 'checked' : '' }} type="{{ $question->type->slug }}" name="questions[{{$qID}}][]" value="{{$choice->value}}">
                                        <label for="{{$choice->id}}">{{$choice->value_ar}}</label>
                                    </div>
                                @endforeach
                            @elseif($question->type->slug=='textarea')
                                <div class="col-md-12"><textarea name="questions[{{$qID}}]" {{ $question->is_required ? 'required="required"' : '' }}></textarea></div>
                            @elseif($question->type->slug=='file')
                                <div class="col-md-12">
                                    <input type="file" name="questions[{{$qID}}]" {{ $question->is_required ? 'required="required"' : '' }}>
                                </div>
                            @elseif($question->type->slug=='date')
                                <div class="col-md-12"><input type="text" class="datepicker" name="questions[{{$qID}}]" {{ $question->is_required ? 'required="required"' : '' }}></div>
                            @else
                                <div class="col-md-12"><input type="text" name="questions[{{$qID}}]" {{ $question->is_required ? 'required="required"' : '' }}></div>
                            @endif
                        </div>
                    </div>
                </div>
                <br/><br/>
            @endforeach<input type="submit" class="ar" value="إرسال">
        </form>
    </div>
</div>