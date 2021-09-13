<?php
add_action('init','save_fields');
function save_fields(){

    if(isset($_REQUEST['page'])=='dab-settings' && isset($_POST['dab_submit'])){
        $data =  $_POST['fields'] ;
        update_option('dab_field_option_name','');
        update_option('dab_field_option_name',$data);
    }

}

function dab_add_meta_box() {
    $screens = array( 'site' );
    foreach ( $screens as $screen ) {
        add_meta_box(
            'dab',
            'User info',
            'dab_show_custom_meta_box',
            'voter-guide',
            'normal',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'dab_add_meta_box' );
function dab_show_custom_meta_box( $post ) {
    wp_nonce_field( 'dab', 'dab_nonce' );
    $dabdivision = get_post_meta( $post->ID, 'dab_division', true );
    $name = get_post_meta( $post->ID, 'dab_name', true );
    $office = get_post_meta( $post->ID, 'dab_office', true );
    $dab_state = get_post_meta( $post->ID, 'dab_state', true );
    $dab_img = get_post_meta( $post->ID, 'dab_img', true );
    $dab_election = get_post_meta( $post->ID, 'dab_election', true );
    $dab_status = get_post_meta( $post->ID, 'dab_status', true );
    $address = get_post_meta( $post->ID, 'dab_address', true );
    $zip = get_post_meta( $post->ID, 'dabzipcode', true );
    if(empty($dab_img)){ $iconURL= DAB_PATH_URL .'assets/img/dummy.png';  }else{ $iconURL=  $dab_img; }
    $banner_img = get_post_meta($post->ID,'post_banner_img',true);
    $loader= DAB_PATH_URL .'assets/img/loader.gif';
    $banner_eeeimg = get_post_meta($post->ID,'post_banner_img',true);
    if(is_array($banner_img)){ $banner_img ='';}else{ $banner_img = $banner_img; }

    ?>
    <div class="main_form-3 dab-voder-guid">
        <table width="100%" cellpadding="10px" cellspacing="0" border="0">
            <tr>
                <td width="20%">Name</td>
                <td width="80%"><input placeholder="" value="<?php echo $name; ?>" id="dab_name" name="dab_name" type="text" required /></td>
            </tr>
            <tr>
                <td width="20%">Street</td>
                <td width="80%"><input placeholder="Street Address" value="<?php echo $address; ?>" id="dab_address" name="dab_address" type="text" required /></td>
            </tr>        <tr>
                <td width="20%">Zip</td>
                <td width="80%"><input id="dabzip_code" name="dabzipcode" type="number" value="<?php echo $zip; ?>" placeholder="Enter Zip code" maxlength="5" /> </td>
            </tr>
            <tr>
                <td >State</td>
                <td >
                    <select id="dab_state" name="dab_state" required>
                        <?php
                        $state = array("Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "District of Columbia", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming");
                        $count = count($state);
                        $state_opt = Array("AL","AK","AZ","AR","CA","CO","CT","DE","DC","FL","GA","HI","ID","IL","IN","IA","KS","KY","LA","ME","MD","MA","MI","MN","MS","MO","MT","NE","NV","NH","NJ","NM","NY","NC","ND","OH","OK","OR","PA","RI","SC","SD","TN","TX","UT","VT","VA","WA","WV","WI","WY");
                        echo "<option value='' selected>Select State</option>";
                        for($i=1; $i<$count; $i++){
                            $s = ($state_opt[$i] == $dab_state)?'selected':'';
                            echo "<option value='$state_opt[$i]' data='$state[$i]' $s >$state[$i]</option>";
                        } ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Office</td>
                <td><input type="hidden" id="posthidden" value="<?php echo get_the_ID(); ?>">  <select name="dab_office" id="dab_office" selecte-ddata="<?php echo $office; ?>" required> <option value=""  >Select Office</option> </option> </select> <input type="hidden" name="dab-division" id="dab-division" value="<?php echo $dabdivision; ?>">
                    <img id="searchdab" style="display:none;"src="<?php echo $loader; ?>" width="30"> </td>
            </tr>
            <tr class="photo">

                <td>Photo</td>
                <td class="photo-insert"><?php echo multi_media_uploader_field( 'post_banner_img', $banner_img ); ?></td>

            </tr>
            <tr>
            <tr class="photo">
            <tr>
                <td>Election</td>
                <td>
                    <select name="dab_election" id="dab_election" required>
                        <option value="2021"<?php echo ($dab_election == '2021')?"selected":"" ?> >2021 </option>
                        <option value="2022"<?php echo ($dab_election == '2022')?"selected":"" ?> >2022</option>
                        <option value="2023"<?php echo ($dab_election == '2023')?"selected":"" ?> >2023</option>
                        <option value="2024"<?php echo ($dab_election == '2024')?"selected":"" ?> >2024</option>
                        <option value="2025"<?php echo ($dab_election == '2025')?"selected":"" ?> >2025</option>
                    </select>
                </td>
            </tr>
     
            <tr>
                <td>Status</td>
                <td>
                    <select name="dab_status" id="dab_status">
                        <option value="Approved" <?php echo ($dab_status == 'Approved')?"selected":"" ?> >Approved</option>
                        <option value="Pending"<?php echo ($dab_status == 'Pending')?"selected":"" ?>>Pending</option>
                        <option value="Decline" <?php echo ($dab_status == 'Decline')?"selected":"" ?>>Decline</option>
                    </select>
                </td>
            </tr>

            <?php




            $quednary  = get_option('dab_field_option_name');
            $count = count( $quednary);

            if($count >0){
                $i = 1;
                $a =  $quednary;
                foreach( $a as $key=>$fields ){
                    $a[$i]['field_value'] = get_field_value_dab($i);

                    $i++;
                }
                $i = 1;
                foreach( $a as $fields ){
                    if(array_key_exists("field_options",$fields)){
                        $field_option =$fields['field_options'] ;
                    }else{
                        $field_option = ''; }
                    $field_type = $fields['field_type'] ;
                    $selected = $fields['field_value'];

                    if (!empty($fields['field_name'])) {
                        ?>

                        <tr>
                            <td colspan="2" >
                                <div class="quednary" style="display:flex">
                                    <strong style="width:108px"> Question:</strong><p style="margin: 0 0 15px;"> <?php echo $fields['field_name']; ?></p>

                                </div>
                                <p> <?php 	$value = $fields['field_value'];

                                    echo  create_fields($field_type, $field_option,$i,$value,$selected);
                                    ?>     </p>
                            </td>
                        </tr>

                        <?php $i++; }  }} ?>


            <tr>
                <td colspan="2">
                    <input type="submit" name="save" id="publish" class="button button-primary button-large" value="Update">
                </td>
            </tr>
        </table>
    </div>

    <?php
}
//update_post_meta( 1312, 'dab_fields_data',  '') ;
function get_field_value_dab($key){
    $id = get_the_ID();
    $value = '';
    $data = get_post_meta($id, 'dab_fields_data', false );
    if(!empty($data)){
        foreach($data[0] as $keys => $values ){
            if($key == $keys){
                $value = $values['field_value'];
            }
        }
    }
    return $value;
}

function dab_save_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['dab_nonce'] ) ) {
        return;
    }


    if ( ! wp_verify_nonce( $_POST['dab_nonce'], 'dab' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }
    if ( ! isset( $_POST['dab_name'] ) ) {
        return;
    }

    $data =  $_POST['fields'];
    update_post_meta( $post_id, 'dab_division',  $_POST['dab-division']) ;
    update_post_meta( $post_id, 'dab_fields_data',  $_POST['fields']) ;
    update_post_meta( $post_id, 'dab_address', sanitize_text_field( $_POST['dab_address'] ) );

    update_post_meta( $post_id, 'dabzipcode', sanitize_text_field( $_POST['dabzipcode']));

    update_post_meta( $post_id, 'dab_name', sanitize_text_field( $_POST['dab_name'] ) );

    update_post_meta( $post_id, 'dab_office', sanitize_text_field( str_replace("'", "",$_POST['dab_office'])));

    update_post_meta( $post_id, 'dab_state', sanitize_text_field( $_POST['dab_state'] ) );

    update_post_meta( $post_id, 'dab_election', sanitize_text_field( $_POST['dab_election'] ));

    update_post_meta( $post_id, 'dab_status', sanitize_text_field( $_POST['dab_status'] ));
    $uploaddir = wp_upload_dir();




    if( isset( $_POST['post_banner_img'] ) ){
        update_post_meta( $post_id, 'post_banner_img', $_POST['post_banner_img'] );
    }
    update_post_meta( $post_id, 'dab_img', $attach_id);

}
add_action( 'save_post', 'dab_save_meta_box_data' );

function create_fields($field_type, $field_option,$index,$value,$selected){

    $checked ='';
    $output = '';
    if($field_type == 'text'){ if(is_array($value)){ $value = ''; }
        @$output .=  "<input type='{$field_type}' name='fields[{$index}][field_value]' value='$value' required>";

    }else if($field_type == 'select'){
        $output  .=  "<select name='fields[{$index}][field_value]' required >";
        $options = $field_option;
        $option  = explode(',',$options);
        foreach($option as $value){
            $s = ($selected == $value)?'selected':'';
            @$output .=  "<option value='{$value}' {$s}>{$value}</option>";

        }
        $output .= "</select>";
    }else if($field_type == 'checkbox'){
        $options = $field_option;

        if(is_array($selected)){ $slect = $selected; }else{ $slect = array($selected); }
        $option  = explode(',',$options);
        $s = '';
        if(is_array($option)){
            foreach($option as $value){
                if (!empty($slect)) {

                    if ( in_array($value, $slect) ){	$s = 'checked'; }else{ $s = ''; } }
                @$output .= "<div class='dab-radio dab-checkbox'><input type='checkbox'  name='fields[{$index}][field_value][]' value='{$value}' {$s} >{$value}</div>";
            }
        }
    }else if($field_type == 'textarea'){ if(is_array($value)){ $value = ''; }
        @$output .=  "<textarea id='' name='fields[{$index}][field_value]' placeholder='Type your message here...' required >$value</textarea> "  ;
    }
    return $output;
}

function questionnaire_fields($field_type, $field_name,$field_option,$index){
    $output = '';
    if($field_type == 'text' || $field_type == 'textarea'){ $field = ''; }else{
        $field = "<input type='text' value='{$field_option}' class='dabquestionnaire' name='fields[{$index}][field_options]'>"; }


    ?>	<tr class='row-<?php echo $index; ?> test' data-tr='<?php echo $index; ?>'>
        <td>
            <p class='dab-questions'>Question:</p>
            <input type='text' class='dabquestionnaire' name='fields[<?php echo $index; ?>][field_name]' value='<?php echo $field_name; ?>' />


            <select name='fields[<?php echo $index; ?>][field_type]' data-id='<?php echo $index; ?>' data-tr='row-<?php echo $index; ?>' class='select_type'>
                <option value='text'  <?php echo ($field_type == 'textarea')?"text":"" ?>>Text </option>
                <option value='select'  <?php echo ($field_type == 'select')?"selected":"" ?>  >Select </option>
                <option value='checkbox'  <?php echo ($field_type == 'checkbox')?"selected":"" ?> >Checkbox </option>
                <option value='textarea' <?php echo ($field_type == 'textarea')?"selected":"" ?>  >Textarea </option>
            </select>
            <input type="hidden" class="rwo_field"   name="fields[<?php echo $index; ?>][field_row]"value="row-<?php echo $index; ?>" />
            <div class='dab_field'><?php echo $field; ?></div> <a class='button dab-remove-row'  href='#'>-</a></td>

    </tr>
    <?php
}


function add_row_dab(){
    $output = '';
    $output .= "<tr class='empty-row screen-reader-text que_row row-2 test' data-tr='2'>
		<td>
		<p class='dab-questions next'>Question:</p>
		<input type='text' class='dabquestionnaire' id='field_name_2' name='fields[2][field_name]' disabled />

		<select name='fields[2][field_type]' data-id='2' data-tr='row-2' id='field_type_2' class='select_type' disabled>

			<option value='select'>Select </option> <option value='text'>Text </option>
			<option value='checkbox'>Checkbox </option>
			<option value='textarea'>Textarea </option>
		</select>
		<input type='hidden' class='rwo_field'   name='fields[2][field_row]'value='row-2' disabled />
		<div class='dab_field'></div>
<a class='button dab-remove-row'  href='#'>-</a></td>
		
	</tr>";
    return $output;

}
function add_meta_row_dab($count){
    $count = $count +1;
    $output = '';
    $output .= "	<tr class='empty-row screen-reader-text que_row row-{$count}' data-tr='{$count}'>
		<td>
		<p class='dab-questions next'>Question:</p>
		<input type='text' class='dabquestionnaire' id='field_name_{$count}' name='fields[{$count}][field_name]' disabled />

		<select name='fields[{$count}][field_type]' data-id='{$count}' data-tr='row-{$count}' id='field_type_{$count}' class='select_type' disabled>

			<option value='select'>Select </option> <option value='text'>Text </option>
			<option value='checkbox'>Checkbox </option>
			<option value='textarea'>Textarea </option>
		</select>
		<input type='hidden' class='rwo_field' name='fields[{$count}][field_row]' value='row-{$count}' disabled />
		<div class='dab_field'></div>
<a class='button dab-remove-row'  href='#'>-</a></td>
		
	</tr>";
    return $output;

}
add_filter('manage_edit-voter-guide_columns',   'add_admin_questionnaire_columns');
function add_admin_questionnaire_columns($columns)
{
    $columns = array(
        'cb' => $columns['cb'],
        'image' => __( 'Photo' , 'dab' ),
        'title' => __( 'Name' , 'dab' ),
        'office' => __( 'Office', 'dab' ),
        'state' => __( 'State', 'dab' ),
        'status' => __( 'Status', 'dab' ),
        'approvestatus' => __( 'Approve', 'dab' ),
    );
    return $columns;
}

function product_custom_column_values( $column, $post_id ) {
    if ($column == 'image') {
        $banner_img = get_post_meta($post_id,'post_banner_img',true);

        $iconURL= DAB_PATH_URL .'assets/img/dummy.png';
        $url =  wp_get_attachment_url($banner_img);
        if(empty($url)){ $url = 	$iconURL; }
        echo 	"<img src='{$url}' width='50'>";
    }
    if ($column == 'office') {
        echo 	get_post_meta($post_id, 'dab_office',  true);
    } 
	if ($column == 'approvestatus') {
        $status = 	get_post_meta($post_id, 'dab_status',  true);
		     $loader= DAB_PATH_URL .'assets/img/loader.gif';
			 $checked = "";
		if($status == 'Approved'){ $checked = "checked"; $sta = "Pending"; $hold = "Approved"; } else{  $sta = "Approved"; $hold  ="Pending";  }
		echo "<input type='checkbox' hold-status='$hold' data-id ='$post_id'name='approvestatus' class='approvests' id='$post_id-approvests' value='$sta' $checked>";
		echo '<img id="'.$post_id.'_adsearchdab"style="display: none;" src="'.$loader.'" width="30">';
    }
    if ($column == 'state') {
        echo 	get_post_meta($post_id, 'dab_state',  true);
    }
	if ($column == 'status') {
        echo 	get_post_meta($post_id, 'dab_status',  true);
    }

}
add_action( 'manage_voter-guide_posts_custom_column' , 'product_custom_column_values', 10, 2 );

function multi_media_uploader_field($name, $value = '') {
    $image = '">Add Media';
    $image_str = '';
    $image_size = 'full';
    $display = 'none';
    $value = explode(',', $value);

    if (!empty($value)) {
        foreach ($value as $values) {
            if ($image_attributes = wp_get_attachment_image_src($values, $image_size)) {
                $image_str .= '<li data-attechment-id=' . $values . '><a href="' . $image_attributes[0] . '" target="_blank"><img src="' . $image_attributes[0] . '" /></a></li>';
            }
        }

    }

    if($image_str){
        $display = 'inline-block';
    }

    return '<div class="multi-upload-medias"><ul>' . $image_str . '</ul><a href="#" class="wc_multi_upload_image_button button' . $image . '</a><input type="hidden" class="attechments-ids ' . $name . '" name="' . $name . '" id="' . $name . '" value="' . esc_attr(implode(',', $value)) . '" /><a href="#" class="wc_multi_remove_image_button button" style="display:inline-block;display:' . $display . '">Remove media</a></div>';
}


function create_front_fields($field_type, $field_option,$index){

    $checked ='';
    $output = '';
    if($field_type == 'text'){
        $output .=  "<input type='{$field_type}' name='fields[{$index}][field_value]' value='' required> ";

    }else if($field_type == 'select'){
        $output  .=  "<select name='fields[{$index}][field_value]'><option></option>";
        $options = $field_option;
        $option  = explode(',',$options);
        foreach($option as $value){

            $output .=  "<option value='{$value}' >{$value}</option>";

        }
        $output .= "</select>";
    }else if($field_type == 'radio'){
        $options = $field_option;
        $option  = explode(',',$options);
        foreach($option as $value){

            $output .= "<div class='dab-radio'> <input type='radio'  name='fields[{$index}][field_value]' value='{$value}' required><span>{$value}</span></div>";
        }
    }else if($field_type == 'checkbox'){


        $options = $field_option;
        $option  = explode(',',$options);
        $s = '';
        foreach($option as $value){
            $output .= "<div class='dab-radio dab-checkbox'><input type='checkbox'  name='fields[{$index}][field_value][]' value='{$value}' required ><span>{$value}</span></div>";
        }

    }else if($field_type == 'textarea'){
        $output .=  "<textarea id='' name='fields[{$index}][field_value]' placeholder='Type your message here...' required></textarea> "  ;
    }
    return $output;
}
add_action( 'wp_ajax_dab_get_api_data', 'dab_get_api_data' );
add_action( 'wp_ajax_nopriv_dab_get_api_data', 'dab_get_api_data' );



add_action( 'wp_ajax_testkey', 'get_civic_info' );
add_action( 'wp_ajax_nopriv_testkey', 'get_civic_info' );
function get_civic_info(){
    $atts_id = '';
    $zip =  $_POST['zip'];
    $dabstate =  $_POST['shortstate'];
    $dab_state =  $_POST['state'];
    $dabname =  $_POST['dabname'];
    $dabfull_add =  $_POST['dabfull_add'];
    $output = '';
    $key = get_option('new_option_name');
    if(!empty($dab_state) && empty($zip) && empty($dabfull_add) ) { $api_call = ''; }else{
        $api_call = "https://www.googleapis.com/civicinfo/v2/representatives?query=state&key=$key&address={$dabfull_add} {$dab_state}{$zip}";
    }
    $request  = wp_remote_get( $api_call );
    $dab = wp_remote_retrieve_body( $request );
    $dab = json_decode($dab);

    $a = array();
    $output .= '<div class="dab-serch-result-cst">';
    if(@array_key_exists("error",$dab)){  $output .=  '<div class="no-result"> '.$dab->error->message .'</div>';   } else{
        $output .= '<table class="dab-serch-result-cst-tb" width="100%">';

        $output .= '  <tbody>        <th width="15%"> <h6> Photo</h6>  </th>  <th width="30%">  <h6> Name </h6>  </th><th width="40%"> <h6> Office  </h6></th>
          <th width="15%">  <h6>  State  </h6></th>   </tbody>';

        $result_array = array();
        $i=0;

        $office_list = $dab->offices;
        foreach($office_list as $offices){
            $name = $offices->name; $office_array[] =  $name ;
            $divisionId[] = $offices->divisionId;
        }
        if(!empty($divisionId)){
            $meta_query[] =  array(
                'key'     => 'dab_division',
                'value' =>$divisionId,
                'compare' => 'LIKE',
            );
        }
        if(!empty($dabstate)){
            $meta_query[] =  array(
                'key'     => 'dab_state',
                'value' =>$dabstate,
                'compare' => '=',
            );
        }
        if(!empty($dabname)){
            $meta_query[] =array(
                'key' => 'dab_name',
                'compare' => 'LIKE',
                'value' => $dabname
            );
        }
        if(!empty($zip)){
            $meta_query[] =array(
                'key' => 'dabzipcode',
                'compare' => '=',
                'value' => $zip
            );
        }
        $meta_query[] =  array(
            'key'     => 'dab_status',
            'value' =>'Approved',
            'compare' => '=',
        );

        if(!empty($meta_query)){
            $args = array(
                'post_type'=>'voter-guide',
                'posts_per_page'   => -1,
                'order'            => 'DESC',
                'post_status'      => 'publish', 'relation' => 'AND',
                'meta_query' => array(  'relation' => 'OR', $meta_query),
            );


            $wp_query = get_posts( $args );

            if(count($wp_query) == 0){ $outputno .= '<div class="no-result"> No result found</div>';}
            foreach($wp_query as $result){

                $name = get_post_meta( $result->ID, 'dab_name', true );
                $office = get_post_meta( $result->ID, 'dab_office', true );
                $dab_state = get_post_meta( $result->ID, 'dab_state', true );
                $dab_img = get_post_meta( $result->ID, 'dab_img', true );
                if(empty($dab_img)){ $iconURL= DAB_PATH_URL .'assets/img/dummy.png';  }else{ $iconURL=  $dab_img; }
                $banner_img = get_post_meta($result->ID,'post_banner_img',true);
                $open_link = "<a href='/voter-guide/$result->post_name'>";
                $close_link = "</a>";

                $url =  wp_get_attachment_url($banner_img);
                if(empty($url)){ $url = 	$iconURL; }

                if(empty($dab_img)){ $dab_img = DAB_PATH_URL .'assets/img/dummy.png'; }
                $output .= "<tr ><td width='15%'> $open_link <img class='legislator-pic' src='" . $url . "'  alt='' /> $close_link </td>";

                $output .= "<td width='30%'><h3 class='legislator'>" . $open_link . esc_html( $name) . $close_link . "</h3></td>";

                $output .= '<td width="40%">' . $open_link.  $office . $close_link . '</td>';

                $output .= '<td width="15%"> ' . $open_link . $dab_state . $close_link . '</td>';
                $output .= "   </tr> ";

            }
        } else{ $outputno .= '<div class="no-result"> No result found</td>'; }

        $output .= '</table> '.$outputno.'<div style="clear:both"></div></div>';

    }
    // else $output .= "Invalid";
    echo  $output;
    wp_die();
}

function sing_page_dab($post_id){

    $name = get_post_meta( $post_id, 'dab_name', true );
    $office = get_post_meta( $post_id, 'dab_office', true );
    $dab_state = get_post_meta( $post_id, 'dab_state', true );
    $dab_img = get_post_meta( $post_id, 'dab_img', true );
    $dab_election = get_post_meta( $post_id, 'dab_election', true );
 
    $dab_status = get_post_meta( $post_id, 'dab_status', true );

    $banner_img = get_post_meta($post_id,'post_banner_img',true);
    $output = '';
    $dab_img =wp_get_attachment_image_src($banner_img, 'full')  ;
    if(empty($banner_img)){ $iconURL= DAB_PATH_URL .'assets/img/dummy.png';  }else{ $iconURL=  $dab_img[0]; }
    $output .= "<div class='dab_answer_page'>
   <table width='100%' cellpadding='10px' cellspacing='0' border='0'>
      <tr>
         <td width='50%'><img id='output-img' src='{$iconURL}' alt='{$name}'></td>
         <td width='50%'>
            <p id='name-ouput'>{$name} </p>
            <p id='state-ouput'>{$dab_state} </p>
            <p id='office-ouput'>{$office} </p>
         </td>
      </tr>";



    return $output;
}

function answer_page_dab($field_type, $field_option,$index,$value,$selected){
    $checked ='';
    $output = '';
    if($field_type == 'text'){
        $output .=  "<div style='display:flex;'><strong style='flex:0 0 35px;max-height:25px;margin-bottom: 5px;'>  &nbsp;</strong><p> $value</p></div>";

    }else if($field_type == 'select'){
        $output  .=  "<div class='select_cust'>";
        $options = $field_option;
        $option  = explode(',',$options);

        $output .=  "$selected";

        $output .= "</div>";
    }else if($field_type == 'radio'){
        $options = $field_option;
        $option  = explode(',',$options);
        $s = 'checked';

        $output .= "<div class='dab-radio dab-redio'> <div class='dabredio$s disabled'><span class='dab-redio_cust'></span></div>{$value}</div>";

    }else if($field_type == 'checkbox'){


        $options = $field_option;
        $option  = explode(',',$options);
        $s = '';
        $output .= "<div class='dab-radio dab-checkbox'><ul clas='ans-dab'>";
        foreach($selected as $value){
            $s = 'checked';

            $output .= "<li>{$value}</li>";
        }
        $output .= "</ul></div>";
    }else if($field_type == 'textarea'){
        $output .=  "<p> $value</p>";
    }
    return $output;

}



add_action( 'wp_ajax_get_office', 'get_civic_office' );
add_action( 'wp_ajax_nopriv_get_office', 'get_civic_office' );
function get_civic_office(){
    $state =  $_POST['state'];
    $post_id =  $_POST['posthidden'];
    $fulladd =  $_POST['dab_address'];
    $zip =  $_POST['zip'];
    $key = get_option('new_option_name');
	$address = $fulladd .' '. $zip.' '. $state;
    $output= array();
    $api_call = "https://www.googleapis.com/civicinfo/v2/representatives?key=$key&address=$address";
    $request  = wp_remote_get( $api_call );
    $dab = wp_remote_retrieve_body( $request );
    $dab = json_decode($dab);
    $i=1;
  $offic .=  return_divisions($address,$selected);
    $selected = get_post_meta( $post_id, 'dab_office', true );
    foreach($dab->offices as $office){
        $office_name = $office->name;$divisionId = $office->divisionId;
        $s = ($selected == $office_name)?'selected':'';

   
  
            $offic .=  "<option value='{$office_name}'  division='{$divisionId}'  $s> ".$office_name;
      
        $i++;
    }

    echo json_encode($offic);
    die();
}
// Auto fill Title and Slug for CPT's - 'companies', 'contacts', 'properties'
add_action( 'save_post', 'dab_save_post', 10,3 );
function dab_save_post( $post_id, $post, $update) {
      if ( !isset($_POST['save']) ) {
        return;
    }
   if ( 'trash' === $post->post_status ) {
        return;
    }
    if ( get_post_type( $post_id ) == 'voter-guide' ){

        $name = get_post_meta( $post_id, 'dab_name', true );
        $new_title = sanitize_title( $name );
        global $wpdb;
        $where = array( 'ID' => $post_id );

      $wpdb->update( $wpdb->posts, array( 'post_title' => $name,'post_name'=> $new_title, 'post_status'   =>  'publish'), $where );
    }
} 

 // approve status
add_action( 'wp_ajax_vote_approve_status', 'vote_approve_status' );
add_action( 'wp_ajax_nopriv_vote_approve_status', 'vote_approve_status' );
function vote_approve_status( ) {
	$value =  $_POST['approve'];
	$post_id =  $_POST['post_id'];
	update_post_meta( $post_id, 'dab_status',  $value) ;
	$status = get_post_meta( $post_id, 'dab_status', true ); 	 // get status
	 // return status
	 if($status == "Approved"){  $hold  ="Pending";}else{  $hold  ="Approved";} 
	$return['status']= $value;
	$return['hold']= $hold;
	echo json_encode($return);
	die();

}  
 function return_divisions($address,$selected){
$key = get_option('new_option_name');

    $api_call = "https://www.googleapis.com/civicinfo/v2/representatives?key=$key&address=$address";
    $request  = wp_remote_get( $api_call );
    $dab = wp_remote_retrieve_body( $request );
    $dab = json_decode($dab); 
	$state = $dab->normalizedInput->state;
	$country = "ocd-division/country:us";
	$state = "ocd-division/country:us/state:ny";
	$da = $dab->divisions;
	$offic = '';
	unset($da->$state);
	unset($da->$country); 
	foreach($da as $key=> $divisions){
		 $name_value =  str_replace("'", "", $divisions->name);
	  $divisionId =$key;
	$ss = ($selected == $name_value)?'selected':'';
	$offic .=  "<option value='{$name_value}' division='{$divisionId}' $ss > ". $divisions->name;
	 
	}	
	 return $offic;
}  