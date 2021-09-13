<?php

echo "<h1> Settings</h2>";

?>
    <div style="padding-left: 0px; padding-right:20px; padding-top:0px;" class="dab_dashboard">
    <h2>Questionnaire: </h2>
    <form action="" id="questions_form" name="questions_form" method="POST">
<?php  	  $quednary  = get_option('dab_field_option_name'); $count = '';  if(is_array($quednary)){ $count = count($quednary); } ?>
<table id="repeatable-fieldset-one" data-questions="<?php  if($count){echo $count; }else{echo '1'; } ?>" width="100%">

<?php echo	'<tbody>';

//echo "<pre>"; print_r($quednary); echo "</pre>";
if($count >0):

    $i = 1;
    foreach( $quednary as $fields ){
        if(array_key_exists("field_options",$fields)){
            $field_option =$fields['field_options'] ;
        }else{
            $field_option = ''; }
        $field_type = $fields['field_type'] ;
        $field_name = $fields['field_name'] ;
        echo  questionnaire_fields($field_type,$field_name,$field_option,$i);
        $i++;
    }
    echo add_meta_row_dab($count);

else :
    // show a blank one

    echo '<tr data-row="" class="row-1" data-tr="1">
		<td>
		<p class="dab-questions">Question 1:</p>
		<input type="text" class="dabquestionnaire" name="fields[1][field_name]" />


		<select name="fields[1][field_type]" data-id="1" data-tr="row-1" class="select_type">
			<option value="select">Select </option> <option value="text">Text </option>
			<option value="checkbox">Checkbox </option>
			<option value="textarea">Textarea </option>
		</select>
		<input type="hidden" class="rwo_field"   name="fields[1][field_row]"value="row-1" />
		<div class="dab_field"></div></td>
		 
	</tr>';
    echo add_row_dab();  endif;
echo '</tbody>
	</table>

	<p><a id="add-row" class="button" href="#">Add another</a>
	<div class="submit-btn">
	<button class="button" type="submit" name="dab_submit" class="btn btn-primary">Submit <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
	</div>
	</p>
	
</form>';