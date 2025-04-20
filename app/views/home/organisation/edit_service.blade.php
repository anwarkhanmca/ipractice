<select class="form-control serviceclass" name="serviceselect_id<?php echo $id; ?>" id="serviceselect_id<?php echo $id; ?>">

  <option></option>

  <?php

        if(!empty($services)){

            
            foreach($services as $key=>$service_row){
                

                if($servicetxt_id==$service_row->service_id){

                    $val="selected='selected'";

                    }else{

                        echo $val=" ";

                        }
                ?>
                <option value="<?php echo $service_row->service_id; ?>" <?php echo $val; ?> ><?php echo $service_row->service_name; ?></option> 

            <?php

             }

          }

		  ?>

       </select>*<select class="form-control staffclass" name="staffselect_id<?php echo $id; ?>" id="staffselect_id<?php echo $id; ?>">

              <option>None</option>

                  <?php

						if(!empty($staff_details)){

						  

							foreach($staff_details as $key=>$staff_row){

								if($stafftxt_id==$staff_row->user_id){

									$val="selected='selected'";

									}else{

										echo $val=" ";

									}

									?>
								<option value="<?php echo $staff_row->user_id; ?>" <?php echo $val; ?> ><?php echo $staff_row->fname.' '.$staff_row->lname ?></option> 
                                <?php
							

							 }

						  }

				  ?>

               </select>