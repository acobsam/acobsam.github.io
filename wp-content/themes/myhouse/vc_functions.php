<?php 
$args = array(
  'posts_per_page'   => -1,
  'offset'           => 0,
  'category'         => '',
  'category_name'    => '',
  'orderby'          => 'post_title',
  'order'            => 'ASC',
  'include'          => '',
  'exclude'          => '',
  'meta_key'         => '',
  'meta_value'       => '',
  'post_type'        => 'page',
  'post_mime_type'   => '',
  'post_parent'      => '',
  'post_status'      => 'publish',
  'suppress_filters' => true 
);
$pages = get_posts( $args );
$lists_page = array();
foreach($pages as $p){
  $lists_page[$p->post_title] = $p->ID;
}

//Service

if(function_exists('vc_map')){

vc_map( array(
   "name" => esc_html__("QK Featured","myhouse"),
   "base" => "nk_featured",
   "class" => "",
   "category" => esc_html__("Content", "myhouse"),
   "icon" => "icon-qk",
   "params" => array(
	 
	   array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Title","myhouse"),
         "param_name" => "title",
         "value" => "",
         "description" => esc_html__('Enter title', 'myhouse')
      ),
	   
     array(
         "type"      => "attach_image",
         "holder"    => "div",
         "class"     => "",
         "heading"   => esc_html__("Service Icon Image", 'myhouse'),
         "param_name"=> "image",
         "value"     => "",
         "description" => esc_html__("Upload Image", 'myhouse')
      ),
	  array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Custom Link","myhouse"),
         "param_name" => "link",
         "value" => "#",
         "description" => esc_html__('Enter custom link', 'myhouse')
      ),
	  array(
         "type" => "textarea",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Content ","myhouse"),
         "param_name" => "content",
         "value" => '',
         "description" => esc_html__('Enter description', 'myhouse')
      ),
   )
) );

}
class WPBakeryShortCode_nk_featured extends WPBakeryShortCode {
}

vc_map( array(
    "name" => esc_html__("QK Panel Parent", "myhouse"),
    "base" => "qk_panel_parent",
    "as_parent" => array('only' => 'qk_panel'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_unique" => true,
    "show_settings_on_create" => false,
    "params" => array(
        // add params same as with any other content unique
        array(
            "type" => "textfield",
            "heading" => esc_html__("ID name", "myhouse"),
            "param_name" => "el_id",
            "description" => esc_html__("If you wish to style particular content unique differently, then use this field to add a class name and then refer to it in your css file.", "myhouse")
        )
    ),
    "js_view" => 'VcColumnView'
) );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_qk_panel_parent extends WPBakeryShortCodesContainer {
    }
}

//QK Panel
if(function_exists('vc_map')){
  vc_map( array(
      "name" => esc_html__("QK Panel","myhouse"),
      "base" => "qk_panel",
      "class" => "",
      "category" => esc_html__("Content", "myhouse"),
      "icon" => "icon-qk",
      "params" => array(
         array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Font icon","myhouse"),
         "param_name" => "icon",
         "value" => "",
         "description" => esc_html__('Enter font-icon for heading, ex:fa-check','myhouse')
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Title","myhouse"),
        "param_name" => "title",
        "value" => "",
        "description" => esc_html__('Enter title', 'myhouse')
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Data id","myhouse"),
        "param_name" => "el_id",
        "value" => "",
        "description" => esc_html__('I\'s must unique', 'myhouse')
      ),
      array(
        "type" => "dropdown",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Type panel","myhouse"),
        "param_name" => "el_class",
        "value" => array('None'=>'none','Dimensions'=>'dimensions','Rom'=>'room'),
        "description" => esc_html__('Choose type panel, ex: Dimensions', 'myhouse')
      ),
      
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Data parent","myhouse"),
        "param_name" => "parent",
        "value" => "accordion",
        "description" => esc_html__('I\'s attribute ID of wrap element', 'myhouse')
      ),
      array(
        "type" => "checkbox",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Data expand","myhouse"),
        "param_name" => "expanded",
        "value" => array('yes'=>1),
        "description" => esc_html__('Check this if you wan\'t expanded panel body when site loaded', 'myhouse')
      ),
      array(
        "type" => "textarea_html",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Description","myhouse"),
        "param_name" => "content",
        "value" =>'',
        "description" => esc_html__('Enter description', 'myhouse')
      )
      
      
      )
  ) );
}
class WPBakeryShortCode_qk_panel extends WPBakeryShortCode {}

//QK Category Filter
if(function_exists('vc_map')){
  vc_map( array(
    "name" => esc_html__("QK Terms Filter","myhouse"),
    "base" => "qk_cat",
    "class" => "",
    "category" => esc_html__("Content", "myhouse"),
    "icon" => "icon-qk",
    "params" => array(
      array(
        "type" => "dropdown",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Choose terms type","myhouse"),
        "param_name" => "type",
        "value" => array('Category'=>'category','Gallery Type'=>'gallery_type'),
        "description" => esc_html__('Choose category type, ex: Gallery Type', 'myhouse')
      )
      
    )
  ) );
}
class WPBakeryShortCode_qk_cat extends WPBakeryShortCode {}

//QK Gallery
if(function_exists('vc_map')){
  vc_map( array(
    "name" => esc_html__("QK Gallery","myhouse"),
    "base" => "qk_gallery",
    "class" => "",
    "category" => esc_html__("Content", "myhouse"),
    "icon" => "icon-qk",
    "params" => array(
      array(
        "type" => "attach_image",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Upload or enter url image","myhouse"),
        "param_name" => "file",
        "value" => "",
        "description" => esc_html__('Choose image effect for hover', 'myhouse')
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Total item","myhouse"),
        "param_name" => "order",
        "value" => "-1",
        "description" => esc_html__('Set max limit for items in loop or enter -1 to display all (limited to 1000).', 'myhouse')
      ),
      
      array(
        "type" => "dropdown",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Button link","myhouse"),
        "param_name" => "btn_link",
        "value" => $lists_page, //lists_page
        "description" => esc_html__('Choose page for button link', 'myhouse')
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Button Name","myhouse"),
        "param_name" => "btn_name",
        "value" => "",
        "description" => esc_html__('Enter button name, ex:view all photos', 'myhouse')
      ),
      
      
      
    )
  ) );
}
class WPBakeryShortCode_qk_gallery extends WPBakeryShortCode {}

if(function_exists('vc_map')){
vc_map( array(
   "name" => esc_html__("QK location info","myhouse"),
   "base" => "qk_location",
   "class" => "",
   "category" => esc_html__("Content", "myhouse"),
   "icon" => "icon-qk",
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Font icon","myhouse"),
         "param_name" => "icon",
         "value" => "",
         "description" => esc_html__('Enter font icon awesome, ex: fa-graduation-cap', 'myhouse')
      ),
     array(
         "type" => "textarea_html",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Location info","myhouse"),
         "param_name" => "content",
         "value" => '',
         "description" => esc_html__('Enter location info', 'myhouse')
      )
   )
) );

}
class WPBakeryShortCode_qk_location extends WPBakeryShortCode {
}

// qk_map
if(function_exists('vc_map')){
vc_map( array(
   "name" => esc_html__("QK Map","myhouse"),
   "base" => "qk_map",
   "class" => "",
   "category" => esc_html__("Content", "myhouse"),
   "icon" => "icon-qk",
   "params" => array(
   
     array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Lat","myhouse"),
         "param_name" => "lat",
         "value" => "",
         "description" => esc_html__('Enter latitude for map', 'myhouse')
      ),
     array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Lon","myhouse"),
         "param_name" => "lon",
         "value" => "", esc_html__('Enter longitude for map', 'myhouse')
      ),
     array(
         "type" => "attach_image",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Maker","myhouse"),
         "param_name" => "maker",
         "value" => "",
         "description" => esc_html__('Choose marker icon for map', 'myhouse')
      )
   )
) );


}
class WPBakeryShortCode_qk_map extends WPBakeryShortCode {
}

//QK Title
if(function_exists('vc_map')){
  vc_map( array(
    "name" => esc_html__("QK Title","myhouse"),
    "base" => "qk_title",
    "class" => "",
    "category" => esc_html__("Content", "myhouse"),
    "icon" => "icon-qk",
    "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Icon name","myhouse"),
         "param_name" => "icon",
         "value" => "",
         "description" => esc_html__('Enter a character use for icon, ex: H/G/B','myhouse')
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Title","myhouse"),
        "param_name" => "title",
        "value" => "",
        "description" => esc_html__('Enter description', 'myhouse')
      ),
      array(
        "type" => "textarea_html",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Description","myhouse"),
        "param_name" => "content",
        "value" =>'',
        "description" => ''
      ),
      
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Extra class name","myhouse"),
        "param_name" => "el_class",
        "value" => "fadeInUp",
        "description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'myhouse')
      ),
    )
  ) );
}
class WPBakeryShortCode_qk_title extends WPBakeryShortCode {}

//QK Agency
if(function_exists('vc_map')){
  vc_map( array(
    "name" => esc_html__("QK Agency","myhouse"),
    "base" => "qk_agency",
    "class" => "",
    "category" => esc_html__("Content", "myhouse"),
    "icon" => "icon-qk",
    "params" => array(
      array(
        "type" => "attach_image",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Upload or enter url image","myhouse"),
        "param_name" => "agcy1",
        "value" => "",
        "description"=> esc_html__('Choose image icon, this use for display', 'myhouse')
      ),
      array(
        "type" => "attach_image",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Upload or enter url image hover","myhouse"),
        "param_name" => "agcy2",
        "value" => "",
        "description" => esc_html__('Choose image icon, this display when hover', 'myhouse')
      ),
      array(
        "type" => "textarea_html",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Description","myhouse"),
        "param_name" => "content",
        "value" =>'',
        "description" => esc_html__('Enter description', 'myhouse')
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Extra class name","myhouse"),
        "param_name" => "el_class",
        "value" => "col-sm-4",
        "description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'myhouse')
      ),
      
      
    )
  ) );
}
class WPBakeryShortCode_qk_agency extends WPBakeryShortCode {}

//QK Progress
if(function_exists('vc_map')){
  vc_map( array(
    "name" => esc_html__("QK Progress","myhouse"),
    "base" => "qk_progressbar",
    "class" => "",
    "category" => esc_html__("Content", "myhouse"),
    "icon" => "icon-qk",
    "params" => array(
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Title","myhouse"),
        "param_name" => "title",
        "value" => "",
        "description" => esc_html__('Enter title here', 'myhouse')
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Progress rate (%)","myhouse"),
        "param_name" => "skill",
        "value" => '',
        "description" => esc_html__('Enter skill rate in range 0-100%', 'myhouse')
      ),
      
    )
  ) );
}
class WPBakeryShortCode_qk_progressbar extends WPBakeryShortCode {}

//QK About
if(function_exists('vc_map')){
  vc_map( array(
    "name" => esc_html__("QK About agent","myhouse"),
    "base" => "qk_about",
    "class" => "",
    "category" => esc_html__("Content", "myhouse"),
    "icon" => "icon-qk",
    "params" => array(
      array(
        "type" => "attach_image",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Upload or enter url image","myhouse"),
        "param_name" => "agcy1",
        "value" => "",
        "description"=> esc_html__('Choose image icon, this use for display', 'myhouse')
      ),
      array(
        "type" => "attach_image",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Upload or enter url image hover","myhouse"),
        "param_name" => "agcy2",
        "value" => "",
        "description" => esc_html__('Choose image icon, this display when hover', 'myhouse')
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Contact info","myhouse"),
        "param_name" => "contact_info1",
        "value" =>'',
        "description" => esc_html__('Enter contact info (type), ex:contact@myagent.com', 'myhouse')
      ),
      array(
        "type" => "textarea",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Contact desc","myhouse"),
        "param_name" => "contact_info2",
        "value" =>'',
        "description" => esc_html__('Enter contact info (desc/support), ex:You will be receive answer...', 'myhouse')
      ),
      
    )
  ) );
}
class WPBakeryShortCode_qk_about extends WPBakeryShortCode {}

//QK Social
if(function_exists('vc_map')){
  vc_map( array(
    "name" => esc_html__("QK Social","myhouse"),
    "base" => "qk_social",
    "class" => "",
    "category" => esc_html__("Content", "myhouse"),
    "icon" => "icon-qk",
    "params" => array(
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Twitter link","myhouse"),
        "param_name" => "twlink",
        "value" => '', //lists_page
        "description" => esc_html__('Enter your twitter link', 'myhouse')
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Twitter Name","myhouse"),
        "param_name" => "twname",
        "value" => "",
        "description" => esc_html__('Enter title twitter, ex: Follow me on Twitter', 'myhouse')
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Facebook link","myhouse"),
        "param_name" => "fblink",
        "value" => '', //lists_page
        "description" => esc_html__('Enter your facebook link', 'myhouse')
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Facebook Name","myhouse"),
        "param_name" => "fbname",
        "value" => "",
        "description" => esc_html__('Enter title facebook, ex: Follow me on Facebook', 'myhouse')
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Extra class name","myhouse"),
        "param_name" => "el_class",
        "value" => "agentSocial",
        "description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'myhouse')
      ),
      
    )
  ) );
}
class WPBakeryShortCode_qk_social extends WPBakeryShortCode {}


//QK Blog
if(function_exists('vc_map')){
  vc_map( array(
    "name" => esc_html__("QK Blog","myhouse"),
    "base" => "qk_blog",
    "class" => "",
    "category" => esc_html__("Content", "myhouse"),
    "icon" => "icon-qk",
    "params" => array(
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Total item","myhouse"),
        "param_name" => "order",
        "value" => "-1",
        "description" => esc_html__('Set max limit for items in loop or enter -1 to display all (limited to 1000).', 'myhouse')
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Extra class name","myhouse"),
        "param_name" => "el_class",
        "value" => "",
        "description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'myhouse')
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "class" => "",
        "heading" => esc_html__("Read more","myhouse"),
        "param_name" => "btn_name",
        "value" => "",
        "description" => esc_html__('Enter name readmore link, ex:Read more ', 'myhouse')
      )    
    )
  ) );
}
class WPBakeryShortCode_qk_blog extends WPBakeryShortCode {}


// qk_testimonial
if(function_exists('vc_map')){
vc_map( array(
   "name" => esc_html__("QK Testimonial","myhouse"),
   "base" => "qk_testimonial",
   "class" => "",
   "category" => esc_html__("Content", "myhouse"),
   "icon" => "icon-qk",
   "params" => array(
   
     array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Total item","myhouse"),
         "param_name" => "order",
         "value" => "-1",
         "description" => esc_html__('Set max limit for items in loop or enter -1 to display all (limited to 1000).', 'myhouse')
      )
     
   )
) );


}
class WPBakeryShortCode_qk_testimonial extends WPBakeryShortCode {
}

if(function_exists('vc_map')){
vc_map( array(
   "name" => esc_html__("QK Contact info","myhouse"),
   "base" => "qk_contact",
   "class" => "",
   "category" => esc_html__("Content", "myhouse"),
   "icon" => "icon-qk",
   "params" => array(
      array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Contact icon","myhouse"),
         "param_name" => "icon",
         "value" => array('None'=>'','Location'=>'hexagon2','Phone'=>'hexagon3','Email'=>'hexagon1'),
         "description" => esc_html__('Choose icon type','myhouse'),
         "std" => ''
      ),
     array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Type","myhouse"),
         "param_name" => "type",
         "value" => "",
         "description" => esc_html__('Enter your type/name/method of contact, ex:Email address:', 'myhouse')
      ),
     array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Contact info","myhouse"),
         "param_name" => "contact_info",
         "value" => '',
         "description" => esc_html__('Enter contact info (description)', 'myhouse')
      )

   )
) );

}
class WPBakeryShortCode_qk_contact extends WPBakeryShortCode {
}
?>