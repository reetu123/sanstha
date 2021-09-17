<form id="fileupload" action="<?php print(admin_url() . 'admin-ajax.php'); ?>" method="POST"
      enctype="multipart/form-data">
    <div class="image-container">

        <label>Profile Photo Upload </label>
        <div role="presentation" class="clearfix upload-photo-wrap">
            <div class="files"></div>
        </div>
        <div class="upload-wrap">
            <div class="upload_box">
                <input type="hidden" name="action" value="km_load_upload_pics_ajax"/>
                <div class="fileupload-buttonbar">
                    <div class="fileupload-buttons">
                        <span class="fileinput-button">
                            <span class="img-add-edit button button-uploadtext">Change</span>
                            <input id="fileupload" type="file" name="files">
                        </span>
                        <!-- http://localhost/woofy/wp-admin/admin-ajax.php?file=banner-3.jpg&action=km_load_upload_pics_ajax -->
                    </div>
                    <!-- The global progress state -->
                    <div class="fileupload-progress jqhfu-fade"
                         style="display:none;max-width:500px;margin-top:2px;">
                        <!-- The global progress bar -->
                        <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                        <!-- The extended global progress state -->
                        <div class="progress-extended">&nbsp;</div>
                    </div>
                </div>
                <!-- The table listing the files available for upload/download -->

            </div>
        </div>
         <span class="success">Note: Image dimension should be within 300 X 300</span>
    </div>


    <h3 id="upload-msg" class="success"></h3>

        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls"  data-filter=":even">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="close">×</a>


        </div>

    <?php
    global $km;
    ?>

    <script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}

    <div class="template-upload">
        <div class="albums-list-bg-gray">
            <span class="preview"></span>
        </div>
        <p><a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
           <p class="size">Processing...</p>
           <div class="progress"></div>
           <p>
             {% if (!i && !o.options.autoUpload) { %}
             <button class="start icon_photos" disabled>Upload<i class="fa fa-cloud-upload"></i></button>
             {% } %}
         </p>

     </div>
     {% } %}
 </script>
    <script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <div  class="template-download">
        <div class="album-photo-list">
            {%=file.false%}
            {% if (file.mediumUrl) { %}

            <div class="albums-list-bg-gray">
                <a href="{%=file.url%}" title="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%} >
                    <img src="{%=file.mediumUrl%})">
                      </a>
                </div>

            <a href="{%=file.url%}" title="{%=file.name%}"  {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.filename%}</a>
        </div>
        {% } %}
        <div class="file_btns">
            <span class="fileinput-button">
                <button class=" icon_photos_delete button button-primary" data-url="{%=file
                .deleteUrl%}&action=km_load_upload_pics_ajax"><i class="fa fa-trash-o"></i> Remove</button>
            </span>
        </div>
    </div>
</div>
{% } %}
</script>
    <script type="text/javascript">
        var $fileupload
        jQuery(document).ready(function () {
            'use strict';

            // Initialize the jQuery File Upload widget:
          $fileupload=    jQuery('#fileupload').fileupload({
                url: '<?php print(admin_url('admin-ajax.php'));?>',
                add: function (e, data) {
                    jQuery("#upload-msg").html('');
                    if (e.isDefaultPrevented()) {
                        return false;
                    }
                    jQuery(".icon_photos_delete").each(function () {
                        var obj = jQuery(this);
                        jQuery.ajax({
                            method: 'DELETE',
                            // Uncomment the following to send cross-domain cookies:
                            //  xhrFields: {withCredentials: true},
                            url: jQuery(this).data('url'),
                            dataType: 'json'

                        }).always(function () {

                        }).done(function (result) {

                            jQuery(obj).parents('.template-download').remove();
                        });
                    })
                    data.process().done(function() {
                        data.submit();
                    });
                },
                limitConcurrentUploads:1,
                prependFiles: true,
                autoUpload: false,
                singleFileUploads: true,
                sequentialUploads: true,
                imageCrop: false // Force cropped images

            });

            jQuery(document).on('click', '.icon_photos_delete', function (e) {/* ... */

                e.preventDefault();
                var obj = jQuery(this);
                jQuery.ajax({
                    method: 'DELETE',
                    // Uncomment the following to send cross-domain cookies:
                    //  xhrFields: {withCredentials: true},
                    url: jQuery(this).data('url'),
                    dataType: 'json'

                }).always(function () {

                }).done(function (result) {

                    jQuery(obj).parents('.template-download').remove();

                    jQuery.ajax({
                        // Uncomment the following to send cross-domain cookies:
                        xhrFields: {withCredentials: true},
                        url: jQuery('#fileupload').fileupload('option', 'url'),
                        data: {action: "km_load_upload_pics_ajax"},
                        acceptFileTypes: /^image\/(gif|jpe?g|png)$/i,
                        dataType: 'json',
                        singleFileUploads: true,
                        imageCrop: false, // Force cropped images
                        context: jQuery('#fileupload')[0]
                    }).always(function () {
                        jQuery(this).removeClass('fileupload-processing');
                    }).done(function (result) {
                        jQuery(this).fileupload('option', 'done')
                            .call(this, jQuery.Event('done'), {
                                    result: result
                                }
                            );
                    });

                });
            })






            if (jQuery('#fileupload')) {
                // Load existing files:
                jQuery('#fileupload').addClass('fileupload-processing');
                // Load existing files:
                jQuery.ajax({
                    // Uncomment the following to send cross-domain cookies:
                    xhrFields: {withCredentials: true},
                    url: jQuery('#fileupload').fileupload('option', 'url'),
                    data: {action: "km_load_upload_pics_ajax"},
                    acceptFileTypes: /^image\/(gif|jpe?g|png)$/i,
                    dataType: 'json',
                    singleFileUploads: true,
                    imageCrop: false, // Force cropped images
                    context: jQuery('#fileupload')[0]
                }).always(function () {
                    jQuery(this).removeClass('fileupload-processing');
                }).done(function (result) {
                    jQuery(this).fileupload('option', 'done')
                        .call(this, jQuery.Event('done'), {
                                result: result
                            }
                        );
                });
            }

        });


    </script>

</form>