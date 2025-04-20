@extends('layouts.user')

@section('content')

    <!-- Page -->
  <div class="page animsition">
    <div class="page-content container-fluid" style="margin-top: 60px">
      <div class="row" data-plugin="masonry">

        <div class="col-xs-12 masonry-item">
          <!-- Panel Projects Status -->
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-actions" style="color: #ffffff">
                <a class="text-action btn btn-primary" href="{{ URL::to('upload') }}"><i class="icon wb-plus" aria-hidden="true"></i> Add new document</a>
              </div>
              <h3 class="panel-title">
                Your documents (<?= count($docs)?>)
              </h3>
            </div>
            <div class="table-responsive">
            @if(sizeof($docs) > 0)
              <table class="table table-striped">
                <thead>
                  <tr>
                    <td>Date</td>
                    <td>Request title</td>
                    <td>Document</td>
                    <td>Status</td>
                    <td>Actions</td>
                  </tr>
                </thead>
                <tbody>
                    @foreach($docs as $doc)
                    <tr>
                      <td>{!! date('F d, Y', strtotime($doc['created_on'])) !!}</td>
                      <td>{!! $doc['reqTitle'] !!}</td>
                      <td>{!! $doc['file_name'] !!}</td>
                      <td>
                        @if($doc['status'] == 1) 
                          <span class="label label-success">Completed</span>  
                        @else
                          @if(sizeof($doc['declined']) > 0)
                            <span class="label label-danger">Declined by {!!$doc['declined'][0]['name']!!}</span>
                          @else
                            <span class="label label-warning">Under process</span>
                          @endif
                        @endif  
                      </td>                      
                      <td>
                      @if($doc->status == 1)
                        <button type="button" class="btn btn-sm btn-icon btn-pure btn-default"
                        data-toggle="tooltip" data-original-title="Download">
                        <a href="./public/media/{{$doc['file_name']}}" target="_blank" download>
                          <i class="icon wb-download" aria-hidden="true"></i>
                        </a>
                        </button>
                      @endif
                        <button type="button" class="btn btn-sm btn-icon btn-pure btn-default"
                        data-toggle="tooltip" data-original-title="Delete">
                        <a href="delete/{{$doc['id']}}" onclick="return confirm('Do you want to delete this document?');">
                          <i class="icon wb-trash" aria-hidden="true"></i>
                        </a>
                        </button>
                      </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            @else
              <div class="alert alert-info">
                <strong>Info!</strong> No docunment found!
              </div>
            @endif
            </div>
          </div>
          <!-- End Panel Projects Stats -->
        </div>

      </div>
    </div>
  </div>
  <!-- End Page -->
@endsection
