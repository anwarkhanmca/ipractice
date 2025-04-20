 <!--
 @if(isset($datares) && count($datares) >0)
         <select class="form-control">
                @foreach($datares as $key=>$name_row)
                  <option value="">{{ $name_row }}</option>
                  @endforeach
         </select>
  @endif
                      
          -->            @if(isset($relayth_data) && count($relayth_data) >0)
                      
                   <select class="form-control clientdetails" id="">
                   <option value="" selected="">--Select--</option>
						@foreach($relayth_data as $key=>$client_row)
                            
                        <option value="{{ $client_row['client_id'] }}">{{ $client_row['name'] }}</option>
                            
                        @endforeach
					</select>    
                    
                    @endif