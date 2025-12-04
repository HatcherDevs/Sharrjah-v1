$('#add-file').on('click',function(){
    index = $('#file-uploads .file-upload').length + 1;

    el = '<div class="file-upload card-box">\n' +
        '                <div class="row">\n' +
        '                    <div class="col-md-12">\n' +
        '                        <div class="form-group">\n' +
        '                            File:' +
        '                            <input type="file" class="form-control" name="files['+index+']" placeholder="Upload Image">\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '                <div class="row">\n' +
        '                    <div class="col-md-6">\n' +
        '                        <div class="form-group">\n' +
        '                            <label>File title EN:</label>\n' +
        '                            <input type="text" class="form-control" placeholder="Title EN" name="captions['+index+'][EN]">\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '                    <div class="col-md-6">\n' +
        '                        <div class="form-group">\n' +
        '                            <label>File title AR:</label>\n' +
        '                            <input type="text" class="form-control" placeholder="Title AR" name="captions['+index+'][AR]">\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>';

    $('#file-uploads').append(el);

    removeBoxBtEvent();
});

function removeBoxBtEvent(){
    $('.remove-box').on('click',function(){
        $(this).closest('.file-upload').remove();
    });
}

$(document).ready(function(){
    removeBoxBtEvent();
});
