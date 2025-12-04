
var questionCount = 0;
var choiceCount = 0;

$('#addQuestionBt').on('click',function(){
    type = $('#typeSelector').val();
    question = $('#questionField').val();

    questionCount = $('.ui-state-default').length + 1;

    el = '<div class="form-group clearfix ui-state-default" data-id="'+questionCount+'">';

    if(type=='text')
    {
        el += '<label>Text Question </label>';
    } else if (type=='textarea')
    {
        el += '<label>Textarea Question </label>';
    } else if (type=='radio')
    {
        el += '<label>Multiple choices with single answer</label>';
    } else if (type=='checkbox')
    {
        el += '<label>Multiple choices with multiple answers</label>';
    } else if (type=='date')
    {
        el += '<label>Date Question </label>';
    } else if (type=='rate')
    {
        el += '<label>Rate Question </label>';
    }

    el += '<div class="clearfix"><input type="text" class="form-control" required="required" name="question['+questionCount+'][question]" style="float:left; width:49%; margin-bottom: 10px;" placeholder="Add question here...">';
    el += '<input type="text" class="form-control" required="required" name="question['+questionCount+'][question_ar]" style="float:right; width:49%; margin-bottom: 10px;" placeholder="Add question here..."></div>';
    el += '<span class="delete-question"><span class="glyphicon glyphicon-trash" aria-hidden="true">X</span></span>';

    if (type=='radio'|| type=='checkbox')
    {
        el += '<div class="row"><div class="col-md-6"><label>Choices</label></div></div>';
        el += '<div class="choices">' +
                '<div class="row choice">' +
                    '<div class="col-md-6 en">EN:</br>' +
                        '<div class="choice"><input type="text" name="question['+questionCount+'][choices]['+choiceCount+'][choice][en]" value=""></div>' +
                    '</div>' +
                    '<div class="col-md-6 ar">AR:</br>' +
                        '<div class="choice"><input type="text" name="question['+questionCount+'][choices]['+choiceCount+'][choice][ar]" value=""></div>' +
                    '</div>'+
                '</div>'+
               '</div>';
        el += '<br><button type="button" class="addQBT">+ Add a choice</button><br>';
        choiceCount++;
    }
    else if (type=='file')
    {
        el += '<div class="row"><div class="field-group col-md-9"><label>Upload file</label>';
    }

    el += '<div class="row"><div class="field-group col-md-9"><br><br>';

    el += '<input type="hidden" name="question['+questionCount+'][type]" value="'+type+'">';

    el += '<br></div><div class="col-md-3"><label class="pull-right answer-required">Answer required <input name="question['+questionCount+'][is_required]" value="1" type="checkbox" checked></label></div>';

    el += '</div>';

    el += '<input type="text" class="count" readonly="readonly" name="question['+questionCount+'][order]" value="'+questionCount+'">';

    el += '</div>';

    $('#surveyElements').append(el);
    addQBTClickEvent();
    addRBTClickEvent();
    addDeleteQuestionClickEvent();
    updateSortable();
    updateRateSelect();
});

function updateRateSelect(){
    choices = [5,10];

    $('.rateSelect').each(function(e,i){
        item = $(this);

        if(item.find('option').length < 1){
            for(x=0;x<choices.length;x++)
                $('<option/>').attr('value', choices[x]).text('1 to '+choices[x]).appendTo(item).trigger('change');
        }

    });

}

function addQBTClickEvent(){
    $('.addQBT').unbind('click');
    $('.addQBT').on('click',function(){
        holder = $(this).closest('.form-group');
        id = holder.attr('data-id');

        el = '<div class="choice">';
        el += '<input type="text" name="question['+id+'][choices]['+choiceCount+'][choice][en]"><span class="glyphicon glyphicon-remove-sign delete-choice" aria-hidden="true"></span><br>';
        el += '</div>';

        holder.find('.choices .choice .en').append(el);

        el = '<div class="choice">';
        el += '<input type="text" name="question['+id+'][choices]['+choiceCount+'][choice][ar]"><span class="glyphicon glyphicon-remove-sign delete-choice" aria-hidden="true"></span><br>';
        el += '</div>';

        holder.find('.choices .choice .ar').append(el);

        addDeleteChoiceClickEvent();
        choiceCount++;
    });
}

function addRBTClickEvent(){
    $('.addRBT').unbind('click');
    $('.addRBT').on('click',function(){
        holder = $(this).closest('.form-group');
        id = holder.attr('data-id');

        el = '<div class="choice">';
        el += '<input type="text" name="question['+id+'][choices]['+choiceCount+'][choice]">&nbsp;<select class="rateSelect" name="question['+id+'][choices]['+choiceCount+'][rate]"></select><span class="glyphicon glyphicon-remove-sign delete-choice" aria-hidden="true"></span><br>';
        el += '</div>';

        holder.find('.field-group .choice').last().after(el);

        updateRateSelect();
        addDeleteChoiceClickEvent();
        choiceCount++;
    });
}

function addDeleteChoiceClickEvent(){
    $('.delete-choice').unbind('click');
    $('.delete-choice').on('click',function(){
        holder = $(this).closest('.choice').remove();
    });
}

function addDeleteQuestionClickEvent(){
    console.log('adding');
    $('#surveyElements .delete-question').unbind('click');
    $('#surveyElements .delete-question').on('click',function(){

        console.log('deleting');
        console.log($(this).closest('.form-group'));
        $(this).closest('.form-group').remove();
    });
}

function updateSortable(){
    setTimeout(function(){
        $( "#surveyElements" ).sortable( "refresh" );
    },300);
}

$( "#surveyElements" ).sortable({
    tolerance: 'pointer',
    stop : function( event, ui ){
        updateOrder();
    }
});

function updateOrder(){
    order = 1;
    $('#surveyElements .form-group').each(function(e,i){
        $(i).find('.count').val(order);
        order++;
    });
}

//        $('#submitForm').on('click',function(){
//            $('#surveyElements').clone().appendTo('#surveyForm');
//            $('#surveyForm').submit();
//        });