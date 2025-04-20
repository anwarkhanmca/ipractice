    {{ Form::open(array('url'=>'/crm/attachment','method'=>'POST', 'files'=>true)) }}
    	Title: <input type="text" name="title" placeholder="Title"><br>
    	PDF: <input type="file" name="file" placeholder="PDF"><br>
    	<input type="submit">
    {{ Form::close() }}

    <table>
    	<thead>
    		<th>Id</th>
    		<th>Title</th>
    		<th>PDF</th>
    		<th>Edit</th>
    		<th>Delete</th>
    	</thead>
    	<tbody>
    		@foreach($attachments as $attachment)
    			<tr>
    				<td>{{ $attachment->id }} </td>
    				<td>{{ $attachment->title }}</td>
    				<td><a href="{{ url('crm/download/'. $attachment->id) }}">{{ $attachment->file }}</a></td>
    				<td><a href="{{ url('/crm/attachment/preview/'.$attachment->id) }}">Preview</a></td>
    				<td><a href="{{ url('/crm/attachment/delete/'.$attachment->id) }}">Delete</a></td>
    			</tr>
    		@endforeach
    	</tbody>		
    </table>