@if($errors->has())
    <?php unset($editTax); ?>
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
                        {{ Form::open(array('url' => '/crm/tax', 'class'=>'form-horizontal')) }}
                            <div class="input-group  col-md-12 proposal-input-group">
                                <div class="col-md-3">
                                    <label class="proposal-label"><b>Tax Name</b></label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Tax Name" name="tax_name" value="{{ isset($editTax) ? $editTax->tax_name : Input::old('tax_name') }}"/>
                                    @if ($errors->has('tax_name')) <span style="color: red">{{ $errors->first('tax_name') }}</span> @endif
                                </div>
                            </div>
                            <!--input group-edns here-->
                            <div class="input-group  col-md-12 proposal-input-group">
                                <div class="col-md-3">
                                    <label class="proposal-label"><b>Tax Rate</b></label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-number" id="parcent" placeholder="Percent(%)" name="tax_rate" value="{{ isset($editTax) ? $editTax->tax_rate : Input::old('tax_rate') }}"/>
                                    @if ($errors->has('tax_rate')) <span style="color: red">{{ $errors->first('tax_rate') }}</span> @endif
                                </div>
                            </div>

                            <input type="hidden" name="tax_id" value="{{ isset($editTax) ? $editTax->id : Input::old('tax_id') }}">

                            <!--input group-edns here-->
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-primary btn-sm proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6"><i class="fa fa-paper-plane tiny-icon"></i> Save Tax </button>
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
                            <table class="table table-bordered table-striped table-hover" id="tax_table">
                                <thead style="background-color: #0866C6; color: white">
                                <tr>
                                    <th><b>Tax Name</b></th>
                                    <th><b>Rate</b></th>
                                    <th><b>Action</b></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($taxes as $tax)
                                    <tr>
                                        <td>{{ $tax->tax_name or "" }}</td>
                                        <td>{{ $tax->tax_rate or "" }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
                                                    <li><a href="{{ url('/crm/tax/edit/'.$tax->id) }}"><i class="fa fa-edit tiny-icon"></i>Edit</a></li>
                                                    <li><a href="{{ url('/crm/tax/delete/'.$tax->id) }}" class="delete" data-url="{{ url('/crm/tax/check_tax/'.$tax->id) }}"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
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