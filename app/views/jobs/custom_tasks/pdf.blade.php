<style type="text/css">
.table_border{ border: 1px solid #ddd;}
.table_border>thead>tr>th, .table_border>tbody>tr>td{padding: 8px; line-height: 1.428571429; vertical-align: top; border: 1px solid #ddd;}
</style>
<table width="100%" class="table_border">
    <thead>
      <tr role="row">
        <th width="32%" align="left">CLIENT NAME</th>
        <th width="20%" align="left">FIELDS NAME</th>
        <th width="15%" align="left">&nbsp;</th>
        <th width="20%" align="left">JOB START DATE</th>
        <th width="13%" align="left">STATUS</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($company_details) && count($company_details) >0)
      @foreach($company_details as $key=>$details)
        @if(isset($details['manage_task']) && $details['manage_task'] == "Y")
        
          <tr>
            <td align="left">{{ $details['client_name'] or "" }}</td>
            <td align="left"></td>
            <td align="left"></td>
            <td align="left">{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != '')?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):'' }}</td>
            <td align="left">{{ $details['status_name'] or "" }}</td>
    
          </tr>
        @endif 
      @endforeach
    @endif
    </tbody>
  </table>