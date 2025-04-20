<div class="container" id="select_product" data-edit="{{ isset($services_used) ? count($services_used) : 0 }}">
    <div class="col-md-10 col-md-offset-1">
        <div class="row" style="margin-top: 10px;">
            <div class="alert alert-danger alert-dismissible service-empty" style="display:none;" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <strong>At least one product need to be selected.</strong>
            </div>

                <div class="panel panel-primary" style="overflow-x:scroll; border-color: #0866C6">
                	  <div class="panel-heading" style="color: #fff; background-color: #0866C6; border-color: #0866C6;">
                			<h3 class="panel-title">{{ $page_title }} - Select Product</h3>
                	  </div>
                	  <div class="panel-body">
                      {{ Form::open(array('url' => '/crm/saveProposal', 'class'=>'form-horizontal',  'id'=>'proposal-form')) }}
                          <div class="proposal-top col-md-12" style="border-bottom: 1px solid #ccc;padding:0px;margin-right:0px;">
                                <div class="input-group col-md-12 proposal-input-group">
                                    <div class="col-md-2">
                                        <label style="margin-top:5px;">
                                            Proposal Title
                                        </label>
                                    </div>
                            <!--    .col-md-2-->

                                    <div class="col-md-6 col-sm-5">
                                     <input type="text" placeholder="Proposal Title" id="proposal_title" class="form-control " style="border-radius: 4px;" name="proposal_title" value="{{ isset($proposal) ? $proposal->proposal_title : '' }}"/>
                                        <span class="error-msg" style="display: none;">Proposal Title field is required</span>
                                    </div>
                    <!--    .col-md-5-->
                                    <div class="col-md-4 col-sm-6 col-xs-12" style="padding: 0px;float: right;min-width:280px;display:inline-block">
                                        <select name="customer"   id="customer" class="form-control pull-left " style="margin-right:0px;display:inline;float:right;max-width:307 !important;min-width: 200px;">
                                            <option value="">Select Customer</option>
                                            <?php
                                            if($customers){
                                                foreach($customers as $customer){
                                                    ?>
                                                    <option value="{{ $customer['client_id'] }}"><?php echo $customer['field_value']; ?></option>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    <span class="error-msg" style="display: none;">Customer field is required</span>
                                    </div>
                                    <!--  .col-md-5-->
                                    <div class="clear-both"></div>
                                </div>
                    <!--.input-group md-12-->

                            </div>
                          <div class="row col-md-12 proposal-top" style="padding: 0px;">
                              <div class="input-group col-md-7 col-md-offset-5">
                                  <div class="col-md-5 col-sm-4">
                                      <h4 style="float: right;margin:0px;text-align: right;margin-top:5px;font-weight: bold;">Add Product</h4>
                                  </div>
                                  <div class="col-md-7 col-sm-6 col-xs-12" style="padding:0px;min-width:290px;">
                                      <input type="text"  placeholder="Search" id="serviceFinder" onkeyup="return searchService();"  autocomplete="off"  class="form-control" style="margin-right:0px;position: relative;margin:0px;width:auto;" />
                                      <button class="btn btn-xs btn-default sm-btn" style="margin-left:0px;padding:6px;" data-toggle="modal" data-target="#serviceModal"><i class="fa fa-plus"></i></button>
                                        <div class="service-holder">
                                            <ul id="serviceList">

                                            </ul>
                                        </div>
<!--                                      service-holder-->
                                  </div>
                              </div>
                          </div>
<!--                          row col-md-12 proposal-top-->
                                <div class="table-responsive">

                                    <table class="table table-bordered" id="form-table">
                                    	<thead>
                                    		<tr>
                                          <th>#</th>
                                    			<th>Product <?php //echo $compnay_info->business_type;?></th>
                                    			<th>Unit Price</th>
                                    			<th>Quantity</th>
                                    			<th>Discount</th>
                                    			<th>Tax rate</th>
                                    			<th>Tax</th>
                                    			<th>Amount</th>
                                    			<th><i class="fa fa-trash-o"></i></th>
                                    		</tr>
                                    	</thead>

                                    	<tbody>
                                        <?php
                                if(isset($services_used)):
                                    $i=0;
                                    foreach($services_used as $sp):

                                        $str= '<tr id="row_' . $i .'"><td><input type="hidden" value="'.$sp->service_id.'" name="service[]" /><h3>' . ($i+1) . '</h3></td> <td> <input type="text" name="service_item[]" class="form-control" readonly placeholder="Product" value="'.$sp->service->service_name.'"  style="margin-bottom:5px;width:210px" id="service_item_' . $i . '"/>';
                                        $str.= ' <textarea name="description[]"  class="form-control" placeholder="Description" id="description_' . $i . '">'.$sp->description.'</textarea><span class="error-msg" style="display: none;">Maximum character limit 255</span> </td> <td> <input type="text" name="unit_price[]"  class="form-control"';
                                        $str.= ' placeholder="Unit Price" onBlur="return checkUnitPrice('.$i.');" onkeyup="return calculateRow(' . $i . ');" value="'.$sp->unit_price.'" style="width:100px;" id="unit_price_' . $i . '"/> </td> <td> <input type="text" name="quantity[]" value="'.$sp->quantity.'" onblur="return checkQuantity(' . $i . ');" onkeyup="return calculateRow(' . $i . ');" class="form-control" placeholder="Quantity" style="width:50px;"  id="quantity_' . $i . '"/>';
                                        $str.=' </td> <td> <input type="text" name="discount[]" value="'.$sp->discount.'"  onkeyup="return calculateRow(' . $i . ');" class="form-control" placeholder="Discount"  onblur="return checkDiscount(' . $i . ');" style="width:70px;" id="discount_' . $i . '"/><span class="error-msg" style="display: none;">Discount can\'t be greater than 100%</span> </td> <td> <select name="tax_rate[]" class="form-control pull-left" ';
                                        $str.= ' style="width:100px;margin-left:10px;" onchange="return calculateRow(' . $i . ');" id="tax_rate_' . $i . '"><option value="" data-taxid="0">Tax Rate</option>';

                                        $str.='<option '.(($sp->tax_rate == 'None(0.00%),0') ? "selected='selected'":"").' value="None(0.00%),0">None(0.00%)</option>';
                                        $str.='<option '.(($sp->tax_rate == 'Tax(2%),2') ? "selected='selected'":"").' value="Tax(2%),2">Tax(2%)</option>';
                                        $str.='<option '.(($sp->tax_rate == 'Tax(5%),5') ? "selected='selected'":"").' value="Tax(5%),5">Tax(5%)</option>';
                                        $str.='<option '.(($sp->tax_rate == 'Tax(10%),10') ? "selected='selected'":"").' value="Tax(10%),10">Tax(10%)</option>';

                                        // foreach ($taxlist as $taxr) {
                                        //         $checked=($taxr->id==$sp->tax_rate)? "selected='selected'":"";
                                        //     $str.='<option value="'. $taxr->id.'" '.$checked.'>'. $taxr->tax_name.'('.$taxr->tax_rate.'%)</option>';
                                        // }

                                        $str.=' </select> </td> <td> <input type="text" name="tax[]" class="form-control" readonly placeholder="Tax" value="'.$sp->tax_amount.'" id="tax_' . $i . '"/> </td> <td> <input type="text"';
                                        $str.=' name="amount[]" class="form-control" placeholder="Amount" readonly value="'.$sp->total_amount.'"  id="amount_' . $i . '"/> </td> <td> <button class="btn btn-danger btn-xs" onclick="return deleter(' . $i . ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
                                  echo $str;
                                    $i+=1;
                                    ?>

                                    <?php
                                    endforeach;
                                endif;
                                ?>

                                    	</tbody>
                                    </table>
                                </div>
<!--                          table-responsive-->
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="col-md-4 col-md-offset-8">
                                      <div class="input-group col-md-12" style="display: block !important">
                                            <div class="col-md-5 proposal-input-group"><label class="proposal-label"> Subtotal</label></div>
                                            <div class="col-md-7 proposal-input-group"><input type="text" name="subtotal" value="{{ isset($proposal) ? $proposal->sub_total : '' }}" id="subtotal" readonly class="form-control" style="border-radius:4px ;"/></div>
                                      </div>
                        <!--   input-group-->
                                      <div class="input-group col-md-12" style="display: block !important">
                                          <div class="col-md-5 proposal-input-group"><label class="proposal-label"> Sales Tax</label></div>
                                          <div class="col-md-7 proposal-input-group"><input type="text" name="sales_tax" value="{{ isset($proposal) ? $proposal->sales_tax : '' }}" id="sales_tax" readonly class="form-control" style="border-radius:4px ;"/></div>
                                      </div>
                                      <!--   input-group-->
                                      <div class="input-group col-md-12" style="display: block !important">
                                          <div class="col-md-5 proposal-input-group"><label class="proposal-label">Total</label></div>
                                          <div class="col-md-7 proposal-input-group"><input type="text" name="total" value="{{ isset($proposal) ? $proposal->total : '' }}" id="total" readonly class="form-control" style="border-radius:4px ;"/></div>
                                      </div>
                                      <!--   input-group-->
                                      <input name="customer_id" value="{{ isset($proposal) ? $proposal->customer_id : ''}}" id="customer_id" type="hidden"/>
                                      <input name="proposal_id" value="{{ isset($proposal) ? $proposal->id : ''}}" id="proposal_id" type="hidden"/>
                                      <!-- for copy proposal -->
                                      @if(Request::segment(2) == 'copyProposal')
                                        <input type="hidden" name="action_identity" value="copyProposal">
                                      @endif
                                  </div>
<!--                                  col-md-4 col-md-offset-8-->
                              </div>
<!--                              .col-md-12-->
                          </div>
<!--                          .row-->
                          <div class="row">
                              <div class="col-md-12">
                                  <button type="submit" class="btn btn-primary btn-sm proposal-button" style="background-color: #0866C6">Next</button>
                                  <a href="{{ url('crm/viewAllProposal') }}" class="btn btn-primary btn-sm proposal-button"  style="background-color: #0866C6">Cancel</a>
                              </div>
                          </div>
                          <!--      .row-->
                        {{ Form::close() }}
                      </div>
<!--                    panel-body-->
                </div>

        </div>
        <!--            .row-->
    </div>
    <!--    col-md-12-->
</div>

<div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Product</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-info alert-dismissible" id="service-alert" style="display: none;" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    Product has been added successfully.
                </div>
                <!--                .alert-->
                <form  id="service-form" action="">
                <input type="hidden" id="csrf_token" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="input-group  col-md-12 proposal-input-group">
                    <div class="col-md-3">
                        <label class="proposal-label">Product Name</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Product Name" name="name" id="name" />
                        <span class="error-msg" style="display: none">Product Name is required</span>
                    </div>
                </div>
                <!--input group-edns here-->
                <div class="input-group  col-md-12 proposal-input-group">
                    <div class="col-md-3">
                        <label class="proposal-label">Price</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control input-number" id="price" placeholder="Price" name="price" id="price" />
                        <span class="error-msg" style="display: none">Price is required</span>
                    </div>
                </div>
                <!--input group-edns here-->
                <div class="input-group  col-md-12 proposal-input-group">
                    <div class="col-md-3">
                        <label class="proposal-label">Tax Rate</label>
                    </div>
                    <div class="col-md-6">
                        <select name="tax_rate" id="tax_rate" class="form-control">
                            <option value="">Tax Rate</option>
                            <option value="None(0.00%),0">None(0.00%)</option>
                            <option value="Tax(2%),2">Tax(2%)</option>
                            <option value="Tax(5%),5">Tax(5%)</option>
                            <option value="Tax(10%),10">Tax(10%)</option>

                            <?php //if($taxlist):
                                //foreach($taxlist as $tax):
                                    ?>
                                    <!-- <option value="<?php //echo $tax->id;?>"><?php //echo $tax->tax_name."(".$tax->tax_rate."%)"; ?></option> -->
                                <?php
                                //endforeach;
                            //endif;
                            ?>
                        </select>
                        <span class="error-msg" style="display: none">Tax Rate is required</span>
                    </div>
                </div>
                <!--input group-edns here-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary proposal-button" id="service-btn" style="background-color: #0866C6">Save changes</button>
                <button type="reset" class="btn btn-default" >Reset</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--/////////////////// SERVICE  MODAL ENDS HERE///////////////////////////////-->
