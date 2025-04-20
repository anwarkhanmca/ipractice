    {{ Form::open(array('url' => '/crm/tax')) }}
    	Tax Name: <input type="text" name="tax_name" placeholder="Tax Name" value="{{ isset($editTax) ? $editTax->tax_name : '' }}"><br>
    	Tax Rate: <input type="text" name="tax_rate" placeholder="Percent%" value="{{ isset($editTax) ? $editTax->tax_rate : '' }}"><br>
    	<input type="hidden" name="tax_id" value="{{ isset($editTax) ? $editTax->id : '' }}">
    	<input type="submit">
    {{ Form::close() }}

    <table>
    	<thead>
    		<th>Id</th>
    		<th>Tax Name</th>
    		<th>Tax Rate</th>
    		<th>Edit</th>
    		<th>Delete</th>
    	</thead>
    	<tbody>
    		@foreach($taxes as $tax)
    			<tr>
    				<td>{{ $tax->id }} </td>
    				<td>{{ $tax->tax_name }}</td>
    				<td>{{ $tax->tax_rate }}</td>
    				<td><a href="{{ url('/crm/tax/edit/'.$tax->id) }}">Edit</a></td>
    				<td><a href="{{ url('/crm/tax/delete/'.$tax->id) }}">Delete</a></td>
    			</tr>
    		@endforeach
    	</tbody>		
    </table>