<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
	    $('#example').DataTable( {
	        "processing": true,
	        "serverSide": true,
	        "ajax": "scripts/server_processing.php"
	    } );
	} );
	</script>
	
	<link href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	<title>DataTables examples - Examples index</title>
</head>
<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <!-- <tfoot>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot> -->
    </table>
</body>
</html>