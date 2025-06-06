<?php
class EmailTestController extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        if (empty($user_id)){
            Redirect::to('/login')->send();
        }
    }
    
    public function index()
    {
       // set_time_limit(4000);
   // phpinfo();die;
        //http://davidwalsh.name/gmail-php-imap
        /*$imapPath = '{imap.example.com:993/imap/ssl}INBOX';
        $username = 'anwar.appsbee@gmail.com';
        $password = 'welcome123@';*/

       	/* connect to gmail */
        //$hostname = '{imap.gmail.com:993/imap/ssl/novalidate-cert/norsh}Inbox';
        $hostname = '{imap.gmail.com:143/novalidate-cert}Inbox';
        $username = 'appsbeeteam@gmail.com';
        $password = 'SecureMail#3210';

        /* try to connect */
        $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

        /* grab emails */
        $emails = imap_search($inbox,'ALL');

        /* if emails are returned, cycle through each... */
        if($emails) {
            
            /* begin output var */
            $output = '';
            
            /* put the newest emails on top */
            rsort($emails);
            
            /* for every email... */
            foreach($emails as $email_number) {
                
                /* get information specific to this email */
                $overview = imap_fetch_overview($inbox,$email_number,0);
                $message = imap_fetchbody($inbox,$email_number,2);
                
                /* output the email header information */
                $output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
                $output.= '<span class="subject">'.$overview[0]->subject.'</span> ';
                $output.= '<span class="from">'.$overview[0]->from.'</span>';
                $output.= '<span class="date">on '.$overview[0]->date.'</span>';
                $output.= '</div>';
                
                /* output the email body */
                $output.= '<div class="body">'.$message.'</div>';
				exit;
            }
            
            echo $output;
        } 

        /* close the connection */
        imap_close($inbox);
       
    }
}
