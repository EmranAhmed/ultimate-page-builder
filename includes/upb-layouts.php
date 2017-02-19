<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    add_action( 'upb_register_layout', function ( $layout ) {

        // $layout->reset(); // Reset All previous layouts and add new :)

        $template = array(
            'title'    => 'Two Column Simple',
            'desc'     => 'Simple Two Column Layout',
            'template' => '[{"tag":"upb-section","contents":[{"tag":"upb-row","contents":[{"tag":"upb-column","contents":[{"tag":"upb-accordion","contents":[{"tag":"upb-accordion-item","contents":"<p>Authoritatively formulate one-to-one interfaces with sustainable information. Collaboratively impact value-added meta-services rather than superior growth.</p>","attributes":{"title":"Accordion Item 1","enable":true,"active":true}},{"tag":"upb-accordion-item","contents":"<p>Holisticly customize top-line leadership skills for wireless solutions. Appropriately actualize principle-centered products rather than sustainable.</p>","attributes":{"title":"Accordion Item 2","enable":true,"active":false}}],"attributes":{"title":"Accordion","enable":true,"hidden-device":[],"element_class":"","element_id":""}}],"attributes":{"title":"Column 1","hidden-device":[],"lg":"","md":"","sm":"","xs":"1:2"}},{"tag":"upb-column","contents":[{"tag":"upb-text","contents":"<p>Completely implement installed base expertise with front-end portals. Appropriately coordinate standards compliant e-business and unique.</p>","attributes":{"title":"Title","enable":true,"hidden-device":[],"element_class":"","element_id":""}}],"attributes":{"title":"Column 1","hidden-device":[],"lg":"","md":"","sm":"","xs":"1:2"}}],"attributes":{"title":"Row 1","enable":true,"hidden-device":[],"container":"upb-container-fluid"}}],"attributes":{"title":"Section 1","background-type":"none","background-color":"#ffffff","background-image":"http://wp-starter.dev/wp-content/uploads/2016/12/butterflay.jpg","background-position":"48% 70%","enable":true,"hidden-device":[],"element_class":"","element_id":""}}]',
            'preview'  => ''
        );

        $layout->register( $template );

    } );
