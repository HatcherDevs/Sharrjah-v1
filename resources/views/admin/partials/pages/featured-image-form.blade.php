<div class="form-group" style="border-top:3px solid #ccc" >
    <br/>
    <strong>Add a featured image</strong>
    <br/>
    <br/>
    <div class="row">
        <div class="col-md-12" id="file-uploads">
            <div class="file-upload card-box">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Square Image(1000x1000):</label>
                            <input type="file" class="form-control" name="images[1][square]" placeholder="Upload Image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Landscape Image(1000x600):</label>
                            <input type="file" class="form-control" name="images[1][landscape]" placeholder="Upload Image">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Image Caption EN:</label>
                            <input type="text" class="form-control" placeholder="Image Caption EN" name="captions[1][EN]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Image Caption AR:</label>
                            <input type="text" class="form-control" placeholder="Image Caption AR" name="captions[1][AR]">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <button class="form-control" id="add-file" type="button">Add more images</button>
            </div>
        </div>
    </div>
</div>