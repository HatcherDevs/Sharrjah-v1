<!-- partial:partials/_footer.html -->
<footer class="footer">
    <div class="container-fluid clearfix">
        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018
            <a href="http://www.thisishatch.com/" target="_blank">Hatch</a>. All rights reserved.
        </span>
    </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="{{ asset('public/admin') }}/vendors/js/vendor.bundle.base.js"></script>
<script src="{{ asset('public/admin') }}/vendors/js/vendor.bundle.addons.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="{{ asset('public/admin') }}/js/off-canvas.js"></script>
<script src="{{ asset('public/admin') }}/js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{ asset('public/admin') }}/js/dashboard.js"></script>
<!-- End custom js for this page-->
<!-- include summernote css/js -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- include summernote-ko-KR -->
<script src="{{ asset('public/admin') }}/js/summernote-image-attributes.js"></script>
<script src="{{ asset('public/admin') }}/lang/summernote-ar-AR.js"></script>
</body>
<script>
    $('.summernote').summernote({
        placeholder: 'Add content here...',
        tabsize: 2,
        height: 300,
        callbacks: {
            onPaste: function(e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData(
                    'Text');
                e.preventDefault();
                document.execCommand('insertText', false, bufferText);
            }
        },
        letters: ["8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23",
            "24", "32", "48", "72", "112", "127", "254", "500"
        ],
        fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '22', '24', '28', '30', '32', '34',
            '36', '38'
        ],
        toolbar: [
            ['letter', ['letter', "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19",
                "20", "21", "22", "23", "24", "32", "48", "72", "112", "127", "254", "500"
            ]],
            ['fontNames', ['fontname', 'Inter', 'Roboto Light', 'Roboto Regular', 'Roboto Bold',
                'Thai Sans Neue Light', 'Thai Sans Neue Regular', 'Thai Sans Neue Bold'
            ]],
            ['fontNamesIgnoreCheck', ['Inter', 'Roboto Light', 'Roboto Regular', 'Roboto Bold',
                'Thai Sans Neue Light', 'Thai Sans Neue Regular', 'Thai Sans Neue Bold'
            ]],
            ['fontsize', ['fontsize']],
            ['fontsizeunit', ['fontsizeunit']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['style', ['style']],
            ['insert', ['picture', 'hr', 'video']],
            ['table', ['table']],
            ['view', ['codeview']],
            ['link', ['link']],
        ],
        popover: {
            image: [
                ['custom', ['imageAttributes']],
                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ],
        },
        imageAttributes: {
            icon: '<i class="note-icon-pencil"/>',
            removeEmpty: false, // true = remove attributes | false = leave empty if present
            disableUpload: false // true = don't display Upload Options | Display Upload Options
        }

    });

    $('.summernote').on('summernote.change', function(we, contents, $editable) {
        console.log($(this).closest('.form-group'));
        $(this).closest('.form-group').find('input').val(contents);
        console.log('summernote\'s content is changed.');
    });

    $('#summernote').summernote('fontName', 'Inter');
    $('#summernote').summernote({
        fontNames: ['Arial', 'Inter', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact',
            'Tahoma', 'Times New Roman', 'Verdana', 'Roboto'
        ],
        fontNamesIgnoreCheck: ['Inter']
    });

    $('.external-switch').change(function() {
        if (this.checked) {
            $(this).closest('.card-body').find('.content').hide();
            $(this).closest('.card-body').find('.link').show();
        } else {
            $(this).closest('.card-body').find('.content').show();
            $(this).closest('.card-body').find('.link').hide();
        }
    });

    $(document).ready(function() {

        $('.type_select').on('change', function() {
            lang = $(this).attr('data-lang');
            $(this).closest('.card-body').find('.type-box').hide();
            $(this).closest('.card-body').find('.type-box input').val('');

            if ($(this).val() != 'blank')
                $(this).closest('.card-body').find('.type-box.' + $(this).val()).show();
            else
                $(this).closest('.card-body').find('.type-box.url input').val('#');

            if ($(this).val() != "page")
                $(this).closest('.card-body').find('.content').hide();
        });

        $('#type_select').trigger('change');

        $('.datetimepicker').datepicker({
            dateFormat: 'm/d/y'
        });
    });
</script>

<script>
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("dataTable");
        switching = true;
        // Set the sorting direction to ascending:
        dir = "asc";
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /* Loop through all table rows (except the
            first, which contains table headers): */
            for (i = 1; i < (rows.length - 1); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /* Check if the two rows should switch place,
                based on the direction, asc or desc: */
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /* If a switch has been marked, make the switch
                and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                // Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /* If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again. */
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>

<script type='text/javascript' src="{{ url('public/froala_editor/js/froala_editor.pkgd.min.js') }}"></script>

<script>
    setInterval(() => {
        $('.summernote').summernote();
        $('#summernote').summernote();
    }, 10);

    new FroalaEditor('#editor', {
        fontFamily: {
            "'Inter', sans-serif": 'Inter',
            "Roboto,sans-serif": 'Roboto',
            "Oswald,sans-serif": 'Oswald',
            "Montserrat,sans-serif": 'Montserrat',
            "'Open Sans Condensed',sans-serif": 'Open Sans Condensed'
        },
        fontFamilySelection: true,
        // Image upload settings
        imageUploadURL: '{{ url('admin/upload-image') }}',
        imageUploadParams: {
            _token: '{{ csrf_token() }}'
        },
        imageUploadMethod: 'POST',
        imageMaxSize: 5 * 1024 * 1024, // 5MB
        imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif', 'webp'],
        // Events
        events: {
            'image.error': function(error, response) {
                console.log('Froala image error:', error, response);
                alert('Image upload error: ' + (response ? response : error.message || 'Unknown error'));
            },
            'image.uploaded': function(response) {
                console.log('Image uploaded successfully:', response);
            }
        }
    })

    $(window).on('load', function() {
        // $('#loader').hide();
        document.querySelectorAll('a').forEach(ele => {
            if (ele.text ==
                "Unlicensed copy of the Froala Editor. Use it legally by purchasing a license.") {
                ele.style.padding = "0px";
                ele.text = "";
            }
        })
    });


    // setInterval(() => {
    //     document.querySelectorAll('a').forEach(ele=>{
    //         if(ele.text =="Unlicensed copy of the Froala Editor. Use it legally by purchasing a license."){
    //             ele.style.padding="0px";
    //             ele.text="";
    //         }
    //     })
    // },100);



    //   setInterval(() => {
    //     document.querySelectorAll('a').forEach(ele=>{
    //         if(ele.text =="Unlicensed copy of the Froala Editor. Use it legally by purchasing a license."){
    //             ele.style.padding="0px";
    //             ele.text="";
    //         }
    //     })
    //     document.querySelectorAll('a').forEach(ele=>{
    //         if(ele.text =="Unlicensed copy of the Froala Editor. Use it legally by purchasing a license."){
    //             ele.style.display="none"
    //         }
    //     })
    //     document.querySelectorAll('#fr-logo').forEach(ele=>{
    //         $(ele).remove()
    //     })
    //     $('#fr-logo').remove();
    //     document.querySelectorAll('[data-f-id="pbf"]').forEach(ele=>{
    //         $(ele).remove()
    //     })
    //     $('[data-f-id="pbf"]').remove()
    //   }, 100);
</script>
<style>
    /* .show-placeholder a{
        display: none;
    }
    /* #fr-logo{
        display: none;
    } */
    div[style="z-index:9999;width:100%;position:relative"],
    a[href="https://www.froala.com/wysiwyg-editor?k=u"] {
        opacity: 0 !important;
        top: 9000000000000000000000000000px !important;
</style>

@yield('js')

</html>
