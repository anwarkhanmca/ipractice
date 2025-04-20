@if($errors->has())
    <?php unset($editProduct); ?>
@endif
<div class="container">
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-8 col-md-offset-2">
            @if(Session::has('info_msg'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ Session::get('info_msg') }}
                        </div>
                    </div>
                </div>
            @endif    
            <div class="panel panel-primary" style="border-color: #0866C6">
                  <div class="panel-heading" style="color: #fff; background-color: #0866C6; border-color: #0866C6;">
                        <h3 class="panel-title"><i class="fa fa-plus-square-o tiny-icon"></i> &nbsp;{{ $form_title or ''}}</h3>
                  </div>
                  <div class="panel-body">
                        {{ Form::open(array('url' => '/crm/product', 'class'=>'form-horizontal')) }}
                            <div class="input-group  col-md-12 proposal-input-group">
                                <div class="col-md-3">
                                    <label class="proposal-label"><b>Product Name </b></label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Product Name" name="service_name" value="{{ isset($editProduct) ? $editProduct->service_name : Input::old('service_name') }}"/>
                                    @if ($errors->has('service_name')) <span style="color: red">{{ $errors->first('service_name') }}</span> @endif
                                </div>
                            </div>
                            <!--input group-edns here-->
                            <div class="input-group  col-md-12 proposal-input-group">
                                <div class="col-md-3">
                                    <label class="proposal-label"><b>Price</b></label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-number" id="parcent" placeholder="Price" name="price" value="{{ isset($editProduct) ? $editProduct->price : Input::old('price') }}"/>
                                    @if ($errors->has('price')) <span style="color: red">{{ $errors->first('price') }}</span> @endif
                                </div>
                            </div>

                            <div class="input-group  col-md-12 proposal-input-group">
                                <div class="col-md-3">
                                    <label class="proposal-label"><b>Tax Rate</b></label>
                                </div>
                                <div class="col-md-6">
                                    <select name="tax_rate" class="form-control">
                                        <option value="">Tax Rate</option>
                                        <option <?php echo (isset($editProduct) && ($editProduct->tax_rate == 'Tax(0.00%),0')) ? 'selected' : (Input::old('tax_rate') == 'Tax(0.00%),0') ? 'selected' : ''; ?> value="Tax(0.00%),0">None(0.00%)</option>
                                        <option <?php echo (isset($editProduct) && ($editProduct->tax_rate == 'Tax(2%),2')) ? 'selected' : (Input::old('tax_rate') == 'Tax(2%),2') ? 'selected' : ''; ?> value="Tax(2%),2">Tax(2%)</option>
                                        <option <?php echo (isset($editProduct) && ($editProduct->tax_rate == 'Tax(5%),5')) ? 'selected' : (Input::old('tax_rate') == 'Tax(5%),5') ? 'selected' : ''; ?> value="Tax(5%),5">Tax(5%)</option>
                                        <option <?php echo (isset($editProduct) && ($editProduct->tax_rate == 'Tax(10%),10')) ? 'selected' : (Input::old('tax_rate') == 'Tax(10%),10') ? 'selected' : ''; ?> value="Tax(10%),10">Tax(10%)</option>

                                    </select>
                                        @if ($errors->has('tax_rate')) <span style="color: red">{{ $errors->first('tax_rate') }}</span> @endif
                                </div>
                            </div>

                            <input type="hidden" name="service_id" value="{{ isset($editProduct) ? $editProduct->service_id : Input::old('product_id') }}">

                            <!--input group-edns here-->
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-primary btn-sm  proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6"><i class="fa fa-paper-plane tiny-icon"></i> Save </button>
                            </div>
                        {{ Form::close() }}
                  </div>
            </div>
            <div class="panel panel-primary">
                <div class=" panel-heading" style="color: #fff; background-color: #0866C6; border-color: #0866C6;">
                            <h3 class="panel-title"><i class="fa fa-list tiny-icon"></i> &nbsp;{{ $content_header or "" }}</h3>
              </div>
<!--                heading-->
                    <div class="panel-body">
                        <div class="table-responsive" >
                            <table class="table table-bordered table-striped table-hover" id="product_table">
                                <thead style="background-color: #0866C6; color: white">
                                <tr>
                                    <th><b>Product ID</b></th>
                                    <th><b>Product Name</b></th>
                                    <th><b>Price</b></th>
                                    <th><b>Tax Rate</b></th>
                                    <th><b>Action</b></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->service_id or "" }}</td>
                                        <td>{{ $product->service_name or "" }}</td>
                                        <td><b>$ </b> {{ $product->price or "" }}</td>
                                        <td>{{ ($product->tax_rate) ? explode(',', $product->tax_rate)[0] : 'None(0.00%)' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
                                                    <li><a href="{{ url('/crm/product/edit/'.$product->service_id) }}"><i class="fa fa-edit tiny-icon"></i>Edit</a></li>
                                                    <li><a href="{{ url('/crm/product/delete/'.$product->service_id) }}" class="delete" data-url="{{ url('/crm/product/check_product/'.$product->service_id) }}"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach    
                                </tbody>
                            </table>

                        </div>
                        <!--table-responsive-->

                    </div>
                    <!-- panel-body-->
                </div>
                <!-- panel-->
            </div>
            <!--col-md-12-->
        </div>
        <!--row-->
    </div>

    <!--container col-md-12 hidden-print-->
           <!-- ///////////////////////////////////SMALL MODAL FOR MESSAGE///////////////////// -->
<div class="modal fade modal-sm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      
      </div>
      <div class="modal-body">
       <h4 id="message_modal"></h4>
      </div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> 