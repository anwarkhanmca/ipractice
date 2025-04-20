<?php
class JobsCronjob extends Eloquent {

	public $timestamps = false;

	public static function getJobsCronjobDetails($client_id, $service_id)
	{
        $data = array();
		$details = JobsCronjob::where("client_id", "=", $client_id)->where("service_id", "=", $service_id)->first();
        if(isset($details) && count($details) >0){
            $data["job_cronjob_id"]     = $details->job_cronjob_id;
            $data["user_id"]            = $details->user_id;
            $data["client_id"]          = $details->client_id;
            $data["service_id"]         = $details->service_id;
            $data["status"]             = $details->status;
            $data["created"]            = $details->created;
        }

        return $data;
	}

}
