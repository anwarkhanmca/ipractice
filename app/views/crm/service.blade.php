    {{ Form::open(array('url' => '/crm/service')) }}
    	Service Name: <input type="text" name="name" placeholder="Service Name" value="{{ isset($editService) ? $editService->name : '' }}"><br>
    	Price: <input type="text" name="price" placeholder="Price" value="{{ isset($editService) ? $editService->price : '' }}"><br>
    	Tax Rate: <select name="tax_id">
                    @foreach($taxes as $tax)
                        <option <?php echo (isset($editService) && ($editService->tax_id == $tax->id)) ? 'selected' : ''; ?> value="{{ $tax->id }}">{{ $tax->tax_name ."(". $tax->tax_rate."%)" }}</option>
                    @endforeach
                </select><br>
        <input type="hidden" name="service_product_id" value="{{ isset($editService) ? $editService->id : '' }}">
    	<input type="submit">
    {{ Form::close() }}

    <table>
    	<thead>
    		<th>Id</th>
    		<th>Service Name</th>
    		<th>Price</th>
            <th>Tax Rate</th>
    		<th>Edit</th>
    		<th>Delete</th>
    	</thead>
    	<tbody>
    		@foreach($serviceProducts as $serviceProduct)
    			<tr>
    				<td>{{ $serviceProduct->id }} </td>
    				<td>{{ $serviceProduct->name }}</td>
    				<td>{{ "$ ".$serviceProduct->price }}</td>
                    <td>{{ $serviceProduct->tax->tax_rate."%" }}</td>
    				<td><a href="{{ url('/crm/service/edit/'.$serviceProduct->id) }}">Edit</a></td>
    				<td><a href="{{ url('/crm/service/delete/'.$serviceProduct->id) }}">Delete</a></td>
    			</tr>
    		@endforeach
    	</tbody>		
    </table>