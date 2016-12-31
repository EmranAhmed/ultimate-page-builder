<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );


    add_action( 'upb_register_layout', function ( $layout ) {

        $template = array(
            'title'    => 'Blank',
            'desc'     => 'Blank Page',
            'template' => '[{"tag":"section","contents":[{"tag":"row","contents":[{"tag":"column","contents":[{"tag":"text","contents":"<p style=\"text-align: center\"><a href=\"http://wp-starter.dev/2016/10/24/post-check/\"><strong>Put </strong></a></p><p>Contents</p>","attributes":{"title":"Text Title","enable":true,"background":"#81d742"}}],"attributes":{"title":"Column 1","lg":"","md":"","sm":"","xs":"1:2","background":"#ffccff"}},{"tag":"column","contents":[{"tag":"text","contents":"<p>Put Contents</p>","attributes":{"title":"Text Title","enable":true,"background":"#dd9933"}}],"attributes":{"title":"Column 1","lg":"","md":"","sm":"","xs":"1:2","background":"#ffccff"}}],"attributes":{"title":"Row 1","enable":true,"background":"#fff","background-image":"","container":"upb-container-fluid"}}],"attributes":{"multi":["1"],"multix":["1","3"],"hide":[],"bgimageposition":"0% 0%","bgimage":"","title":"Section b","enable":true,"background-color":"#ffccff"}}]',
            'preview'  => ''
        );

        $layout->register( $template );


        $template2 = array(
            'title'    => 'Layout',
            'desc'     => 'Layout Page',
            'template' => '[{"tag":"section","contents":[{"tag":"row","contents":[{"tag":"column","contents":[{"tag":"text","contents":"<p style=\"text-align: center;padding-left: 30px\"><a href=\"http://wp-starter.dev/2016/10/24/post-check/\"><strong>Put </strong></a></p><p>Contents</p>","attributes":{"title":"Text Title","enable":true,"background":"#81d742"}}],"attributes":{"title":"Column 1","lg":"","md":"","sm":"","xs":"1:1","background":"#ffccff"}}],"attributes":{"title":"Row 1","enable":true,"background":"#fff","background-image":"","container":"upb-container-fluid"}}],"attributes":{"ajaxpost":"","icon":"","multi":["1"],"multix":["1","3"],"hide":[],"bgimageposition":"0% 0%","bgimage":"","title":"Section A","enable":true,"background-color":"#ffccff"}},{"tag":"section","contents":[{"tag":"row","contents":[{"tag":"column","attributes":{"title":"Column 1","lg":"","md":"","sm":"","xs":"1:1","background":"#ffccff"},"contents":[{"tag":"text","contents":"<p>Put Contents</p>","attributes":{"title":"Text Title","enable":true,"background":"#eeee22"}}]}],"attributes":{"title":"Row 1","enable":true,"background":"#fff","background-image":"","container":"upb-container-fluid"}}],"attributes":{"ajaxpost":"57","icon":"","multi":["1"],"multix":["1","3"],"hide":[],"bgimageposition":"47% 53%","bgimage":"http://wp-starter.dev/wp-content/uploads/2016/12/butterflay.jpg","title":"Section B","enable":true,"background-color":"#ffccff"}}]',
            'preview'  => ''
        );

        $layout->register( $template2 );





    } );


