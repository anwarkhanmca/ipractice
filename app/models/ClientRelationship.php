<?php
class ClientRelationship  extends Eloquent{
	
	public $timestamps = false;
	public static function getTypeId($client_id, $appointment_with)
  {
    $type_id = 0;
    $details = ClientRelationship::where('client_id', $client_id)->where('appointment_with',$appointment_with)->select('relationship_type_id')->first();
    if(isset($details->relationship_type_id) && $details->relationship_type_id != ''){
        $type_id = $details->relationship_type_id;
    }
    return $type_id;
  }

  public static function getRelId($client_id, $appointment_with)
  {
    $rel_id = 0;
    $details = ClientRelationship::where('client_id', $client_id)->where('appointment_with',$appointment_with)->select('client_relationship_id')->first();
    if(isset($details->client_relationship_id) && $details->client_relationship_id != ''){
        $rel_id = $details->client_relationship_id;
    }
    return $rel_id;
  }
	

}
