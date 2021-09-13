<?php
if(is_singular( )){

    get_header();
    $post_id = get_the_ID();
    echo sing_page_dab($post_id);
    $quednary  = get_option('dab_field_option_name');
    $count = count( $quednary);

    if($count >0){
        $i = 1;
        $a =  $quednary;
        foreach( $a as $key=>$fields ){
            $a[$i]['field_value'] = get_field_value_dab($i);

            $i++;
        }
        $j= 1;
        foreach( $a as $fields ){
            if(array_key_exists("field_options",$fields)){
                $field_option =$fields['field_options'] ;
            }else{
                $field_option = ''; }
            $field_type = $fields['field_type'] ;
            $selected = $fields['field_value'];

            if (!empty($fields['field_name'])) {
                echo '<tr class="answer_dab row'.$j.'"> 
		  <td colspan="2" >
		 <div class="quednary" style="display:flex;align-items: baseline;margin-top:10px;">
            <strong style="flex:0 0 35px;max-height:25px;margin-bottom: 5px;"> Q :- &nbsp;</strong> <p style="margin: 0 0 7px;color: #333;line-height: 20px; font-weight:bold;">'. $fields['field_name'].'</p>
   
      </div>
         <p >  ';
                echo  answer_page_dab($field_type, $field_option,$j,$fields["field_value"],$selected);
                echo  ' </p>
         </td>
      </tr> ';

                $j++; }  }}

    echo  "</table>
</div>";
    get_footer();
}