$('#add-file').on('click',function(){
    index = $('#file-uploads .file-upload').length + 1;

    el = '\n' +
        '            <div class="file-upload card-box">\n' +
        '                <div class="row">\n' +
        '                <button class="remove-box" type="button">X</button>\n' +
        '                    <div class="col-md-6">\n' +
        '                        <div class="form-group">\n' +
        '                            <label>Square Image(1000x1000):</label>\n' +
        '                            <input type="file" class="form-control" name="images['+index+'][square]" placeholder="Upload Image">\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '                    <div class="col-md-6">\n' +
        '                        <div class="form-group">\n' +
        '                            <label>Landscape Image(1000x600):</label>\n' +
        '                            <input type="file" class="form-control" name="images['+index+'][landscape]" placeholder="Upload Image">\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '                <div class="row">\n' +
        '                    <div class="col-md-6">\n' +
        '                        <div class="form-group">\n' +
        '                            <label>Image Caption EN:</label>\n' +
        '                            <input type="text" class="form-control" placeholder="Image Caption EN" name="captions['+index+'][EN]">\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '                    <div class="col-md-6">\n' +
        '                        <div class="form-group">\n' +
        '                            <label>Image Caption AR:</label>\n' +
        '                            <input type="text" class="form-control" placeholder="Image Caption AR" name="captions['+index+'][AR]">\n' +
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
