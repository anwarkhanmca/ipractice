<?php
// This file contains mainly classes related to the workpaper section 
abstract class WP_STATUS
{
    const not_started = 0;
    const in_progress = 1;
	const to_review = 2;
    const completed = 3;
}

abstract class WP_TYPE
{
    const generic = 0;
    const trial_balance = 1;
	const journal = 2;
	const lead_schedules = 3;
	const notes = 4;
}

function wp_type_to_string($wp_type) {
	switch ($wp_type) {
		case 1: return 'TRIAL BALANCE';
		case 2: return 'JOURNAL';
		case 3: return 'LEAD SCHEDULES';
		case 4: return 'NOTES';
		default: return 'GENERIC';
	}
}

function wp_type_to_string_group($wp_type) {
	switch ($wp_type) {
		case 1: return 'TRIAL BALANCE';
		case 2: return 'JOURNALS';
		case 3: return 'LEAD SCHEDULES';
		case 4: return 'NOTES';
		default: return 'GENERIC';
	}
}

const WP_ACC_TYPE_COUNT = 14;

abstract class WP_ACC_TYPE {
	const undefined = -1;
	const fa = 0;
	const fa_intangible = 1;
	const fa_tangible = 2;
	const fa_investments = 3;
	const bank_cash = 4;
	const stock = 5;
	const debtors_lt_1yr = 6;
	const debtors_gt_1yr = 7;
	const ca_investments = 8;
	const creditors_lt_1yr = 9;
	const creditors_gt_1yr = 10;
	const capital_reserves = 11;
	const revenue = 12;
	const expenses = 13;
}

function wp_acc_type_to_string($wp_acc_type) {
	switch ($wp_acc_type) {
	    case -1:
	        return 'None';
	    case 0:
	        return 'Fixed Assets';
	    case 1:
	        return 'FA - Intangible';
	    case 2:
	        return 'FA - Tangible';
	    case 3:
	        return 'FA - Investments';
	    case 4:
	        return 'Bank/Cash';
	    case 5:
	        return 'Stock';
	    case 6:
	        return 'Debtors <1yr';
	    case 7:
	        return 'Debtors >1yr';
	    case 8:
	        return 'CA - Investments';
	    case 9:
	        return 'Creditors <1yr';
	    case 10:
	        return 'Creditors >1yr';
	    case 11:
	        return 'Capital/Reserves';
	    case 12:
	        return 'Revenue';
	    case 13:
	        return 'Expenses';
	}
	return '';
}

function xero_account_type_to_wp($xero_acc_type) {
	$lc_xero_acc_type = strtoupper($xero_acc_type);
	switch ($lc_xero_acc_type) {
		case 'BANK':
			return WP_ACC_TYPE::bank_cash;
		case 'CURRENT':
			return WP_ACC_TYPE::debtors_lt_1yr;
		case 'CURRLIAB':
			return WP_ACC_TYPE::creditors_lt_1yr;
		case 'DEPRECIATN':
			return WP_ACC_TYPE::expenses;
		case 'DIRECTCOSTS':
			return WP_ACC_TYPE::expenses;
		case 'EQUITY':
			return WP_ACC_TYPE::capital_reserves;
		case 'EXPENSE':
			return WP_ACC_TYPE::expenses;
		case 'FIXED':
			return WP_ACC_TYPE::fa_tangible;
		case 'LIABILITY':
			return WP_ACC_TYPE::creditors_gt_1yr;
		case 'NONCURRENT':
			return WP_ACC_TYPE::debtors_gt_1yr;
		case 'OTHERINCOME':
			return WP_ACC_TYPE::revenue;
		case 'OVERHEADS':
			return WP_ACC_TYPE::expenses;
		case 'PREPAYMENT':
			return WP_ACC_TYPE::debtors_lt_1yr;
		case 'REVENUE':
			return WP_ACC_TYPE::revenue;
		case 'SALES':
			return WP_ACC_TYPE::revenue;
		case 'TERMLIAB':
			return WP_ACC_TYPE::creditors_gt_1yr;
		case 'PAYGLIABILITY':
			return WP_ACC_TYPE::creditors_lt_1yr;
		case 'SUPERANNUATIONEXPENSE':
			return WP_ACC_TYPE::expenses;
		case 'SUPERANNUATIONLIABILITY':
			return WP_ACC_TYPE::creditors_lt_1yr;
		case 'WAGESEXPENSE':
			return WP_ACC_TYPE::expenses;
		case 'WAGESPAYABLELIABILITY':
			return WP_ACC_TYPE::creditors_lt_1yr;
	}
	error_log("Can't find WP match for Xero Account Type $xero_acc_type");
	return -1;
}

function qb_account_type_to_wp($qb_acc_type) {
	$lc_qb_acc_type = normalise_description_for_matching($qb_acc_type);
	switch ($lc_qb_acc_type) {
		case 'bank':
			return WP_ACC_TYPE::bank_cash;
		case 'othercurrentasset':
			return WP_ACC_TYPE::debtors_lt_1yr;
		case 'fixedasset':
			return WP_ACC_TYPE::fa_tangible;
		case 'otherasset':
			return WP_ACC_TYPE::fa_tangible;
		case 'accountsreceivable':
			return WP_ACC_TYPE::debtors_lt_1yr;
		case 'accountspayable':
			return WP_ACC_TYPE::creditors_lt_1yr;
		case 'creditcard':
			return WP_ACC_TYPE::creditors_lt_1yr;
		case 'longtermliability':
			return WP_ACC_TYPE::creditors_gt_1yr;
		case 'othercurrentliability':
			return WP_ACC_TYPE::creditors_lt_1yr;
		case 'equity':
			return WP_ACC_TYPE::capital_reserves;
		case 'income':
			return WP_ACC_TYPE::revenue;
		case 'otherincome':
			return WP_ACC_TYPE::revenue;
		case 'expense':
			return WP_ACC_TYPE::expenses;
		case 'otherexpense':
			return WP_ACC_TYPE::expenses;
		case 'costofgoodssold':
			return WP_ACC_TYPE::expenses;
	}
	error_log("Can't find WP match for QB Account Type $qb_acc_type");
	return -1;
}

function kf_acc_code_to_wp($kf_acc_code) {
	$kf_acc_code = trim($kf_acc_code);
	switch ($kf_acc_code) {
		case '1100': // Debtors Control Account
			return WP_ACC_TYPE::debtors_lt_1yr;
		case '1200': // Current Account
			return WP_ACC_TYPE::bank_cash;
		case '2100': // Creditors Control Account
		case '2200': // Output VAT
		case '2201': // Input VAT
		case '2202': // VAT Control
		case '7010': // Wages Control
		case '7011': // Tax & NI
		case '7012': // Deductions
			return WP_ACC_TYPE::creditors_lt_1yr;
		case '4001': // Sale of goods
		case '4400': // Credit Charges (Late Payments)
		case '4905': // Shipping
		case '7903': // Interest Received
			return WP_ACC_TYPE::revenue;
		case '5000': // Materials Purchased
		case '6201': // Advertising
		case '7003': // Gross Pay
		case '7006': // Employers NI
		case '7100': // Rent
		case '7102': // Water Rates
		case '7200': // Electricity
		case '7201': // Gas
		case '7303': // Vehicle Insurance
		case '7400': // Travel
		case '7403': // Entertainment
		case '7502': // Telephone
		case '7504': // Stationery
		case '7603': // Professional Fees
		case '7900': // Interest Paid
		case '7901': // Bank Charge
		case '7905': // Credit Charges
		case '8204': // Insurance
			return WP_ACC_TYPE::expenses;
	}
	error_log("Can't find WP match for KF Account Type $kf_acc_code");
	return -1;	// 9998: Other
}

function fa_code_to_wp($fa_code) {
	$fa_code = normalise_description_for_matching($fa_code);
	switch ($fa_code) {
		case '285': //Accommodation and Meals
		case '292': //Accountancy Fees
		case '288': //Advertising and Promotion
		case '363': //Bank/Finance Charges
		case '359': //Books and Journals
		case '335': //Business Entertaining
		case '360': //Charitable Donations
		case '278': //Childcare Vouchers
		case '270': //Computer Hardware
		case '269': //Computer Software
		case '293': //Consultancy Fees
		case '372': //Corporation Tax Penalty
		case '294': //Formation Costs
		case '364': //Insurance
		case '362': //Interest Payable
		case '273': //Internet & Telephone
		case '291': //Leasing Payments
		case '290': //Legal and Professional Fees
		case '249': //Mileage
		case '274': //Mobile Phone
		case '283': //Motor Expenses
		case '250': //Office Costs
		case '271': //Office Equipment
		case '272': //Other Computer Costs
		case '373': //PAYE/NI Penalty
		case '351': //Pension (Annuity)
		case '350': //Pension (Personal/Stakeholder)
		case '358': //Postage
		case '276': //Printing
		case '390': //Realized Currency Exchange Gain/Loss
		case '251': //Rent
		case '289': //Staff Entertaining
		case '282': //Staff Training
		case '277': //Stationery
		case '361': //Subscriptions
		case '280': //Sundries
		case '365': //Travel
		case '391': //Unrealized Currency Exchange Gain/Loss
		case '366': //Use Of Home
		case '371': //VAT Penalty
		case '268': //Web Hosting
		case '102': //Commission Paid
		case '101': //Cost of Sales
		case '104': //Equipment Hire
		case '103': //Materials
		case '150': //Subcontractor Costs
		case '401': //Salaries
		case '402': //Employer NICs
		case '403': //Staff Pensions
		case '404': //Net Salary Expense
		case '405': //PAYE/NI Expense
		case '407': //Directors' Salaries
		case '408': //Directors' Employer NICs
		case '409': //Directors' Staff Pensions
		case '450': //Bad Debts Written Off
		case '460': //Depreciation Charge
		case '461': //Loss/Gain on Disposal of Capital Asset
		case '502': //Corporation Tax Expense
		case '503': //Deferred Corporation Tax Expense
		case '902': //Salary and Bonuses
		case '904': //Benefit in Kind
		case '905': //Expense Account
			return WP_ACC_TYPE::expenses;
		case '001': //Sales
		case '051': //Interest Received
		case '055': //Flat Rate Scheme Surplus
		case '056': //Refund of Other Tax Received
		case '057': //PAYE/NI Online Filing Incentive Claimed
		case '058': //Grant Income
			return WP_ACC_TYPE::revenue;
		case '750': //Bank Account
		case '760': //Unpresented Items
		case '761': //Bank Transfers in Progress
			return WP_ACC_TYPE::bank_cash;
		case '670': //Share Premium
		case '901': //Capital Account
		case '908': //Dividend
		case '968': //Profit and Loss
			return WP_ACC_TYPE::capital_reserves;
		case '799': //HP Liabilities > 1 Year
		case '825': //Deferred Corporation Tax
			return WP_ACC_TYPE::creditors_gt_1yr;
		case '650': //Provisions of Liabilities
		case '660': //Accruals
		case '796': //Trade Creditors
		case '797': //Other Creditors
		case '798': //HP Liabilities < 1 Year
		case '813': //Pension Creditor
		case '814': //PAYE/NI
		case '815': //Other Payroll Deductions
		case '817': //Sales Tax
		case '818': //VAT Reclaimed
		case '819': //VAT Charged
		case '820': //Corporation Tax
		case '822': //Second Sales Tax Charged
		case '823': //Deferred VAT
		case '824': //VAT Mini One Stop Shop
		case '900': //Smart User Payment
		case '907': //Director Loan Account
			return WP_ACC_TYPE::creditors_lt_1yr;
		case '620': //Prepayments
		case '681': //Trade Debtors
		case '682': //Other Debtors
			return WP_ACC_TYPE::debtors_lt_1yr;
		case '910': // Unpaid Shares
			return WP_ACC_TYPE::debtors_gt_1yr;
		case '630': //Investments Brought Forward
		case '631': //Investments Additions
		case '632': //Investments Revaluations
		case '633': //Investments Disposals
			return WP_ACC_TYPE::fa_investments;
		case '601': //Capital Asset Brought Forward
		case '604': //Disposal of Capital Asset
		case '605': //Capital Asset Depreciation Brought Forward
		case '606': //Capital Asset Depreciation in Year
		case '607': //Depreciation on Disposal of Capital Asset
			return WP_ACC_TYPE::fa_tangible;
		case '609': //Stock
		case '610': //Stock Adjustment
			return WP_ACC_TYPE::stock;
	}
	error_log("Can't find WP match for FA Account Type $fa_code");
	return -1; // 599 = Error, 998 = Contra Account, 999 = Suspense Account
}

function status_text($status_const) {
	if ($status_const == WP_STATUS::not_started) {
		return "Not Started";
	} else if ($status_const == WP_STATUS::in_progress) {
		return "In Progress";
	} else if ($status_const == WP_STATUS::to_review) {
		return "To Review";
	} else if ($status_const == WP_STATUS::completed) {
		return "Completed";
	} else {
		return "N/A";
	}
}

class WORKPAPER_PERIOD{
    public $id;
    public $name;
    public $client_id;
    public $comparative_date;
    public $balance_sheet_date;
    public $preparer_id;
	public $prepared_date;
	public $reviewer_id;
	public $reviewed_date;
	public $partner_reviewer_id;
	public $partner_reviewed_date;
	public $permanent_data_folder;
    public $manager_id;
	public $is_archived;
	public $wp_groups;
    public function __construct($id=0) {
        if($id!=0){
            $this->get_workpaper_period_by_id($id);
        }else{
            $this->id=0;
            $this->name='';
            $this->client_id=0;
            $this->comparative_date=0;
            $this->balance_sheet_date=0;
            $this->preparer_id='';
			$this->prepared_date=0;
            $this->reviewer_id='';
			$this->reviewed_date=0;
            $this->partner_reviewer_id='';
			$this->partner_reviewed_date=0;
			$this->permanent_data_folder='';
			$this->permanent_data_name='PERMANENT DATA';
			$this->permanent_data_code='P';
            $this->manager_id=0;
			$this->is_archived=0;
			$this->wp_groups=array();
        }
        return $this;
    }

	public function get_workpaper_period_by_id($id){
        global $wpdb;
        $sql="SELECT * FROM wp_wpp_period WHERE id='".$id."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->id=$id;
            $this->name=$rows[0]->name;
            $this->client_id=$rows[0]->client_id;
            $this->comparative_date=$rows[0]->comparative_date;
            $this->balance_sheet_date=$rows[0]->balance_sheet_date;
            $this->preparer_id=$rows[0]->preparer_id;
			$this->prepared_date=$rows[0]->prepared_date;
            $this->reviewer_id=$rows[0]->reviewer_id;
			$this->reviewed_date=$rows[0]->reviewed_date;
            $this->partner_reviewer_id=$rows[0]->partner_reviewer_id;
			$this->partner_reviewed_date=$rows[0]->partner_reviewed_date;
			$this->permanent_data_folder=$rows[0]->permanent_data_folder;
			$this->permanent_data_name=$rows[0]->permanent_data_name;
			$this->permanent_data_code=$rows[0]->permanent_data_code;
            $this->manager_id=$rows[0]->manager_id;
			$this->is_archived=$rows[0]->is_archived;
			
			if ($this->permanent_data_folder == '' && $this->client_id !== 0) {
				// save to db default path to permanent data folder
				$this->permanent_data_folder = $this->get_default_permanent_data_folder_path($this->client_id);
				$ret = $wpdb->update('wp_wpp_period', 
					array('permanent_data_folder' => $this->permanent_data_folder),
					array('id' => $this->id));
				if ($ret === false) {
					error_log("ERROR updating table 'wp_wpp_period' with default path to permanent data folder " . $this->permanent_data_folder . " for wpp_period id=" . $this->ID);
				}
			}
			$this->get_workpaper_groups();
        }
        return $this;
    }

	public function update_workpaper_period() {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		$ret = $wpdb->update('wp_wpp_period',
				array('name' => $this->name,
					'preparer_id' => $this->preparer_id,
					'reviewer_id' => $this->reviewer_id,
					'partner_reviewer_id' => $this->partner_reviewer_id),
				array(
					'id' => $this->id,
					'manager_id' => $current_user->get_manager_id())
				);
		if ($ret === false) {
			error_log("ERROR updating workpaper period id=" . $this->id);
		} else {
			return 1;
		}
		return -1;
	}
	
	public function update_wpp_preparer_and_date($preparer_id, $preparer_date) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		$this->preparer_id = $preparer_id;
		$this->prepared_date = $preparer_date;
		
		$ret = $wpdb->update('wp_wpp_period',
				array(
					'preparer_id' => $this->preparer_id,
					'prepared_date' => $this->prepared_date),
				array(
					'id' => $this->id,
					'manager_id' => $current_user->get_manager_id())
				);
		if ($ret === false) {
			error_log("ERROR updating preparer and prepared date for workpaper period id=" . $this->id);
		} else {
			return 1;
		}
		return -1;
	}

	public static function get_default_permanent_data_folder_path($client_id) {
		return sprintf("/wpp/%s/permanent/", $client_id);
	}

	public function rename($user_info, $id, $new_name){
        global $wpdb;
		$this->id = $id;
		if ($this->check_permission($this->id)) {
			$new_name = strtoupper($new_name);
			$ret = $wpdb->update( 'wp_wpp_period', array('name' => $new_name), array('id' => $this->id) );
			if ($ret === false) {
				error_log("ERROR renaming workpaper period id=" . $this->id);
				return 0;
			} else {
				$this->name=$new_name;
				return 1;
			}
		}
	}
	
	public function insert_to_db($user_info) {
        global $wpdb;
		if ($this->name === '' && $this->comparative_date > 0) {
			$month = (int)abs(($this->comparative_date - $this->balance_sheet_date)/(60*60*24*30));
			$this->name = 'WP ' . $month . ' MONTHS ENDED ' . strtoupper(date('M Y', $this->balance_sheet_date));
		}
		if ($this->permanent_data_folder === '' && $this->client_id != 0) {
			$this->permanent_data_folder = $this->get_default_permanent_data_folder_path($this->client_id);
		}
		$ret = $wpdb->insert( "wp_wpp_period", 
			array(
				'name' => $this->name, 
				'client_id' => $this->client_id,
				'comparative_date' => $this->comparative_date,
				'balance_sheet_date' => $this->balance_sheet_date,
				'preparer_id' => (int)$this->preparer_id,
				'prepared_date' => $this->prepared_date,
				'reviewer_id' => (int)$this->reviewer_id,
				'reviewed_date' => $this->reviewed_date,
				'partner_reviewer_id' => (int)$this->partner_reviewer_id,
				'partner_reviewed_date' => $this->partner_reviewed_date,
				'permanent_data_folder' => $this->permanent_data_folder,
				'permanent_data_name' => $this->permanent_data_name,
				'permanent_data_code' => $this->permanent_data_code,
				'manager_id' => $user_info->get_manager_id(),
				'is_archived' => $this->is_archived
				));
		if ($ret === false) {
			error_log("ERROR inserting workpaper period " . $this->name);
		} else {
			$this->id = $wpdb->insert_id;
			// insert default Workpaper groups
			$this->insert_default_workpaper_groups();
		}
		return 	$this->id;		
	}
	
	public function insert_default_workpaper_groups() {
		$groups = array(
			// array('GENERAL', 'G', false, 
			// 	array('A. Senior/Manager/Partner Review Notes', 
			// 		  'B. Client Queries',
			// 		  'C. Accounts',
			// 		  'D. Analytical Review',
			// 		  'E. Accounts Prep Notes',
			// 		  'F. Accounts Checklist',
			// 		  'G. Time Budget',
			//		  'H. Tax Computations')),
			array(wp_type_to_string_group(WP_TYPE::trial_balance), 'TB', false),
			array(wp_type_to_string_group(WP_TYPE::journal), 'JN', false),
			array('FIXED ASSETS', 'F', true),
			array('CASH AT BANK AND IN HAND', 'B', true),
			array('STOCK AND WORK IN PROGRESS', 'S', true),
			array('DEBTORS', 'D', true),
			array('CREDITORS', 'C', true),
			array('EQUITY', 'E', true),
			array('REVENUE - ANALYSIS', 'R', false),
			array('PROFIT & LOSS - EXPENSES ANALYSIS', 'P/L', false,
				array('Accountancy',
					  'Repair & Maintenance',
					  'Donation',
					  'Insurance',
					  'Wages Reconciliation',
					  'Legal fees',
					  'Fines & Penalties',
					  'BIK',
					  'Motor Vehicle expenses',
					  'Entertainment expenses')),
			array('TAX COMPUTATIONS', 'TC', false),
			array('NOTES', 'N', false),
		);
		
		$this->wp_groups = array();	// init

		foreach($groups as $group) {
			$gp = new WORKPAPER_GROUP();
			$gp->workpaper_period_id=$this->id;
			$gp->name=$group[0];
			$gp->code=$group[1];
			if ($group[2]) {
				$gp->lead_schedules = new LEAD_SCHEDULES();
			}
			if (count($group) == 4) {
				foreach ($group[3] as $wpp_name) {
					$wpp = new WORKPAPER();
					$wpp->name = $wpp_name;
					$gp->workpapers[] = $wpp;
				}
			}
			$gp->insert_to_db();
			$this->wp_groups[] = $gp;		
		}
	}
	
	public function insert_notes_group() {
		$gp = new WORKPAPER_GROUP();
		$gp->workpaper_period_id=$this->id;
		$gp->name="NOTES";
		$gp->code="N";
		$gp->insert_to_db();
		$this->wp_groups[] = $gp;
	}
	
	public function get_workpaper_groups() {
		global $wpdb;
		$this->wp_groups = array();	// init
        $sql="SELECT id FROM wp_wpp_group WHERE workpaper_period_id='".$this->id."' order by id";
        $rows=$wpdb->get_results($sql);
		foreach ($rows as $row) {
			$this->wp_groups[] = new WORKPAPER_GROUP($row->id);
		}
	}
	
	public function archive() {
		global $wpdb;
		$ret = $wpdb->update( 'wp_wpp_period', array('is_archived' => 1), array('id' => $this->id) );
		if ($ret === false) {
			error_log("ERROR archiving workpaper period id=" . $this->id);
			return 0;
		} else {
			$this->is_archived=1;
			return 1;
		}
	}
	
	public function unarchive() {
		global $wpdb;
		$ret = $wpdb->update( 'wp_wpp_period', array('is_archived' => 0), array('id' => $this->id) );
		if ($ret === false) {
			error_log("ERROR unarchiving workpaper period id=" . $this->id);
			return 0;
		} else {
			$this->is_archived=0;
			return 1;
		}
	}
	
	public function delete() {
		global $wpdb;
		// delete groups in this period
		foreach ($this->wp_groups as $gp) {
			$gp->delete();
		}			
		// delete this workpaper period
		$ret = $wpdb->delete( 'wp_wpp_period', array('id' => $this->id) );
		if ($ret === false) {
			error_log("ERROR deleting workpaper period id=" . $this->id);
			return 0;
		} else {
			return 1;
		}
	}

	public function roll_forward($user_info, $comparative_date, $balance_sheet_date, $preparer_id, $reviewer_id, $partner_reviewer_id) {
		$cloned_wp = clone $this;
		$cloned_wp->comparative_date = $comparative_date;
		$cloned_wp->balance_sheet_date = $balance_sheet_date;
		$cloned_wp->name = '';
		$cloned_wp->preparer_id = $preparer_id;
		$cloned_wp->reviewer_id = $reviewer_id;
		$cloned_wp->partner_reviewer_id = $partner_reviewer_id;
		
		$ret_id = $cloned_wp->insert_to_db($user_info);
		
		$this->set_status(WP_STATUS::to_review);
		
		return $cloned_wp;
	}
	
	public function set_status($new_status) {
		foreach($this->wp_groups as $gp) {
			$gp->set_status($new_status);
		}
	}

	public function get_status() {
		$status = 4;
		foreach($this->wp_groups as $gp) {
			$gp_status = $gp->get_status();
			if ($gp_status < $status) {
				$status = $gp_status;
			}
		}
		
		return $status;
	}
	
	public function check_permission($user_info, $wpp_id) {
        global $wpdb;
		$sql="SELECT manager_id FROM wp_wpp_period WHERE id='".$wpp_id."'";
        $manager_id=$wpdb->get_var($sql);
        if($manager_id == $user_info->get_manager_id()) {
			return true;
		} else {
			error_log("Permission denied for user id=" . $user_info->ID . " (manager_id=" . $user_info->get_manager_id() . ") to modify workpaper period id=" . $wpp_id . " (expected manager_id=" . $manager_id . ")");
			return false;
		}
        return false;
	}

	public function get_workpaper_group_by_name($name) {
		foreach($this->wp_groups as $wpg) {
			if ($wpg->name === $name) {
				return $wpg;
			}
		}
		return null;
	}
	
	public function get_workpaper_group_by_type($wp_type) {
		return $this->get_workpaper_group_by_name(wp_type_to_string_group($wp_type));
	}
	
	public function get_workpaper_group_by_id($wpg_id) {
		foreach($this->wp_groups as $wpg) {
			if ($wpg->id == $wpg_id) {
				return $wpg;
			}
		}
		return null;
	}
	
	public function get_workpaper_by_id($wp_id) {
		foreach($this->wp_groups as $wpg) {
			$ret = $wpg->get_workpaper_by_id($wp_id);
			if ($ret !== null) {
				return $ret;
			}
		}
		return null;
	}
	
	public function get_url() {
		return home_url('workpaper-period/?id=' . $this->id);
	}
	
	public function create_workpaper_under_group($user_info, $wp_type) {
		// create Journal work paper
		$wp_group = $this->get_workpaper_group_by_type($wp_type);
		$new_wp = new WORKPAPER();
		$new_wp->name = wp_type_to_string($wp_type);
		$new_wp->type = $wp_type;
		$wp_group->add_workpaper($new_wp, true, $user_info);
		
		return $new_wp;
	}
	
	// static
	// usage: I'm TB and I know my id, find the first journal workpaper in my workpaper period
	public function find_workpaper_in_my_wpp($my_wp_id, $target_workpaper_type) {
		global $wpdb;
		// first find workpaper period id
		$wp_gp_id = $wpdb->get_var($wpdb->prepare("SELECT related_id FROM wp_wpp_relations WHERE workpaper_id=%d and related_table='wp_wpp_group'", $my_wp_id));
		
		if ($wp_gp_id !== false) {
			// find group id for target type in the same workpaper period
			$target_gp_id = $wpdb->get_var($wpdb->prepare("SELECT id
				FROM wp_wpp_group
				WHERE name = %s
				AND workpaper_period_id = (
				SELECT workpaper_period_id
				FROM wp_wpp_group
				WHERE id =%d )", wp_type_to_string_group($target_workpaper_type), $wp_gp_id));
			if ($target_gp_id !== false) {
				// find first workpaper id in group
				return $wpdb->get_var($wpdb->prepare("SELECT workpaper_id FROM wp_wpp_relations WHERE related_id=%d AND related_table='wp_wpp_group'", $target_gp_id));
				
			} else {
				error_log("WORKPAPER_PERIOD::find_workpaper_in_my_wpp failed to get target group id from wp_wpp_relations table, my_wp_id=[$my_wp_id], target_gp_id=[$target_gp_id].");
			}
		} else {
			error_log("WORKPAPER_PERIOD::find_workpaper_in_my_wpp failed to get group id from wp_wpp_relations table, my_wp_id=[$my_wp_id].");
		}
		return false;
	}

	// static function
	public function update_reviewer_and_date($wpp_id) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		$update_time = time();
		$ret = $wpdb->update("wp_wpp_period",
				array(
					'reviewer_id' => $current_user->ID, // assign current user as reviewer
					'reviewed_date' => $update_time	// assign current time
				),
				array(
					'id' => $wpp_id,
					'manager_id' => $current_user->get_manager_id()
				));
		if ($ret === false) {
			error_log("ERROR updating workpaper_period reviewer with reviewer_id=[" . $current_user->ID . "], id=[" . $wpp_id . "]");
			return false;
		}
		return $update_time;
	}
	
	// static function
	public function clear_reviewed_date($wpp_id) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		
		$ret = $wpdb->update("wp_wpp_period",
				array(
					'reviewed_date' => 0	// clear date
				),
				array(
					'id' => $wpp_id,
					'manager_id' => $current_user->get_manager_id()
				));
		if ($ret === false) {
			error_log("ERROR clearing workpaper reviewer id, id=[" . $wpp_id . "]");
		}
		return $ret;
	}
}

class WORKPAPER_GROUP {
	public $id;
	public $workpaper_period_id;
    public $name;
    public $code;
	public $lead_schedules;
    public $workpapers;
    public function __construct($id=0) {
        if($id!=0){
            $this->get_workpaper_group_by_id($id);
        }else{
            $this->id=0;
            $this->workpaper_period_id=0;
            $this->name='';
            $this->code='';
            $this->workpapers=array();
        }
        return $this;
    }

	public function get_workpaper_group_by_id($id){
        global $wpdb;
        $sql="SELECT * FROM wp_wpp_group WHERE id='".$id."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->id=$id;
            $this->workpaper_period_id=$rows[0]->workpaper_period_id;
            $this->name=$rows[0]->name;
            $this->code=$rows[0]->code;
			if ($rows[0]->lead_schedules_id > 0) {
				// get lead_schedules
				$this->lead_schedules=new LEAD_SCHEDULES($rows[0]->lead_schedules_id);
			}
            
			// get workpapers
			$sql="SELECT workpaper_id FROM wp_wpp_relations WHERE " .
				 "related_table='wp_wpp_group' and related_id='" . $this->id . 
				 "' order by workpaper_id";
			
			$rows3=$wpdb->get_results($sql);
			// init
			$this->workpapers = array();
			foreach ($rows3 as $row){
                $this->workpapers[] = new WORKPAPER($row->workpaper_id);
            }
        }
        return $this;
    }

	public function insert_to_db() {
        global $wpdb;
		// insert lead schedule and apply new LS id
		if (isset($this->lead_schedules)) {
			$this->lead_schedules->workpaper_group_id=$this->id;
			$this->lead_schedules->code=$this->code;
			$this->lead_schedules->code_number=$this->get_next_code_number();
			$this->lead_schedules_id = $this->lead_schedules->insert_to_db();
		} else {
			$this->lead_schedules_id = 0;
		}
		
		// insert group
		$ret = $wpdb->insert( "wp_wpp_group", 
			array(
				'workpaper_period_id' => $this->workpaper_period_id, 
				'name' => $this->name,
				'code' => $this->code,
				'lead_schedules_id' => $this->lead_schedules_id,
				));
				
		if ($ret === false) {
			error_log("ERROR inserting workpaper group name=[" . $this->name . "], id=[" . $this->id . "]");
		} else {
			$this->id = $wpdb->insert_id;
			if ($this->lead_schedules_id > 0) {
			// update lead schedule WPGroup ID
				$wpdb->update("wp_wpp_lead_schedules",
					array(
						'workpaper_group_id' => $this->id
					),
					array(
						'id' => $this->lead_schedules_id
					));
			}
			foreach($this->workpapers as $wp) {
				$this->add_workpaper($wp, false, null);
			}
		}
		return 	$this->id;		
	}

	public function delete() {
		global $wpdb;
		// delete lead schedules
		if (isset($this->lead_schedules)) {
			$this->lead_schedules->delete();
		}
		
		foreach($this->workpapers as $wp) {
			// delete wp
			$wp->delete();
		}
		
		// delete this group
		$ret = $wpdb->delete( 'wp_wpp_group', array('id' => $this->id) );
		if ($ret === false) {
			error_log("ERROR deleting workpaper group id=" . $this->id);
			return 0;
		} else {
			return 1;
		}
	}
	
	public function get_next_code_number() {
		$highest_num = 0;
		if (isset($this->lead_schedules)) {
			foreach($this->lead_schedules->components as $comp) {
				if ($comp->code_number > $highest_num) {
					$highest_num = $comp->code_number;
				}
			}
			if ($this->lead_schedules->code_number > $highest_num) {
				$highest_num = $this->lead_schedules->code_number;
			}
		}
		foreach ($this->workpapers as $wpp) {
			if ($wpp->code_number > $highest_num) {
				$highest_num = $wpp->code_number;
			}
		}
		return $highest_num + 1;
	}

	public function get_status() {
		$wpg_status = 4;
		foreach ($this->workpapers as $wp) {
			$wp_status = $wp->get_status();
			if ($wp_status < $wpg_status) {
				$wpg_status = $wp_status;
			}
		}
		if (isset($this->lead_schedules)) {
			$ls_status = $this->lead_schedules->get_status();
			if ($ls_status < $wpg_status) {
				$wpg_status = $ls_status;
			}
		}
		return $wpg_status;
	}
	
	public function set_status($new_status) {
		foreach ($this->workpapers as $wp) {
			$wp->set_status($new_status);
		}
		if (isset($this->lead_schedules)) {
			$this->lead_schedules->set_status($new_status);
		}
	}
	
	public function check_permission($user_info, $id) {
        global $wpdb;
		$sql="SELECT workpaper_period_id FROM wp_wpp_group WHERE id='".$id."'";
		$wpp_id = $wpdb->get_var($sql);
		$wpp = new WORKPAPER_PERIOD();
		return $wpp->check_permission($user_info, $wpp_id);
	}
	
	public function get_workpaper_period($id = 0) {
        global $wpdb;
		if ($id == 0) {
			$id = $this->id;
		}
		$sql="SELECT workpaper_period_id FROM wp_wpp_group WHERE id='".$id."'";
		$wppid = $wpdb->get_var($sql);
		if ($wppid > 0) {
			return new WORKPAPER_PERIOD($wppid, false);
		} else {
			error_log("Can't find workpaper period for workpaper group id=" . $id);
		}
		
		return null;
	}
	
	public function rename($user_info, $new_name, $new_code) {
		// check permissions
        global $wpdb;
		$change_code = $new_code != $this->code;
		if ($this->check_permission($user_info, $this->id)) {
			$ret = $wpdb->update("wp_wpp_group",
				array(
					"name" => $new_name,
					"code" => $new_code
				),
				array(
					"id" => $this->id
				));
			if ($ret === false) {
				error_log("ERROR updating name and code for workpaper group id " . $this->id);
				return false;
			} else {
				$this->name = $new_name;
				if ($change_code) {
					$this->code = $new_code;
					foreach ($this->workpapers as $wp) {
						$wp->change_code($new_code);
					}
					if (isset($this->lead_schedules)) {
						$this->lead_schedules->change_code($new_code);
					}
				}
				error_log("SUCCESS!! Updated name and code for workpaper group id " . $this->id);
				return true;
			}
		}
		return false;
	}
	
	public function add_workpaper($wp, $add_to_self, $user_info) {
		global $wpdb;
		if (!isset($user_info)) {
			$user_info = new USER_INFO(wp_get_current_user()->ID);
		}
		if ($this->check_permission($user_info, $this->id)) {
			// insert work paper
			$wp->workpaper_group_id=$this->id;
			$wp->code=$this->code;
			$wp->code_number=$this->get_next_code_number();
			$wp->parent_table='wp_wpp_group';
			$wp->parent_id=$this->id;
			$wp->insert_to_db();

			// insert group-work paper relationship
			$ret2 = $wpdb->insert( "wp_wpp_relations", 
				array(
					'related_id' => $this->id, 
					'related_table' => 'wp_wpp_group', 
					'workpaper_id' => $wp->id,
					));
			if ($ret2 === false) {
				error_log("ERROR inserting group-workpaper relationship group id=[" . $this->id . "], workpaper id=[" . $wp->id . "]");
				return false;
			}				
			
			if ($add_to_self) {
				$this->workpapers[] = $wp;
			}
			return true;
		}
		return false;
	}
		
	public function get_workpaper_by_id($wp_id) {
		if (isset($this->lead_schedules)) {
			$ret = $this->lead_schedules->get_workpaper_by_id($wp_id);
			if ($ret !== null) {
				return $ret;
			}
		}
		foreach($this->workpapers as $wp) {
			if ($wp->id == $wp_id) {
				return $wp;
			}
		}
		return null;
	}
	
	public function get_ref() {
		return strtoupper($this->code);
	}
}

class WORKPAPER {
	public $id;
	// public $workpaper_group_id;
	// public $lead_schedules_id;
	public $parent_table;
	public $parent_id;
	public $name;
	public $code;
	public $code_number;
	public $notes;
	public $reviewer_id;
	public $reviewed_date;
	public $manager_id;
	public $type;
	public $status;
    public function __construct($id=0) {
        if($id!=0){
            $this->get_workpaper_by_id($id);
        }else{
            $this->id=0;
			$this->parent_table='';
			$this->parent_id=0;
            // $this->workpaper_group_id=0;
            // $this->lead_schedules_id=0;
            $this->name='';
            $this->code='';
			$this->code_number=0;
            $this->notes='';
			$this->reviewer_id=0;
			$this->reviewed_date=0;
			$this->manager_id=0;
			$this->type=WP_TYPE::generic;
			$this->status = WP_STATUS::not_started;
        }
        return $this;
    }

	public function get_workpaper_by_id($id){
        global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
        $sql=$wpdb->prepare("SELECT * FROM wp_workpapers WHERE id=%d AND manager_id=%d", $id, $current_user->get_manager_id());
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->id=$id;
			$this->parent_table=$rows[0]->parent_table;
			$this->parent_id=$rows[0]->parent_id;
			//             $this->workpaper_group_id=$rows[0]->workpaper_group_id;
			// $this->lead_schedules_id=$rows[0]->lead_schedules_id;
            $this->name=$rows[0]->name;
            $this->code=$rows[0]->code;
			$this->code_number=$rows[0]->code_number;
            $this->notes=$rows[0]->notes;
            $this->reviewer_id=$rows[0]->reviewer_id;
            $this->reviewed_date=$rows[0]->reviewed_date;
            $this->manager_id=$rows[0]->manager_id;
            $this->type=$rows[0]->type;
			$this->status=$rows[0]->status;
        }
        return $this;
    }

	public function get_status() {
		return $this->status;
	}
	
	public function set_status($new_status) {
		global $wpdb;
		$this->status = $new_status;
		$current_user=new USER_INFO(wp_get_current_user()->ID);

		$ret = $wpdb->update("wp_workpapers", 
			array('status' => $this->status),
			array(
				'id' => $this->id,
				'manager_id' => $current_user->get_manager_id()
			));
			
		if ($ret === false) {
			error_log("ERROR updating status to [". $this->status . "] for workpaper id=[" . $this->id . "]");
		} else {
			if ($this->type == WP_TYPE::trial_balance && $new_status == WP_STATUS::completed) {
				// Abel: Only the competed state should affect the individual drop downs
				// update status for tb entries

				$ret_update = $wpdb->query(
					$wpdb->prepare("UPDATE `wp_wpp_tb_entries` ent, `wp_wpp_tb` tb " . 
								   "SET status=%d WHERE parent_wp_id=%d AND " . 
								   "tb.id=ent.wp_wpp_tb_id AND tb.manager_id=%d",
								   $this->status, $this->id, $current_user->get_manager_id()));

				if ($ret_update === false) {
					error_log("ERROR updating status for tb entries in wp_wpp_tb for workpaper id=" . $this->id);
					return 0;
				} else {
					return 1;
				}
			} else {
				return 1;
			}
		}
		return 0;
	}
	
	public function insert_to_db() {
        global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		$ret = $wpdb->insert( "wp_workpapers", 
			array(
				'parent_table' => $this->parent_table, 
				'parent_id' => $this->parent_id, 
				// 'workpaper_group_id' => $this->workpaper_group_id, 
				// 'lead_schedules_id' => $this->lead_schedules_id, 
				'name' => $this->name,
				'code' => $this->code,
				'code_number' => $this->code_number,
				'notes' => $this->notes,
				'reviewer_id' => $this->reviewer_id,
				'reviewed_date' => $this->reviewed_date,
				'manager_id' => $current_user->get_manager_id(),
				'type' => $this->type,
				'status' => $this->status
				));
		if ($ret === false) {
			error_log("ERROR inserting workpaper name=[" . $this->name . "], id=[" . $this->id . "]");
		} else {
			$this->id = $wpdb->insert_id;
		}
		return 	$this->id;		
	}
	
	public function update_reviewer_and_date() {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		$this->reviewer_id = $current_user->ID; // assign current user as reviewer
		$this->reviewed_date = time();	// assign current time
		
		$ret = $wpdb->update("wp_workpapers",
				array(
					'reviewer_id' => $this->reviewer_id,
					'reviewed_date' => $this->reviewed_date,
				),
				array(
					'id' => $this->id,
					'manager_id' => $current_user->get_manager_id()
				));
		if ($ret === false) {
			error_log("ERROR updating workpaper reviewer with reviewer_id=[" . $this->reviewer_id . "], id=[" . $this->id . "]");
		}
		return $ret;
	}
	
	
	public function clear_reviewer_and_date() {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		$this->reviewer_id = 0; // clear reviewer
		$this->reviewed_date = 0;	// clear date
		
		$ret = $wpdb->update("wp_workpapers",
				array(
					'reviewer_id' => $this->reviewer_id,
					'reviewed_date' => $this->reviewed_date,
				),
				array(
					'id' => $this->id,
					'manager_id' => $current_user->get_manager_id()
				));
		if ($ret === false) {
			error_log("ERROR clearing workpaper reviewer id, id=[" . $this->id . "]");
		}
		return $ret;
	}
	
	public function delete_data() {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		if ($this->type == WP_TYPE::trial_balance) {
			// delete tb entries
			$ret_del = $wpdb->delete( 'wp_wpp_tb', 
					array(
						'parent_wp_id' => $this->id,
						'manager_id' => $current_user->get_manager_id()
					));
			if ($ret_del === false) {
				error_log("ERROR deleting tb entries in wp_wpp_tb for workpaper id=" . $this->id);
				return 0;
			} else {
				return 1;
			}
		} else {
			return 1;
		}
	}

	public function delete() {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		
		// delete wp relationship
		$ret2 = $wpdb->delete( 'wp_wpp_relations', array('workpaper_id' => $this->id) );
		if ($ret2 === false) {
			error_log("ERROR deleting workpaper relationship, workpaper id=[" . $this->id . "]");
		}
		
		$this->delete_data();
		
		// delete this workpaper
		$ret = $wpdb->delete( 
			'wp_workpapers', 
				array(
					'id' => $this->id,
					'manager_id' => $current_user->get_manager_id()
				));
		if ($ret === false) {
			error_log("ERROR deleting workpaper id=" . $this->id);
			return 0;
		} else {
			return 1;
		}	
	}
	
	public function check_permission($user_info, $id) {
        global $wpdb;

		$sql = $wpdb->prepare("SELECT manager_id FROM wp_workpapers WHERE id=%d", $id);
		$ret = $wpdb->get_var($sql);

		if ($ret == $user_info->get_manager_id()) {
			return true;
		} else {
			error_log("Check permission failed for workpaper_id=$id, expected manager_id=$ret, current manager_id=" . $user_info->get_manager_id() . ", user_id=" . $user_info->ID);
		}
		return false;
	}
	
	public function get_workpaper_period($id = 0) {
        global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		if ($id == 0) {
			$id = $this->id;
		}
		$sql = $wpdb->prepare(
				"SELECT parent_table, parent_id FROM wp_workpapers WHERE id=%d AND manager_id=%d", 
				$id, $current_user->get_manager_id());
		$results = $wpdb->get_row($sql);
		$parent = null;
		$parent_id = $results->parent_id;
		if ($results == null) {
			error_log("WORKPAPER::get_workpaper_period() - no permission for workpaper_id=$id, user_id=" . $current_user->ID);
			return null;
		} else if ($results->parent_table === 'wp_wpp_lead_schedules') {
			$parent = new LEAD_SCHEDULES();
		} else if ($results->parent_table === 'wp_wpp_group') {
			$parent = new WORKPAPER_GROUP();
		} else if ($results->parent_table === 'wp_wpp_tb') {
			$sql="SELECT parent_wp_id FROM wp_wpp_tb WHERE id='".$results->parent_id."'";
			$parent_id = $wpdb->get_var($sql);
			$parent = new WORKPAPER();
		} else {
			error_log("WORKPAPER::get_workpaper_period() - Invalid parent table for workpaper - " . $results->parent_table);
			return null;
		}
		return $parent->get_workpaper_period($parent_id);
	}
	
	// lazy static function to get workpaper period balance sheet date
	public function get_balance_sheet_date($wp_id) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		$balance_sheet_date = $wpdb->get_var(
			$wpdb->prepare("SELECT wpp.balance_sheet_date
			FROM `wp_wpp_period` wpp, `wp_wpp_group` wpg, `wp_wpp_relations` wpr
			WHERE wpp.id = wpg.workpaper_period_id
			AND wpg.id = wpr.related_id
			AND wpr.workpaper_id =%d AND wpp.manager_id=%d",
			$wp_id, $current_user->get_manager_id()));
		return $balance_sheet_date;
	}
	
	// lazy static function to get workpaper period id
	public function get_workpaper_period_id($wp_id) {
		global $wpdb;
		$wpp_id = $wpdb->get_var(
			$wpdb->prepare("SELECT wpg.workpaper_period_id
			FROM `wp_wpp_group` wpg, `wp_wpp_relations` wpr
			WHERE wpg.id = wpr.related_id
			AND wpr.workpaper_id =%d",
			$wp_id));
		return $wpp_id;
	}
	
	public function rename($user_info, $new_name) {
		// check permissions
        global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		$ret = $wpdb->update("wp_workpapers",
			array(
				"name" => $new_name
			),
			array(
				"id" => $this->id,
				"manager_id" => $current_user->get_manager_id()
			));
		if ($ret === false) {
			error_log("ERROR updating name for workpaper id " . $this->id);
			return false;
		} else {
			$this->name = $new_name;
			error_log("SUCCESS!! Updated name for workpaper id " . $this->id);
			return true;
		}
		return false;
	}
	
	public function change_code($new_code) {
		global $wpdb;
		$user_info = new USER_INFO(wp_get_current_user()->ID);
		$ret = $wpdb->update("wp_workpapers",
			array(
				"code" => $new_code
			),
			array(
				"id" => $this->id,
				"manager_id" => $user_info->get_manager_id()
			));
		if ($ret === false) {
			error_log("ERROR updating code for workpaper id " . $this->id);
			return false;
		} else {
			$this->code = $new_code;
			error_log("SUCCESS!! Updated code for workpaper id " . $this->id);
			return true;
		}
		return false;
	}
	
	public function get_ref() {
		return strtoupper($this->code) . strtoupper($this->code_number);
	}
	
	public function get_url() {
		return home_url('/workpaper/?id=' . $this->id);
	}
}


class LEAD_SCHEDULES {
	public $id;
	public $workpaper_group_id;
	public $name;
	public $code;
	public $code_number;
	public $notes;
    public $components; // array of lead_schedules
    public $workpapers;
    public function __construct($id=0) {
        if($id!=0){
            $this->get_lead_schedules_by_id($id);
        }else{
            $this->id=0;
            $this->workpaper_group_id=0;
            $this->name='';
            $this->code='';
            $this->code_number=0;
            $this->notes='';
            $this->components=array();
            $this->workpapers=array();
        }
        return $this;
    }

	public function get_lead_schedules_by_id($id){
        global $wpdb;
        $sql="SELECT * FROM wp_wpp_lead_schedules WHERE id='".$id."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->id=$id;
            $this->workpaper_group_id=$rows[0]->workpaper_group_id;
            $this->name=$rows[0]->name;
            $this->code=$rows[0]->code;
            $this->code_number=$rows[0]->code_number;
            $this->notes=$rows[0]->notes;
            // get components
			$sql="SELECT lead_schedules_component_id FROM wp_wpp_lead_schedules_components WHERE lead_schedules_parent_id='" . $this->id . "' order by lead_schedules_component_id";
			$inner_rows=$wpdb->get_results($sql);
			foreach ($inner_rows as $row){
				$new_component = new LEAD_SCHEDULES($row->lead_schedules_component_id);
                $this->components[] = $new_component;
            }
            // get workpapers
			$sql="SELECT workpaper_id FROM wp_wpp_relations WHERE " . 
				 "related_table='wp_wpp_lead_schedules' and related_id='" . $this->id . 
				 "' order by workpaper_id";
			$inner_rows2=$wpdb->get_results($sql);
			foreach ($inner_rows2 as $row){
				$new_wp = new WORKPAPER($row->workpaper_id);
                $this->workpapers[] = $new_wp;
            }
			
        }
        return $this;
    }

	public function insert_to_db() {
        global $wpdb;
		$ret = $wpdb->insert( "wp_wpp_lead_schedules", 
			array(
				'workpaper_group_id' => $this->workpaper_group_id, 
				'name' => $this->name,
				'code' => $this->code,
				'code_number' => $this->code_number,
				'notes' => $this->notes,
				));
		if ($ret === false) {
			error_log("ERROR inserting lead schedules name=[" . $this->name . "], id=[" . $this->id . "]");
		} else {
			foreach($this->components as $ls) {
				$ls->workpaper_group_id=$this->workpaper_group_id;
				$ls->insert_to_db();
				$ret2 = $wpdb->insert( "wp_wpp_lead_schedules_components", 
					array(
						'lead_schedules_parent_id' => $this->id, 
						'lead_schedules_component_id' => $ls->id,
						));
				if ($ret2 === false) {
					error_log("ERROR inserting lead schedules-component relationship ls id=[" . $this->id . "], component ls id=[" . $ls->id . "]");
				}				
			}
			foreach($this->workpapers as $wp) {
				$wp->workpaper_group_id=$this->workpaper_group_id;
				$wp->lead_schedules_id=$this->id;
				$wp->insert_to_db();
				foreach($this->workpapers as $wp) {
					$wp->insert_to_db();
					$ret2 = $wpdb->insert( "wp_wpp_relations", 
						array(
							'related_id' => $this->id, 
							'related_table' => 'wp_wpp_lead_schedules', 
							'workpaper_id' => $wp->id,
							));
					if ($ret2 === false) {
						error_log("ERROR inserting lead schedules-workpaper relationship ls id=[" . $this->id . "], workpaper id=[" . $wp->id . "]");
					}				
				}
			}
			$this->id = $wpdb->insert_id;
		}
		return 	$this->id;		
	}

	public function delete() {
		global $wpdb;
		// delete component relationship
		$ret2 = $wpdb->delete( 'wp_wpp_lead_schedules_components', array('lead_schedules_component_id' => $this->id) );
		if ($ret2 === false) {
			error_log("ERROR deleting lead_schedules-component relationship ls component id=[" . $this->id . "]");
		}

		// delete workpapers
		if (isset($this->workpapers)) {
			foreach($this->workpapers as $wp) {
				// delete wp
				$wp->delete();
			}
		}
		// delete components
		if (isset($this->components)) {
			foreach($this->components as $ls) {
				// delete component
				$ls->delete();
			}
		}
		// delete this ls
		$ret = $wpdb->delete( 'wp_wpp_lead_schedules', array('id' => $this->id) );
		if ($ret === false) {
			error_log("ERROR deleting lead schedules id=" . $this->id);
			return 0;
		} else {
			return 1;
		}
	}

	public function get_status() {
		$ls_status = 4;
		if (isset($this->components)) {
			foreach ($this->components as $component) {
				$comp_status = $component->get_status();
				if ($comp_status < $ls_status) {
					$ls_status = $comp_status;
				}
			}
		}
		if (isset($this->workpapers)) {
			foreach ($this->workpapers as $wp) {
				$wp_status = $wp->get_status();
				if ($wp_status < $ls_status) {
					$ls_status = $wp_status;
				}
			}
		}
		return $ls_status;
	}
	
	public function set_status($new_status) {
		if (isset($this->components)) {
			foreach ($this->components as $component) {
				$component->set_status($new_status);
			}
		}
		if (isset($this->workpapers)) {
			foreach ($this->workpapers as $wp) {
				$wp->set_status($new_status);
			}
		}
	}
	
	public function check_permission($user_info, $id) {
        global $wpdb;
		$sql="SELECT workpaper_group_id FROM wp_wpp_lead_schedules WHERE id='".$id."'";
		$wgid = $wpdb->get_var($sql);
		if ($wgid > 0) {
			$wpg = new WORKPAPER_GROUP();
			return $wpg->check_permission($user_info, $wgid);
		}
		return false;
	}
	
	public function get_workpaper_period($id = 0) {
        global $wpdb;
		if ($id == 0) {
			$id = $this->id;
		}
		$sql="SELECT workpaper_group_id FROM wp_wpp_lead_schedules WHERE id='".$id."'";
		$wgid = $wpdb->get_var($sql);
		if ($wgid > 0) {
			$wpg = new WORKPAPER_GROUP();
			return $wpg->get_workpaper_period($wgid);
		} else {
			error_log("Can't find workpaper period for lead schedule id=" . $id);
		}
		
		return null;
	}
	
	public function get_workpaper_by_id($wp_id) {
		if (isset($this->components)) {
			foreach($this->components as $comp) {
				$ret = $comp->get_workpaper_by_id($wp_id);
				if ($ret !== null) {
					return $ret;
				}
			}
		}
		foreach($this->workpapers as $wp) {
			if ($wp->id == $wp_id) {
				return $wp;
			}
		}
		return null;
	}
	
	public function change_code($new_code) {
		global $wpdb;
		$user_info = new USER_INFO(wp_get_current_user()->ID);
		if ($this->check_permission($user_info, $this->id)) {
			if (isset($this->components)) {
				foreach($this->components as $comp) {
					$comp->change_code($new_code);
				}
			}
			foreach($this->workpapers as $wp) {
				$wp->change_code($new_code);
			}
			
			$ret = $wpdb->update("wp_wpp_lead_schedules",
				array(
					"code" => $new_code
				),
				array(
					"id" => $this->id
				));
			if ($ret === false) {
				error_log("ERROR updating code for lead schedule id " . $this->id);
				return false;
			} else {
				$this->code = $new_code;
				error_log("SUCCESS!! Updated code for lead schedule id " . $this->id);
				return true;
			}
		}
		return false;
	}

	public function get_ref() {
		return strtoupper($this->code) . strtoupper($this->code_number);
	}	
    
    public function get_code_by_wpgroup_id($id){
        global $wpdb;
        $sql="SELECT * FROM wp_wpp_lead_schedules WHERE workpaper_group_id='".$id."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->id=$id;
            $this->workpaper_group_id=$rows[0]->workpaper_group_id;
            $this->name=$rows[0]->name;
            $this->code=$rows[0]->code;
            $this->code_number=$rows[0]->code_number;
            $this->notes=$rows[0]->notes;
        }
        return $this;
    }
}

class XERO_CLIENT_ACCOUNTS {
	public $client_id;
	public $accounts;
    public function __construct($client_id=0) {
        if($client_id!=0){
            $this->accounts=array();
            $this->get_accounts_by_client_id($client_id);
        }else{
            $this->client_id=0;
            $this->accounts=array();
        }
        return $this;
    }

	public function get_accounts_by_client_id($client_id){
        global $wpdb;
		$this->client_id=$client_id;
        $sql="SELECT * FROM wp_wpp_xero_client_accounts WHERE client_id='".$client_id."'";
        $rows=$wpdb->get_results($sql);
        foreach($rows as $row) {
			$obj = new stdClass();
			$obj->id = $row->id;
			$obj->client_id = $row->client_id;
			$obj->xero_account_id = $row->xero_account_id;
			$obj->xero_account_type = $row->xero_account_type;
			$obj->xero_account_name = $row->xero_account_name;
			$obj->xero_code = $row->xero_code;
			$obj->wp_account_type = $row->wp_account_type;
			$this->accounts[(string) $row->xero_account_id] = $obj;
		}
        return $this;
    }

	public function insert_to_db($client_id, $xero_account_id, $xero_account_type, $xero_code, $xero_account_name) {
        global $wpdb;
		$wp_account_type = xero_account_type_to_wp($xero_account_type);
		$ret = $wpdb->insert( "wp_wpp_xero_client_accounts", 
			array(
				'client_id' => $client_id, 
				'xero_account_id' => $xero_account_id,
				'xero_account_type' => $xero_account_type,
				'xero_account_name' => $xero_account_name,
				'xero_code' => $xero_code,
				'wp_account_type' => $wp_account_type
				));
		if ($ret === false) {
			error_log("ERROR inserting Xero Account Type, client_id=[$client_id], xero_account_id=[$xero_account_id], xero_account_type=[$xero_account_type], wp_account_type=[$wp_account_type]");
			return -1;
		} else {
			$obj = new stdClass();
			$obj->id = $wpdb->insert_id;
			$obj->client_id = $client_id;
			$obj->xero_account_id = $xero_account_id;
			$obj->xero_account_type = $xero_account_type;
			$obj->xero_account_name = $xero_account_name;
			$obj->xero_code = $xero_code;
			$obj->wp_account_type = $wp_account_type;
			$this->accounts[(string) $xero_account_id] = $obj;
			return $wpdb->insert_id;
		}
	}
	
	public function get_wp_account_by_xero_id($xero_account_id) {
		if (isset($this->accounts[(string) $xero_account_id])) {
			return $this->accounts[(string) $xero_account_id]->wp_account_type;
		} else {
			return -1;
		}
	}
	
	public function get_id_by_xero_id($xero_account_id) {
		if (isset($this->accounts[(string) $xero_account_id])) {
			return $this->accounts[(string) $xero_account_id]->id;
		} else {
			return 0;
		}
	}
	
	public function delete_accounts_by_client($client_id) {
		global $wpdb;
		$ret = $wpdb->delete("wp_wpp_xero_client_accounts", 
			array(
				'client_id' => $client_id,
				));
		if ($ret === false) {
			error_log("ERROR deleting xero accounts for client_id=[$client_id]");
		} else {
			unset($this->accounts);
			$this->accounts = array();
		}
	}
	
	// static
	// get code, description for autocomplete, order by description
	public function get_codes_and_descriptions($client_id) {
		global $wpdb;
		
		$codes_descriptions = $wpdb->get_results(
			$wpdb->prepare("SELECT xero_code as code, xero_account_name as description FROM wp_wpp_xero_client_accounts " . 
						   "WHERE client_id=%d ORDER BY xero_account_name", $client_id));
		
		return $codes_descriptions;
	}
		
	// static
	// get distinct codes for autocomplete
	public function get_distinct_codes($client_id) {
		global $wpdb;
		
		$codes = $wpdb->get_results(
			$wpdb->prepare("SELECT distinct(xero_code) as code FROM wp_wpp_xero_client_accounts " . 
						   "WHERE client_id=%d ORDER BY xero_code", $client_id));
		return $codes;
	}
	
	// static
	public function get_hotlink_url($description, $account_type, $xero_account_id, $workpaper_period) {
		$desc = normalise_description_for_matching_no_escape($description);
		if ($desc == 'debtorscontrol' ||
			$desc == 'tradedebtors' ||
			$desc == 'debtors' ||
			$desc == 'accountsreceivable') {
			$url = 'https://go.xero.com/Reports/report2.aspx?reportId=fceb4c93-73cb-4523-b5e5-d2671f5326cf&report=&statement=6abd4259-b811-4ba6-a7c0-df1784d5c83d&attPage=&date=%s';
			return sprintf($url, date("d M Y", $workpaper_period->balance_sheet_date));
		} else if ($desc == 'creditorscontrol' ||
			$desc == 'tradecreditors' ||
			$desc == 'creditors' ||
			$desc == 'accountspayable') {
			$url = 'https://go.xero.com/Reports/report2.aspx?reportId=4a11df7a-fc35-47ea-be6b-0803951491b4&report=&statement=f3dc0445-c702-4fcf-a893-04359c156831&attPage=&date=%s';
			return sprintf($url, date("d M Y", $workpaper_period->balance_sheet_date));
		} else if ($account_type == 4) {
			// Bank / Cash
			$url = 'https://go.xero.com/Reports/report2.aspx?reportId=e1f121ed-ef6d-47ad-b20b-cd6fccf3cda2&report=&statement=17e61be5-f96b-478c-8ef1-a41b0bbe33e6&attPage=&bankAccountID=%s&date=%s';
			return sprintf($url, $xero_account_id, date("d M Y", $workpaper_period->balance_sheet_date));
		} else {
			$url = 'https://go.xero.com/Reports/report2.aspx?reportId=1b4204cc-00cd-4bc7-b0b7-7c292905bbea&report=&statement=e604789f-6dba-44e6-b022-d8e18ed2a801&attPage=&account=%s&fromDate=%s&toDate=%s';
			return sprintf($url, $xero_account_id, date("d M Y", $workpaper_period->comparative_date + (24 * 60 * 60)), date("d M Y", $workpaper_period->balance_sheet_date));
		}		
	}
}


class QB_CLIENT_ACCOUNTS {
	public $client_id;
	public $accounts;
    public function __construct($client_id=0) {
        if($client_id!=0){
            $this->accounts=array();
            $this->get_accounts_by_client_id($client_id);
        }else{
            $this->client_id=0;
            $this->accounts=array();
        }
        return $this;
    }

	public function get_accounts_by_client_id($client_id){
        global $wpdb;
		$this->client_id=$client_id;
        $sql=$wpdb->prepare("SELECT * FROM wp_wpp_qb_client_accounts WHERE client_id=%d", $client_id);
        $rows=$wpdb->get_results($sql);
        foreach($rows as $row) {
			$obj = new stdClass();
			$obj->client_id = $row->client_id; 
			$obj->qb_account_id = $row->qb_account_id;
			$obj->qb_account_type = $row->qb_account_type;
			$obj->qb_account_name = $row->qb_account_name;
			$obj->qb_code = $row->qb_code;
			$obj->wp_account_type = $row->wp_account_type;
			$this->accounts[(string) $row->qb_account_id] = $obj;
		}
        return $this;
    }

	public function insert_to_db($client_id, $qb_account_id, $qb_account_type, $qb_code, $qb_account_name) {
        global $wpdb;
		$wp_account_type = qb_account_type_to_wp($qb_account_type);

		// delete old entry if exists
		$wpdb->delete("wp_wpp_qb_client_accounts", 
			array(
				'client_id' => $client_id,
				'qb_account_id' => $qb_account_id));

		$ret = $wpdb->insert( "wp_wpp_qb_client_accounts", 
			array(
				'client_id' => $client_id, 
				'qb_account_id' => $qb_account_id,
				'qb_account_type' => $qb_account_type,
				'qb_account_name' => $qb_account_name,
				'qb_code' => $qb_code,
				'wp_account_type' => $wp_account_type
				));
		if ($ret === false) {
			error_log("ERROR inserting Quickbooks Account Type, client_id=[$client_id], qb_account_id=[$qb_account_id], qb_account_type=[$qb_account_type], wp_account_type=[$wp_account_type],qb_code=[$qb_code]");
			return -1;
		} else {
			$obj = new stdClass();
			$obj->client_id = $client_id;
			$obj->qb_account_id = $qb_account_id;
			$obj->qb_account_type = $qb_account_type;
			$obj->qb_account_name = $qb_account_name;
			$obj->qb_code = $qb_code;
			$obj->wp_account_type = $wp_account_type;
			$this->accounts[(string) $qb_account_id] = $obj;
			return $wpdb->insert_id;
		}
	}
	
	public function get_wp_account_by_qb_id($qb_account_id) {
		if (isset($this->accounts[(string) $qb_account_id])) {
			return $this->accounts[(string) $qb_account_id]->wp_account_type;
		} else {
			return -1;
		}
	}
	
	public function delete_accounts_by_client($client_id) {
		global $wpdb;
		$ret = $wpdb->delete("wp_wpp_qb_client_accounts", 
			array(
				'client_id' => $client_id,
				));
		if ($ret === false) {
			error_log("ERROR deleting qb accounts for client_id=[$client_id]");
		} else {
			unset($this->accounts);
			$this->accounts = array();
		}
	}
	
	// static
	// get code, description for autocomplete, order by description
	public function get_codes_and_descriptions($client_id) {
		global $wpdb;
		
		$codes_descriptions = $wpdb->get_results(
			$wpdb->prepare("SELECT qb_code as code, qb_account_name as description FROM wp_wpp_qb_client_accounts " . 
						   "WHERE client_id=%d ORDER BY qb_account_name", $client_id));
		
		return $codes_descriptions;
	}
		
	// static
	// get distinct codes for autocomplete
	public function get_distinct_codes($client_id) {
		global $wpdb;
		
		$codes = $wpdb->get_results(
			$wpdb->prepare("SELECT distinct(qb_code) as code FROM wp_wpp_qb_client_accounts " . 
						   "WHERE client_id=%d ORDER BY qb_code", $client_id));
		return $codes;
	}
	
	// static
	public function get_hotlink_url($workpaper_period) {
		return 'https://uk.qbo.intuit.com/app/report?rptId=txreports/QZReport&total=no&title=Transaction+Detail+by+%7BGroupByValue%7D&token=TX_DET_BY_ACCT&length=25&requestURI=TX_DET_BY_ACCT&groupby=%28Account%2FAccountTypeID%2CAccount%2FOrderName&date_macro=custom&customized=yes&high_date=' . date("d%2\Fm%2\FY", $workpaper_period->balance_sheet_date) . '&low_date=' . date("d%2\Fm%2\FY", $workpaper_period->comparative_date + (24 * 60 * 60));
	}
}

class KASHFLOW_CLIENT_ACCOUNTS {
	public $client_id;
	public $accounts;
    public function __construct($client_id=0) {
        if($client_id!=0){
            $this->accounts=array();
            $this->get_accounts_by_client_id($client_id);
        }else{
            $this->client_id=0;
            $this->accounts=array();
        }
        return $this;
    }

	public function get_accounts_by_client_id($client_id){
        global $wpdb;
		$this->client_id=$client_id;
        $sql=$wpdb->prepare("SELECT * FROM wp_wpp_kf_client_accounts WHERE client_id=%d", $client_id);
        $rows=$wpdb->get_results($sql);
        foreach($rows as $row) {
			$obj = new stdClass();
			$obj->id = $row->id; 
			$obj->client_id = $row->client_id; 
			$obj->kf_account_id = $row->kf_account_id;
			$obj->kf_account_type = $row->kf_account_type;
			$obj->kf_account_name = $row->kf_account_name;
			$obj->kf_code = $row->kf_code;
			$obj->wp_account_type = $row->wp_account_type;
			$this->accounts[(string) $row->kf_code] = $obj;
		}
        return $this;
    }

	public function insert_to_db($client_id, $kf_account_id, $kf_account_type, $kf_code, $kf_account_name) {
        global $wpdb;
		$wp_account_type = kf_acc_code_to_wp($kf_code);

		// delete old entry if exists
		$wpdb->delete("wp_wpp_kf_client_accounts", 
			array(
				'client_id' => $client_id,
				'kf_account_id' => $kf_account_id));

		$ret = $wpdb->insert( "wp_wpp_kf_client_accounts", 
			array(
				'client_id' => $client_id, 
				'kf_account_id' => $kf_account_id,
				'kf_account_type' => $kf_account_type,
				'kf_account_name' => $kf_account_name,
				'kf_code' => $kf_code,
				'wp_account_type' => $wp_account_type
				));
		if ($ret === false) {
			error_log("ERROR inserting KashFlow Account Type, client_id=[$client_id], kf_account_id=[$kf_account_id], kf_account_type=[$kf_account_type], wp_account_type=[$wp_account_type],kf_code=[$kf_code]");
			return -1;
		} else {
			$obj = new stdClass();
			$obj->id = $wpdb->insert_id;
			$obj->client_id = $client_id;
			$obj->kf_account_id = $kf_account_id;
			$obj->kf_account_type = $kf_account_type;
			$obj->kf_account_name = $kf_account_name;
			$obj->kf_code = $kf_code;
			$obj->wp_account_type = $wp_account_type;
			$this->accounts[(string) $kf_code] = $obj;
			return $wpdb->insert_id;
		}
	}
	
	public function get_wp_account_by_kf_code($kf_code) {
		if (isset($this->accounts[(string) $kf_code])) {
			return $this->accounts[(string) $kf_code]->wp_account_type;
		} else {
			return -1;
		}
	}
	
	public function get_id_by_kf_code($kf_code) {
		if (isset($this->accounts[(string) $kf_code])) {
			return $this->accounts[(string) $kf_code]->id;
		} else {
			return -1;
		}
	}

	public function delete_accounts_by_client($client_id) {
		global $wpdb;
		$ret = $wpdb->delete("wp_wpp_kf_client_accounts", 
			array(
				'client_id' => $client_id,
				));
		if ($ret === false) {
			error_log("ERROR deleting qb accounts for client_id=[$client_id]");
		} else {
			unset($this->accounts);
			$this->accounts = array();
		}
	}

	// static
	// get code, description for autocomplete, order by description
	public function get_codes_and_descriptions($client_id) {
		global $wpdb;
		
		$codes_descriptions = $wpdb->get_results(
			$wpdb->prepare("SELECT kf_code as code, kf_account_name as description FROM wp_wpp_kf_client_accounts " . 
						   "WHERE client_id=%d ORDER BY kf_account_name", $client_id));
		
		return $codes_descriptions;
	}

	// static
	// get distinct codes for autocomplete
	public function get_distinct_codes($client_id) {
		global $wpdb;
		
		$codes = $wpdb->get_results(
			$wpdb->prepare("SELECT distinct(kf_code) as code FROM wp_wpp_kf_client_accounts " . 
						   "WHERE client_id=%d ORDER BY kf_code", $client_id));
		return $codes;
	}
	
	// static
	public function get_hotlink_url($kf_code, $workpaper_period) {
		return sprintf('https://app.kashflow.com/report-nom-breakdown.asp?id=%d&date1=%s&date2=%s', $kf_code, date("d%2\Fm%2\FY", $workpaper_period->comparative_date + (24 * 60 * 60)), date("d%2\Fm%2\FY", $workpaper_period->balance_sheet_date));
	}
	
}

class FREEAGENT_CLIENT_ACCOUNTS {
	public $client_id;
	public $accounts;
    public function __construct($client_id=0) {
        if($client_id!=0){
            $this->accounts=array();
            $this->get_accounts_by_client_id($client_id);
        }else{
            $this->client_id=0;
            $this->accounts=array();
        }
        return $this;
    }

	public function get_accounts_by_client_id($client_id){
        global $wpdb;
		$this->client_id=$client_id;
        $sql=$wpdb->prepare("SELECT * FROM wp_wpp_fa_client_accounts WHERE client_id=%d", $client_id);
        $rows=$wpdb->get_results($sql);
        foreach($rows as $row) {
			$obj = new stdClass();
			$obj->id = $row->id;
			$obj->client_id = $row->client_id; 
			$obj->fa_description = $row->fa_description;
			$obj->fa_code = $row->fa_code;
			$obj->wp_account_type = $row->wp_account_type;
			$obj->fa_company_subdomain = $row->fa_company_subdomain;
			$this->accounts[(string) $row->fa_code] = $obj;
		}
        return $this;
    }

	public function insert_to_db($client_id, $fa_code, $fa_description, $fa_company_subdomain) {
        global $wpdb;
		$wp_account_type = fa_code_to_wp($fa_code);

		// delete old entry if exists
		$wpdb->delete("wp_wpp_fa_client_accounts", 
			array(
				'client_id' => $client_id,
				'fa_code' => $fa_code));

		$ret = $wpdb->insert( "wp_wpp_fa_client_accounts", 
			array(
				'client_id' => $client_id, 
				'fa_description' => $fa_description,
				'fa_code' => $fa_code,
				'fa_company_subdomain' => $fa_company_subdomain,
				'wp_account_type' => $wp_account_type
				));
		if ($ret === false) {
			error_log("ERROR inserting FreeAgent Account Type, client_id=[$client_id], fa_description=[$fa_description], fa_code=[$fa_code], wp_account_type=[$wp_account_type], fa_company_subdomain=[$fa_company_subdomain]");
			return -1;
		} else {
			$obj = new stdClass();
			$obj->id = $wpdb->insert_id;
			$obj->client_id = $client_id;
			$obj->fa_description = $fa_description;
			$obj->fa_code = $fa_code;
			$obj->fa_company_subdomain = $fa_company_subdomain;
			$obj->wp_account_type = $wp_account_type;
			$this->accounts[(string) $fa_code] = $obj;
			return $wpdb->insert_id;
		}
	}
	
	public function get_wp_account_by_fa_code($fa_code) {
		if (isset($this->accounts[(string) $fa_code])) {
			return $this->accounts[(string) $fa_code]->wp_account_type;
		} else {
			return -1;
		}
	}
	
	public function get_id_by_fa_code($fa_code) {
		if (isset($this->accounts[(string) $fa_code])) {
			return $this->accounts[(string) $fa_code]->id;
		} else {
			return -1;
		}
	}
	
	public function delete_accounts_by_client($client_id) {
		global $wpdb;
		$ret = $wpdb->delete("wp_wpp_fa_client_accounts", 
			array(
				'client_id' => $client_id,
				));
		if ($ret === false) {
			error_log("ERROR deleting qb accounts for client_id=[$client_id]");
		} else {
			unset($this->accounts);
			$this->accounts = array();
		}
	}
	
	// static
	// get code, description for autocomplete, order by description
	public function get_codes_and_descriptions($client_id) {
		global $wpdb;
		
		$codes_descriptions = $wpdb->get_results(
			$wpdb->prepare("SELECT fa_code as code, fa_description as description FROM wp_wpp_fa_client_accounts " . 
						   "WHERE client_id=%d ORDER BY fa_description", $client_id));
		
		return $codes_descriptions;
	}
		
	// static
	// get distinct codes for autocomplete
	public function get_distinct_codes($client_id) {
		global $wpdb;
		
		$codes = $wpdb->get_results(
			$wpdb->prepare("SELECT distinct(fa_code) as code FROM wp_wpp_fa_client_accounts " . 
						   "WHERE client_id=%d ORDER BY fa_code", $client_id));
		return $codes;
	}
	
	// static
	public function get_company_subdomain($client_id) {
		global $wpdb;
		$ret = $wpdb->get_var($wpdb->prepare("SELECT fa_company_subdomain FROM wp_wpp_fa_client_accounts " .
							  "WHERE client_id=%d AND fa_company_subdomain != '' LIMIT 1", $client_id));
		if ($ret === false) {
			error_log("ERROR getting company subdomain for client_id=[$client_id]");
		} else {
			return $ret;
		}
	}

	// static
	public function get_hotlink_url($fa_company_subdomain, $fa_code, $workpaper_period) {
		return sprintf('https://%s.freeagent.com/accounting/show_transactions/%s_%s/%s', $fa_company_subdomain, date("Y-m-d", $workpaper_period->comparative_date + (24 * 60 * 60)), date("Y-m-d", $workpaper_period->balance_sheet_date), $fa_code);
	}
}

class WP_TRIAL_BALANCE {
	public $id;
	public $user_id;
	public $new_tb_import_time;
	public $last_updated_time;
	public $client_id;
	public $manager_id;
	public $parent_wp_id;
	public $workpaper_period;
	
    public function __construct() {
		$this->id=0;
		$this->user_id=0;
		$this->new_tb_import_time=0;
		$this->last_updated_time=0;
		$this->client_id=0;
		$this->manager_id=0;
		$this->parent_wp_id=0;
		$workpaper_period=null;
		$this->entries = array();
        return $this;
    }

	function get_wpp_tb_id($wp_id, $manager_id) {
		global $wpdb;
		return $wpdb->get_var(
			$wpdb->prepare("SELECT id FROM wp_wpp_tb WHERE manager_id=%d AND parent_wp_id=%d",
				$manager_id, $wp_id));
	}
	
	/* Insert tb balance for workpaper by array of rows
	   wp_wpp_tb inserted against User ID
	   $rows is array of description, price
	   $source enum, 0=file, 1=xero, 2=quickbooks, 3=freeagent, 4=kashflow, 5=sageone
	*/
	function insert_wp_balance($source, $user_info, $rows, $client_id, $name, $wpp_id) {
	    global $wpdb;
	    date_default_timezone_set('Europe/London');
		$time = time();
		$manager_id = $user_info->get_manager_id();
		
		// first check in wp_wpp_tb table for master data
		$existing_wpp_tb_id = WP_TRIAL_BALANCE::get_wpp_tb_id($wpp_id, $manager_id);
		$copy_to_draft = true;
		if ($existing_wpp_tb_id > 0) {
			$copy_to_draft = false;
			// already exist, update
			$ret = $wpdb->update("wp_wpp_tb",
				array(
					'user_id' => $user_info->ID,
					'new_tb_import_time' => $time
				), 
				array(
					'id' => $existing_wpp_tb_id
				));
			if ($ret === false) {
				error_log("WP_TRIAL_BALANCE::insert_wp_balance - Error updating existing entry in wp_wpp_tb with metadata! Quitting insert balance");
				return false;
			}
		} else {
			// insert new entry
			$ret = $wpdb->insert("wp_wpp_tb",
				array(
					'user_id' => $user_info->ID,
					'new_tb_import_time' => $time,
					'last_updated_time' => $time,
					'client_id' => $client_id,
					'manager_id' => $manager_id,
					'parent_wp_id' => $wpp_id
				));
			if ($ret === false) {
				error_log("WP_TRIAL_BALANCE::insert_wp_balance - Error inserting new entry in wp_wpp_tb for metadata! Quitting insert balance");
				return false;
			}
			$existing_wpp_tb_id = $wpdb->insert_id;
		}		
		
		// then insert tb entries
		foreach($rows as $row) {
			WP_TRIAL_BALANCE::insert_tb_entry_row($row, $existing_wpp_tb_id, $client_id, $manager_id, $user_info, $time, $source, $copy_to_draft);
		}
		return true;
	}

	public function insert_tb_entry_row($row, $tb_id, $client_id, $manager_id, $user_info, $time, $source, $copy_to_draft) {
		global $wpdb;
		
		// get previously assigned account type for this description
		$result = $wpdb->get_var(
				$wpdb->prepare("SELECT wp_account_type FROM `wp_wpp_client_accounts` WHERE client_id=%d AND manager_id=%d AND description=%s",
					$client_id,
					$manager_id,
					normalise_description_for_matching_no_escape($row->description)
				));	
		$account_type = -1;
		if ($result != null) {
			$account_type = $result;
			error_log("Updated account_type with previously matched");
		} else if (isset($row->account_type) && $source!=0) {
			// for file import, default is NONE, not fixed assets
			$account_type=$row->account_type;
		}
					
		// check if description and parent_wp_id already exist
		$existing_id = $wpdb->get_var(
			$wpdb->prepare("SELECT id FROM wp_wpp_tb_entries WHERE LOWER(replace(description,' ',''))=%s AND wp_wpp_tb_id=%d",
				normalise_description_for_matching_no_escape($row->description), $tb_id));
		if ($existing_id) {
			// update existing
			$ret = $wpdb->update('wp_wpp_tb_entries',
				array(
					"code" => (isset($row->code) ? trim($row->code) : 0),
					"code_id" => (isset($row->code_id) ? trim($row->code_id) : 0),
					"new_price" => $row->price,
					"previous_year_price" => (isset($row->py_price) ? $row->py_price : null),
					"new_user_id" => $user_info->ID,
					"new_time" => $time,
					"new_source" => $source,
					"account_type" => $account_type
				), 
				array(
					"id" => $existing_id
				));
		} else {
			$new_values = array(
							"wp_wpp_tb_id" => $tb_id,
							"code" => (isset($row->code) ? trim($row->code) : 0),
							"code_id" => (isset($row->code_id) ? trim($row->code_id) : 0),
							"description" => trim($row->description),
							"new_price" => $row->price,
							"previous_year_price" => (isset($row->py_price) ? $row->py_price : null),
							"new_user_id" => $user_info->ID,
							"new_time" => $time,
							"new_source" => $source,
							"account_type" => $account_type
							);
							
			$new_specifiers = array('%d','%s', '%d', '%s','%f','%f','%d','%d','%d','%d');
			
			if ($copy_to_draft) {
				$draft_values = array(
							"draft_price" => $row->price,
							"draft_user_id" => $user_info->ID,
							"draft_time" => $time,
							"draft_source" => $source);
				$draft_specifiers = array('%f','%d','%d','%d');
				$new_values = array_merge($new_values, $draft_values);
				$new_specifiers = array_merge($new_specifiers, $draft_specifiers);
			}
			// insert new
			$ret = $wpdb->insert('wp_wpp_tb_entries',$new_values, $new_specifiers);
		}
		
		if ($ret === false) {
			error_log("WP_TRIAL_BALANCE::insert_wp_balance - failed inserting wp_wpp_tb_entries, descp=" . trim($row->description));
			return false;
		}
		return true;
	}
	
	function delete_tb_entries_bulk($wpp_tb_ids_str) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);

		if (preg_match(WP_BULK_ID_REGEX, $wpp_tb_ids_str)) {
			$ret = $wpdb->query(
				$wpdb->prepare(
					"DELETE wp_wpp_tb_entries FROM wp_wpp_tb_entries JOIN wp_wpp_tb " .
					"ON wp_wpp_tb.id=wp_wpp_tb_entries.wp_wpp_tb_id " .
					"WHERE wp_wpp_tb_entries.id in ($wpp_tb_ids_str) AND wp_wpp_tb.manager_id=%d",
					$current_user->get_manager_id()
				)
			);
			
			if ($ret === false) {
				error_log("WP_TRIAL_BALANCE::delete_tb_entries_bulk - DB error bulk deleting tb entries for wp tb items, ids=$wpp_tb_ids_str");
				return false;
			} else {
				return true;
			}
		} else {
			error_log("WP_TRIAL_BALANCE::delete_tb_entries_bulk - Error bulk deleting tb entries for wp tb items, invalid ids=$wpp_tb_ids_str.");
			return false;
		}
	}
	
	function update_wp_account_type_bulk($wpp_tb_ids_str, $account_type_id){
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);

		if (is_numeric($account_type_id) && preg_match(WP_BULK_ID_REGEX, $wpp_tb_ids_str)) {
			$ret = $wpdb->query(
				$wpdb->prepare(
					"UPDATE wp_wpp_tb_entries ent JOIN wp_wpp_tb tb ON tb.id=ent.wp_wpp_tb_id " . 
					"SET ent.account_type=%d WHERE ent.id in ($wpp_tb_ids_str) AND tb.manager_id=%d",
					$account_type_id,
					$current_user->get_manager_id()
				)
			);
			
			if ($ret === false) {
				error_log("WP_TRIAL_BALANCE::update_wp_account_type_bulk - DB error bulk updating account type for wp tb, ids=$wpp_tb_ids_str");
				return false;
			} else {
				$time = time();
				// update or insert client account type
				$rows = $wpdb->get_results("SELECT ent.account_type, ent.description, tb.manager_id, tb.client_id, tb.id as tb_id FROM wp_wpp_tb_entries ent, wp_wpp_tb tb WHERE ent.id in ($wpp_tb_ids_str) AND tb.id=ent.wp_wpp_tb_id");
	            if(count($rows)>0){

					$updated_tb_ids = array();

					foreach ($rows as $row) {
						
						$num_rows_affected = $wpdb->update(
							'wp_wpp_client_accounts',
							array(
								'wp_account_type' => $row->account_type
							),
							array(
								'client_id' => $row->client_id,
								'manager_id' => $row->manager_id,
								'description' => normalise_description_for_matching_no_escape($row->description)
							));
						if ($num_rows_affected <= 0 || $num_rows_affected === false) {
							$ret = $wpdb->insert(
								'wp_wpp_client_accounts',
								array(
									'wp_account_type' => $row->account_type,
									'client_id' => $row->client_id,
									'manager_id' => $row->manager_id,
									'description' => normalise_description_for_matching_no_escape($row->description)
								));
							if ($ret === false) {
								error_log("WP_TRIAL_BALANCE::update_wp_account_type_bulk - Error encountered inserting new row into wp_wpp_client_accounts");
							}
							error_log("WP_TRIAL_BALANCE::update_wp_account_type_bulk - inserted new row into wp_wpp_client_accounts");
						} else {
							error_log("WP_TRIAL_BALANCE::update_wp_account_type_bulk - updated row into wp_wpp_client_accounts");
						}
					}
	            }				
				
				return true;
			}
		} else {
			error_log("WP_TRIAL_BALANCE::update_wp_account_type_bulk - Error bulk updating account type for wp tb, $account_type_id not numeric or invalid ids=$wpp_tb_ids_str.");
			return false;
		}
	}
	
	function update_wp_tb_status_bulk($wpp_tb_ids_str, $status_id){
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);

		if (is_numeric($status_id) && preg_match(WP_BULK_ID_REGEX, $wpp_tb_ids_str)) {
			$ret = $wpdb->query(
				$wpdb->prepare(
					"UPDATE wp_wpp_tb_entries ent JOIN wp_wpp_tb tb ON tb.id=ent.wp_wpp_tb_id " .
					"SET ent.status=%d WHERE ent.id in ($wpp_tb_ids_str) AND tb.manager_id=%d",
					$status_id,
					$current_user->get_manager_id()
				)
			);
			
			if ($ret === false) {
				error_log("WP_TRIAL_BALANCE::update_wp_tb_status_bulk - DB error bulk updating status for wp tb items, ids=$wpp_tb_ids_str");
				return false;
			} else {
				return true;
			}
		} else {
			error_log("WP_TRIAL_BALANCE::update_wp_tb_status_bulk - Error bulk updating status for wp tb, $status_id not numeric or invalid ids=$wpp_tb_ids_str.");
			return false;
		}
	}
	
	function update_new_tb_entries_to_draft_bulk($wpp_tb_ids_str) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		$draft_time = time();
		if (preg_match(WP_BULK_ID_REGEX, $wpp_tb_ids_str)) {
			$ret = $wpdb->query(
				$wpdb->prepare(
					"UPDATE wp_wpp_tb_entries ent, wp_wpp_tb tb " .
					"SET ent.draft_price=ent.new_price, ent.draft_source=ent.new_source, " . 
					"ent.draft_user_id=%d, ent.draft_time=%d, tb.last_updated_time=%d " .
					"WHERE ent.id in ($wpp_tb_ids_str) AND tb.manager_id=%d AND tb.id=ent.wp_wpp_tb_id",
					$current_user->ID,
					$draft_time,
					$draft_time,
					$current_user->get_manager_id()
				)
			);
			
			if ($ret === false) {
				error_log("WP_TRIAL_BALANCE::update_new_tb_entries_to_draft_bulk - DB error bulk updating wp tb new values to draft, ids=$wpp_tb_ids_str");
				return false;
			} else {
				return true;
			}
		} else {
			error_log("WP_TRIAL_BALANCE::update_new_tb_entries_to_draft_bulk - Error bulk updating wp tb new values to draft, invalid ids=$wpp_tb_ids_str.");
			return false;
		}
	}
	
	public function get_last_updated_time($wp_id) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		$ret = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT last_updated_time FROM wp_wpp_tb " .
				"WHERE id=%d and manager_id=%d",
				$wp_id,
				$current_user->get_manager_id()
			)
		);
		
		if ($ret === false) {
			error_log("WP_TRIAL_BALANCE::get_last_updated_time - DB Error getting last_updated_time for tb id $wp_id.");
			return false;
		} else {
			return $ret;
		}
	}

	public function get_tb_for_workpaper_id($wp_id) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		if (!is_numeric($wp_id)) {
			error_log("WP_TRIAL_BALANCE::get_tb_for_workpaper_id - Workpaper id, $wp_id must be a number");
			return array();
		}
		
		$result = $wpdb->get_results(
			$wpdb->prepare("SELECT * FROM wp_wpp_tb WHERE parent_wp_id=%d and manager_id=%d", $wp_id, $current_user->get_manager_id()));
		if ($result !== false) {
			$this->id = $result[0]->id;
			$this->user_id = $result[0]->user_id;
			$this->new_tb_import_time = $result[0]->new_tb_import_time;
			$this->last_updated_time = $result[0]->last_updated_time;
			$this->client_id = $result[0]->client_id;
			$this->manager_id = $result[0]->manager_id;
			$this->parent_wp_id = $result[0]->parent_wp_id;
			$this->entries = $this->get_tb_entries_for_tb_id_and_wp_id($this->id, $wp_id);
		}
		return $this;
	}
	
	function get_tb_entries_for_tb_id_and_wp_id($tb_id, $wp_id) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);

		// order by FA ,debtors ,liability,equity ,revenue and then expenses
		$tb_data = $wpdb->get_results(
			$wpdb->prepare("SELECT ent.*, ent.draft_price as final_price FROM wp_wpp_tb_entries ent WHERE ent.wp_wpp_tb_id=%d AND (ent.new_price != 0 OR ent.draft_price != 0) ORDER BY ent.account_type, ent.id", $tb_id));
		// build hotlink
		$this->_build_3rd_party_hotlinks($tb_id, $tb_data);
		
		$jnl_wp_id = WORKPAPER_PERIOD::find_workpaper_in_my_wpp($wp_id, WP_TYPE::journal);
		
		// get journals for adjustments
		$journals = $wpdb->get_results(
			$wpdb->prepare("SELECT je.* FROM wp_wpp_journal_entries je, " .
				"wp_wpp_journals j WHERE j.id=je.parent_journal_id and j.parent_wp_id=%d and je.show_on_etb=true", $jnl_wp_id));
		
		foreach($journals as $journal_entry) {
			// find matching description from $tb_data
			$target = trim(strtolower($journal_entry->account));
			$found = false;
			for($i=0; $i<count($tb_data); $i++) {
				$tb_row = $tb_data[$i];
				if (trim(strtolower($tb_row->description)) == $target) {
					// found
					$tb_row->adjustment_price += $journal_entry->price;
					$tb_row->final_price = $tb_row->draft_price + $tb_row->adjustment_price; // update final price
					if (isset($tb_row->journal_entry_id) && trim($tb_row->journal_entry_id) !== '') {
						// more than one journal found, append
						$tb_row->journal_entry_id = $tb_row->journal_entry_id . ',' . $journal_entry->id;
						$tb_row->parent_journal_id = $tb_row->parent_journal_id . ',' . $journal_entry->parent_journal_id;
					} else {
						$tb_row->journal_entry_id = $journal_entry->id;
						$tb_row->parent_journal_id = $journal_entry->parent_journal_id;
					}
					$found = true;
					$tb_data[$i] = $tb_row; // re-assign back to returning object
					break;
				}				
			}
			if (!$found) {
				// append $journal_entry to the end of $tb_data
				$new_obj = new stdClass();
				$new_obj->id = $journal_entry->id;
				$new_obj->description = $journal_entry->account;
				$new_obj->code = $journal_entry->code;
				$new_obj->account_type = $journal_entry->account_type;
				$new_obj->adjustment_price = $journal_entry->price;
				$new_obj->final_price = $new_obj->adjustment_price; // update final price
//				$new_obj->status = $journal_entry->status;
				$new_obj->wp_type = 'J';
				$new_obj->journal_entry_id = $journal_entry->id;
				$new_obj->parent_journal_id = $journal_entry->parent_journal_id;
				$tb_data[] = $new_obj;
			}
		}
		return $tb_data;
	}
	
	function post_auto_journals($jnl_wp_id) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);

		$tb_data = $this->entries;
		$diffs = array();
		$rows = array();
		for($i=0; $i<count($tb_data); $i++) {
			$tb_row = $tb_data[$i];
			if (round(abs($tb_row->final_price - $tb_row->new_price), 2) > 0.00) {
				$aDiff = $tb_row->final_price - $tb_row->new_price;

				if (isset($diffs[(string)($aDiff * -1.0)])) {
					
					// got a match
					$other_row = array_shift($diffs[(string)($aDiff * -1.0)]);
					// post journal
					// add journal to the first tb entry in this group
					$entry = new stdClass();
					$entry->code = $other_row->code;
					$entry->account = $other_row->description;
					$entry->price = $aDiff;
					$rows[] = $entry;
					$entry2 = new stdClass();
					$entry2->code = $tb_row->code;
					$entry2->account = $tb_row->description;
					$entry2->price = $aDiff * -1.0;
					$rows[] = $entry2;

					// unset matched row now we have processed it
					//unset($diffs[(string)($aDiff * -1.0)]);
					
				} else {
					// only process if new != final
					if (isset($tb_row->new_price) && isset($tb_row->final_price)) {
						if (round(abs($tb_row->final_price - $tb_row->new_price), 2) > 0.00) {
							// there is a diff
							// check that it's not already assigned
							if (!isset($diffs[(string)$aDiff])) {
								$diffs[(string)$aDiff] = array();
							}
							$diffs[(string)$aDiff][] = $tb_row;
						}
					} else {
						// check that it's not already assigned
						if (!isset($diffs[(string)$aDiff])) {
							$diffs[(string)$aDiff] = array();
						}
						$diffs[(string)$aDiff][] = $tb_row;
					}
				}
			}
		}
		// single journals
		foreach ($diffs as $aDiff => $tb_rows) {
			foreach($tb_rows as $tb_row) {
				// add journal to the first tb entry in this group
				$entry = new stdClass();
				$entry->code = $tb_row->code;
				$entry->account = $tb_row->description;
				$entry->price = ($aDiff * -1.0);
				$rows[] = $entry;
			}
		}
		if (count($rows) > 0) {
			$new_journal = new WP_JOURNAL();
			$new_journal->insert_to_db($current_user, 
							$new_journal->get_next_code_number_for_parent_wp_id($jnl_wp_id), 
							$this->client_id, $jnl_wp_id, "auto post", true, WORKPAPER::get_balance_sheet_date($this->parent_wp_id));
			$new_journal->insert_journal_entries($current_user, $rows, true);
		} else {
			error_log("No auto-journals to post");
		}
	}
	
	function _build_3rd_party_hotlinks($tb_id, $tb_data) {
		global $wpdb;
		$fa_company_subdomain = '';
		
		for($i=0; $i<count($tb_data); $i++) {
			if ($tb_data[$i]->new_source == 1 || ($tb_data[$i]->new_source == 0 && $tb_data[$i]->draft_source == 1)) {
				// XERO
				if ($tb_data[$i]->code_id > 0) {
					$tb_data[$i]->xero_account_id = $wpdb->get_var(
						$wpdb->prepare(
							"SELECT xero_account_id FROM wp_wpp_xero_client_accounts WHERE id=%d AND client_id=%d",
							$tb_data[$i]->code_id, $this->client_id));
				}
				// backup method if code_id doesn't match
				if ($tb_data[$i]->xero_account_id == null && $tb_data[$i]->code != null) {
					$tb_data[$i]->xero_account_id = $wpdb->get_var(
						$wpdb->prepare(
							"SELECT xero_account_id FROM wp_wpp_xero_client_accounts WHERE xero_code=%s AND client_id=%d",
							$tb_data[$i]->code, $this->client_id));
				}
				if ($tb_data[$i]->xero_account_id != null && $this->workpaper_period != null) {
					// build url
					$tb_data[$i]->hotlink_url = XERO_CLIENT_ACCOUNTS::get_hotlink_url($tb_data[$i]->description, $tb_data[$i]->account_type, $tb_data[$i]->xero_account_id, $this->workpaper_period);
				}
			} else if ($tb_data[$i]->new_source == 2 || ($tb_data[$i]->new_source == 0 && $tb_data[$i]->draft_source == 2)) {
				// Quickbooks
				$tb_data[$i]->hotlink_url = QB_CLIENT_ACCOUNTS::get_hotlink_url($this->workpaper_period);
			} else if ($tb_data[$i]->new_source == 3 || ($tb_data[$i]->new_source == 0 && $tb_data[$i]->draft_source == 3)) {
				// Freeagent
				if ($fa_company_subdomain == '' && ($tb_data[$i]->new_source == 3 || 
						($tb_data[$i]->new_source == 0 && $tb_data[$i]->draft_source == 3))) {
					// First get client_id
					$sql = $wpdb->prepare("SELECT client_id FROM wp_wpp_tb WHERE id=%d ORDER BY id desc LIMIT 1", $tb_id);
					$client_id = $wpdb->get_var($sql);
					// then get company subdomain from db
					$fa_company_subdomain = FREEAGENT_CLIENT_ACCOUNTS::get_company_subdomain($client_id);
				}

				if ($tb_data[$i]->code != null && $this->workpaper_period != null) {
					// build url
					$tb_data[$i]->hotlink_url = FREEAGENT_CLIENT_ACCOUNTS::get_hotlink_url($fa_company_subdomain, $tb_data[$i]->code, $this->workpaper_period);
				}
			} else if ($tb_data[$i]->new_source == 4 || ($tb_data[$i]->new_source == 0 && $tb_data[$i]->draft_source == 4)) {
				// KashFlow
				if ($tb_data[$i]->code_id > 0) {
					$tb_data[$i]->kf_account_id = $wpdb->get_var(
						$wpdb->prepare(
							"SELECT kf_account_id FROM wp_wpp_kf_client_accounts WHERE id=%d AND client_id=%d",
							$tb_data[$i]->code_id, $this->client_id));
				}
				// backup method if code_id doesn't match
				if ($tb_data[$i]->kf_account_id == null && $tb_data[$i]->code != null) {
					$tb_data[$i]->kf_account_id = $wpdb->get_var(
						$wpdb->prepare(
							"SELECT kf_account_id FROM wp_wpp_kf_client_accounts WHERE kf_code=%s AND client_id=%d",
							$tb_data[$i]->code, $this->client_id));
				}
				if ($tb_data[$i]->kf_account_id != null && $this->workpaper_period != null) {
					// build url
					$tb_data[$i]->hotlink_url = KASHFLOW_CLIENT_ACCOUNTS::get_hotlink_url($tb_data[$i]->kf_account_id, $this->workpaper_period);
				}
			}
			
			
		}
	}
	
	function delete_new_tb_data($wp_id) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		
		$tb_id = WP_TRIAL_BALANCE::get_wpp_tb_id($wp_id, $current_user->get_manager_id());

		if ($tb_id === false) {
			error_log("WP_TRIAL_BALANCE::delete_new_tb_data failed to retrieve tb_id from wp_wpp_tb where parent_wp_id=$wp_id");
			return true;
		}

		// delete all tb entries without a draft price
		$ret = $wpdb->query(
			$wpdb->prepare("DELETE FROM wp_wpp_tb_entries WHERE wp_wpp_tb_id=%d AND draft_price IS NULL", $tb_id));

		if ($ret === false) {
			error_log("WP_TRIAL_BALANCE::delete_new_tb_data failed to delete entries where draft_price is null");
		}

		// null all new_price where draft price exist
		$ret = $wpdb->query(
			$wpdb->prepare("UPDATE wp_wpp_tb_entries SET new_price=NULL WHERE wp_wpp_tb_id=%d", $tb_id));
		
		if ($ret === false) {
			error_log("WP_TRIAL_BALANCE::delete_new_tb_data failed to update new_price=null.");
		}
		return true;
	}
	
	// static
	// get code, description for autocomplete, order by description
	public function get_codes_and_descriptions($wp_id) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		
		$codes_descriptions = $wpdb->get_results(
			$wpdb->prepare("SELECT code, description FROM wp_wpp_tb_entries ent, wp_wpp_tb tb " . 
						   "WHERE tb.parent_wp_id=%d AND (ent.new_price != 0 OR ent.draft_price != 0) " . 
						   "AND ent.wp_wpp_tb_id=tb.id AND tb.manager_id=%d ORDER BY description", $wp_id, $current_user->get_manager_id()));
		
		return $codes_descriptions;
	}
		
	// static
	// get distinct codes for autocomplete
	public function get_distinct_codes($wp_id) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		
		$codes = $wpdb->get_results(
			$wpdb->prepare("SELECT distinct(code) FROM wp_wpp_tb_entries ent, wp_wpp_tb tb " . 
						   "WHERE tb.parent_wp_id=%d AND (ent.new_price != 0 OR ent.draft_price != 0) " . 
						   "AND ent.wp_wpp_tb_id=tb.id AND tb.manager_id=%d ORDER BY code", $wp_id, $current_user->get_manager_id()));
		return $codes;
	}
	
	// static
	public function get_source_of_entries($wp_id) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		
		$source = $wpdb->get_var(
			$wpdb->prepare("SELECT new_source FROM wp_wpp_tb_entries ent, wp_wpp_tb tb " . 
						   "WHERE tb.parent_wp_id='%d' AND (ent.new_price != 0) " . 
						   "AND ent.wp_wpp_tb_id=tb.id AND tb.manager_id=%d LIMIT 1", $wp_id, $current_user->get_manager_id()));
		
		return $source;		
	}
}

class WP_JOURNAL {
	public $id;
	public $code_number;
	public $time;
	public $client_id;
	public $manager_id;
	public $parent_wp_id;
	public $narrative;
	public $show_on_etb;
	public $entries;
	
    public function __construct($id=0) {
        if($id!=0){
            $this->get_journal_by_id($id);
        }else{
            $this->id=0;
            $this->code_number=0;
			$this->time=0;
            $this->client_id=0;
            $this->manager_id=0;
            $this->parent_wp_id=0;
            $this->narrative='';
			$this->show_on_etb = true;
			$this->entries = array();
        }
        return $this;
    }

	public function get_journal_by_id($id){
        global $wpdb;
		$this->id=$id;
		$rows = $wpdb->get_results(
			$wpdb->prepare("SELECT * FROM wp_wpp_journals WHERE id=%d ORDER BY id", $id));
		if ($rows !== false) {
			$current_user=new USER_INFO(wp_get_current_user()->ID);
			if ($rows[0]->manager_id == $current_user->get_manager_id()) {
				$this->populate_fields($rows[0]);
			} else {
				error_log("WP_JOURNAL::get_journal_by_id - User id, " . $current_user->id . " has no permission to view this journal id, " . $id);
			}
		} else {
			error_log("WP_JOURNAL::get_journal_by_id failed, id - $id");
		}
        return $this;
    }

	function populate_fields($row) {
		$this->id=$row->id;
		$this->code_number = $row->code_number;
		$this->time=$row->time;
		$this->client_id = $row->client_id;
		$this->manager_id = $row->manager_id;
		$this->parent_wp_id = $row->parent_wp_id;
		$this->narrative = $row->narrative;
		$this->show_on_etb = $row->show_on_etb;
		$this->get_journal_entries();
	}

	public function insert_to_db($user_info, $code_number, $client_id, $parent_wp_id, $narrative, $show_on_etb, $timestamp) {
		global $wpdb;
		$this->code_number = trim($code_number);
		$this->time = $timestamp;
		$this->client_id = $client_id;
		$this->manager_id = $user_info->get_manager_id();
		$this->parent_wp_id = $parent_wp_id;
		$this->narrative = $narrative;
		$this->show_on_etb = $show_on_etb;
		
		$ret = $wpdb->insert('wp_wpp_journals',
							array(
							  	"code_number" => $this->code_number,
								"time" =>$this->time,
								"client_id" => $this->client_id,
								"manager_id" => $this->manager_id,
								"parent_wp_id" => $this->parent_wp_id,
								"narrative" => $this->narrative,
								"show_on_etb" => $show_on_etb
							  ),
							  array('%d', '%d', '%d', '%d', '%d', '%s', '%d'));
		if ($ret === false) {
			error_log("WP_JOURNAL::insert_to_db - failed inserting wp_wpp_journals, parent wp id=$parent_wp_id");
			return false;
		} else {
			$this->id = $wpdb->insert_id;
		}
		return true;
	}
	
	public function update_to_db($user_info, $narrative, $show_on_etb, $timestamp) {
		global $wpdb;
		$this->time = $timestamp;
		$this->narrative = $narrative;
		$this->show_on_etb = $show_on_etb;
		$ret = $wpdb->update('wp_wpp_journals',
							array(
								"time" =>$this->time,
								"narrative" => $this->narrative,
								"show_on_etb" => $show_on_etb
							  ),
							 array(
							 	"id" => $this->id,
								"manager_id" => $user_info->get_manager_id()
							 ));
		if ($ret === false) {
			error_log("WP_JOURNAL::update_to_db - failed updating wp_wpp_journals, journal id=" . $this->id . ".");
			return false;
		}
		return true;
	}
	
	public function check_permission($user_info, $id) {
        global $wpdb;
		$manager_id = $wpdb->get_var($wpdb->prepare("SELECT manager_id FROM wp_wpp_journals WHERE id=%d", $id));
		if ($manager_id == $user_info->get_manager_id()) {
			return true;
		} else {
			error_log("WP_JOURNAL::check_permission User id, " . $user_info->id . " has no permission to view this journal id, " . $id);
		}
		return false;
	}
	
		
	/* Insert journal entries
	*/
	public function insert_journal_entries($user_info, $rows, $show_on_etb) {
	    global $wpdb;
	    date_default_timezone_set('Europe/London');
		$time = time();
		if ($this->manager_id == $user_info->get_manager_id()) {
			foreach($rows as $row) {
				$ret = $wpdb->insert('wp_wpp_journal_entries',
									array(
										"code" => trim($row->code),
									  	"account" => trim($row->account),
										"price" => $row->price,
										"time" => $time,
										"parent_journal_id" => $this->id,
										"show_on_etb" => $show_on_etb
									  ),
									  array('%s', '%s', '%f', '%d', '%d', '%d'));
				if ($ret === false) {
					error_log("failed inserting wpp_journal_entries, descp=" . trim($row->description));
					return false;
				} else {
					$this->entries = $rows;
				}
			}
		} else {
			error_log("This user, id=" . $user_info->ID . " does not have permission to insert journal entries into Journal ID=" . $this->id . ", manager_id=" . $this->manager_id);
			return false;
		}
		return true;
	}
	
	function get_journal_entries() {
		global $wpdb;
		$results = $wpdb->get_results(
			$wpdb->prepare("SELECT * FROM wp_wpp_journal_entries WHERE parent_journal_id=%d", $this->id));
		if ($results === false) {
			error_log("Failed getting journal entries for journal id " . $this->id);
		} else {
			$this->entries = $results;
			return $this->entries;
		}
		return false;
	}
	
	function delete_journal_entries() {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		if ($current_user->get_manager_id() == $this->manager_id) {
			$ret = $wpdb->delete('wp_wpp_journal_entries',
						array('parent_journal_id' => $this->id));
			if ($ret === false) {
				error_log("Failed getting journal entries for journal id " . $this->id);
			} else {
				$this->entries = array();
				return true;
			}
		} else {
			error_log("This user, id=" . $current_user->ID . " does not have permission to delete journal entries from parent journal id=" . $this->id . ", manager_id=" . $this->manager_id);
		}

		return false;
	}
	
	function get_journal_entry_by_entry_id($entry_id) {
		global $wpdb;
		
		foreach($this->entries as $entry) {
			if ($entry->id == $entry_id) {
				return $entry;
			}
		}
		return false;
	}

	function update_journal_entry_to_db($user_info, $entry) {
		global $wpdb;
	    date_default_timezone_set('Europe/London');
		$entry->time = time();
		$ret = $wpdb->update('wp_wpp_journal_entries',
							array(
								"code" =>$entry->code,
								"account" => $entry->account,
								"price" => $entry->price,
								"time" => $entry->time,
								"show_on_etb" => $entry->show_on_etb
							  ),
							 array(
							 	"id" => $entry->id
							 ));
		if ($ret === false) {
			error_log("WP_JOURNAL::update_journal_entry_to_db - failed updating wp_wpp_journal_entries, journal entry id=" . $entry->id);
			return false;
		}
		return true;
	}
	
	// static function
	public function get_journals_by_workpaper_id($wp_id) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		if (!is_numeric($wp_id)) {
			error_log("WP_JOURNAL::get_jnl_for_workpaper_id - Workpaper id, $wp_id must be a number");
			return array();
		}
		$jnl_data = $wpdb->get_results(
			$wpdb->prepare("SELECT * FROM wp_wpp_journals WHERE parent_wp_id=%d ORDER BY id", $wp_id));
		
		$all_journals = array();
		
		foreach($jnl_data as $row) {
			if ($row->manager_id == $current_user->get_manager_id()) {
				$jnl = new WP_JOURNAL();
				$jnl->populate_fields($row);
				$all_journals[] = $jnl;
			} else {
				// no permission
				error_log("User id, " . $current_user->ID . " has no permission to view this work paper whose parent_wp_id=$wp_id, row->manager_id=" . $row->manager_id);
				return array();
			}
		}
		return $all_journals;		
	}
	
	public function remove_jnl_entries_from_tb_bulk($jnl_entry_ids_str) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		if (preg_match(WP_BULK_ID_REGEX, $jnl_entry_ids_str)) {
			$ret = $wpdb->query(
				$wpdb->prepare("UPDATE wp_wpp_journal_entries ent, wp_wpp_journals jnls " .
				"SET ent.show_on_etb='0' WHERE ent.id in ($jnl_entry_ids_str) " .
				"AND jnls.id=ent.parent_journal_id AND jnls.manager_id=%d",
				$current_user->get_manager_id()));
			if ($ret === false) {
				error_log("WP_JOURNAL::remove_jnl_entries_from_tb_bulk - error setting show_on_etb.");
			}
		} else {
			error_log("WP_JOURNAL::remove_jnl_entries_from_tb_bulk - invalid jnl_entry_ids_str [$jnl_entry_ids_str].");
			$ret = false;
		}
		return $ret;
	}
	
	public function delete_journals_bulk($wpp_jnl_ids_str) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);

		if (preg_match(WP_BULK_ID_REGEX, $wpp_jnl_ids_str)) {
			// delete entries
			$ret = $wpdb->query(
				$wpdb->prepare(
					"DELETE wp_wpp_journal_entries FROM wp_wpp_journal_entries JOIN wp_wpp_journals " .
					"ON wp_wpp_journals.id=wp_wpp_journal_entries.parent_journal_id " .
					"WHERE wp_wpp_journals.id IN ($wpp_jnl_ids_str) AND wp_wpp_journals.manager_id=%d",
					$current_user->get_manager_id()
				)
			);

			if ($ret === false) {
				error_log("WP_JOURNAL::delete_journals_bulk - DB error bulk deleting journal entries for wp journal ids=$wpp_jnl_ids_str");
				return false;
			} else {
				// delete journals
				$ret = $wpdb->query(
					$wpdb->prepare(
						"DELETE FROM wp_wpp_journals WHERE id IN ($wpp_jnl_ids_str) AND manager_id=%d",
						$current_user->get_manager_id()
					)
				);
				if ($ret === false) {
					error_log("WP_JOURNAL::delete_journals_bulk - DB error bulk deleting journals ids=$wpp_jnl_ids_str");
					return false;
				}
				return true;
			}
		} else {
			error_log("WP_JOURNAL::delete_journals_bulk - Error bulk deleting journal entries for wp journal, invalid ids=$wpp_jnl_ids_str.");
			return false;
		}
	}
	
	// static function
	public function get_next_code_number_for_parent_wp_id($parent_wp_id) {
		global $wpdb;
		$new_code_number = $wpdb->get_var(
			$wpdb->prepare("SELECT max(code_number) FROM wp_wpp_journals WHERE parent_wp_id='%d'", $parent_wp_id));
		return ((!isset($new_code_number) || empty($new_code_number)) ? '1' : ($new_code_number+1));
	}
}

class WP_ACC_PREP_NOTES {
	public $id;
	public $code_number;
	public $time;
	public $client_id;
	public $manager_id;
	public $parent_wp_id;
	public $account_subject;
	public $ref;
	public $entries;
	
    public function __construct($id=0) {
        if($id!=0){
            $this->get_acc_prep_notes_by_id($id);
        }else{
            $this->id=0;
            $this->code_number=0;
			$this->time=0;
            $this->client_id=0;
            $this->manager_id=0;
            $this->parent_wp_id=0;
            $this->account_subject='';
            $this->ref='';
			$this->entries = array();
        }
        return $this;
    }

	public function get_acc_prep_notes_by_id($id){
        global $wpdb;
		$this->id=$id;
		$rows = $wpdb->get_results(
			$wpdb->prepare("SELECT * FROM wp_wpp_acc_prep_notes WHERE id=%d ORDER BY id", $id));
		if ($rows !== false) {
			$current_user=new USER_INFO(wp_get_current_user()->ID);
			if ($rows[0]->manager_id == $current_user->get_manager_id()) {
				$this->populate_fields($rows[0]);
			} else {
				error_log("WP_ACC_PREP_NOTES::get_acc_prep_notes_by_id - User id, " . $current_user->id . " has no permission to view these acc prep notes, " . $id);
			}
		} else {
			error_log("WP_ACC_PREP_NOTES::get_acc_prep_notes_by_id failed, id - $id");
		}
        return $this;
    }

	function populate_fields($row) {
		$this->id=$row->id;
		$this->code_number = $row->code_number;
		$this->time=$row->time;
		$this->client_id = $row->client_id;
		$this->manager_id = $row->manager_id;
		$this->parent_wp_id = $row->parent_wp_id;
		$this->account_subject = $row->account_subject;
		$this->ref = $row->ref;
		$this->get_notes_entries();
	}

	public function insert_to_db($user_info, $code_number, $client_id, $parent_wp_id, $account_subject, $ref) {
		global $wpdb;
		$this->code_number = trim($code_number);
		$this->time = time();
		$this->client_id = $client_id;
		$this->manager_id = $user_info->get_manager_id();
		$this->parent_wp_id = $parent_wp_id;
		$this->account_subject = $account_subject;
		$this->ref = $ref;
		
		$ret = $wpdb->insert('wp_wpp_acc_prep_notes',
							array(
							  	"code_number" => $this->code_number,
								"time" =>$this->time,
								"client_id" => $this->client_id,
								"manager_id" => $this->manager_id,
								"parent_wp_id" => $this->parent_wp_id,
								"account_subject" => $this->account_subject,
								"ref" => $this->ref,
								"user_id" => $user_info->ID
							  ),
							  array('%d', '%d', '%d', '%d', '%d', '%s', '%s', '%d'));
		if ($ret === false) {
			error_log("WP_ACC_PREP_NOTES::insert_to_db - failed inserting wp_wpp_acc_prep_notes, parent wp id=$parent_wp_id");
			return false;
		} else {
			$this->id = $wpdb->insert_id;
		}
		return true;
	}
	
	public function update_to_db($user_info, $account_subject, $ref, $time) {
		global $wpdb;
		$this->time = $time;
		$this->account_subject = $account_subject;
		$this->ref = $ref;
		$ret = $wpdb->update('wp_wpp_acc_prep_notes',
							array(
								"time" =>$this->time,
								"account_subject" => $this->account_subject,
								"ref" => $this->ref
							  ),
							 array(
							 	"id" => $this->id,
								"manager_id" => $user_info->get_manager_id()
							 ));
		if ($ret === false) {
			error_log("WP_ACC_PREP_NOTES::update_to_db - failed updating wp_wpp_acc_prep_notes, note id=" . $this->id . ".");
			return false;
		}
		return true;
	}
	
	public function check_permission($user_info, $id) {
        global $wpdb;
		$manager_id = $wpdb->get_var($wpdb->prepare("SELECT manager_id FROM wp_wpp_acc_prep_notes WHERE id=%d", $id));
		if ($manager_id == $user_info->get_manager_id()) {
			return true;
		} else {
			error_log("WP_ACC_PREP_NOTES::check_permission User id, " . $user_info->id . " has no permission to view this acc prep notes id, " . $id);
		}
		return false;
	}
		
	/* Insert notes entries
	*/
	public function insert_note_entries($user_info, $rows) {
	    global $wpdb;
	    date_default_timezone_set('Europe/London');
		$time = time();
		if ($this->manager_id == $user_info->get_manager_id()) {
			foreach($rows as $row) {
				$ret = $wpdb->insert('wp_wpp_note_entries',
									array(
										"parent_notes_id" => $this->id,
										"user_id" => $user_info->id,
									  	"note_text" => trim($row->note_text),
										"time" => time()
									  ),
									  array('%d', '%d', '%s', '%d'));
				if ($ret === false) {
					error_log("failed inserting wp_wpp_note_entries, note_text=" . trim($row->note_text));
					return false;
				} else {
					$this->entries = $rows;
				}
			}
		} else {
			error_log("This user, id=" . $user_info->ID . " does not have permission to insert note entries into Acc Prep Notes ID=" . $this->id . ", manager_id=" . $this->manager_id);
			return false;
		}
		return true;
	}
	
	function get_notes_entries() {
		global $wpdb;
		$results = $wpdb->get_results(
			$wpdb->prepare("SELECT * FROM wp_wpp_note_entries WHERE parent_notes_id=%d order by id", $this->id));
		if ($results === false) {
			error_log("Failed getting notes entries for acc prep notes id " . $this->id);
		} else {
			$this->entries = $results;
			return $this->entries;
		}
		return false;
	}
	
	function delete_notes_entries() {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		if ($current_user->get_manager_id() == $this->manager_id) {
			$ret = $wpdb->delete('wp_wpp_note_entries',
						array('parent_notes_id' => $this->id));
			if ($ret === false) {
				error_log("Failed getting notes entries for acc prep notes  id " . $this->id);
			} else {
				$this->entries = array();
				return true;
			}
		} else {
			error_log("This user, id=" . $current_user->ID . " does not have permission to delete notes entries from parent acc prep notes id=" . $this->id . ", manager_id=" . $this->manager_id);
		}

		return false;
	}

	function delete_notes_entry_by_entry_id($entry_id) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		if ($current_user->get_manager_id() == $this->manager_id) {
			// delete from DB
			$ret = $wpdb->delete('wp_wpp_note_entries',
						array('id' => $entry_id));
			if ($ret === false) {
				error_log("Failed deleting notes entry by entry id " . $entry_id);
			} else {
				// remove from this instance
				for ($i=0; $i < count($this->entries); $i++) {
					if ($entry->id == $entry_id) {
						array_splice($this->entries, $i, 1);
						break;
					}
				}
				return true;
			}
		} else {
			error_log("This user, id=" . $current_user->ID . " does not have permission to delete notes entry with id=" . $entry_id . ", manager_id=" . $this->manager_id);
		}

		return false;
	}
	
	function get_notes_entry_by_entry_id($entry_id) {
		global $wpdb;
		
		foreach($this->entries as $entry) {
			if ($entry->id == $entry_id) {
				return $entry;
			}
		}
		return false;
	}

	function update_notes_entry_to_db($user_info, $entry) {
		global $wpdb;
	    date_default_timezone_set('Europe/London');
		$entry->time = time();
		$ret = $wpdb->update('wp_wpp_note_entries',
							array(								
								"parent_notes_id" => $this->id,
								"user_id" => $row->user_id,
							  	"note_text" => trim($row->note_text),
								"time" => $time
							  ),
							 array(
							 	"id" => $entry->id
							 ));
		if ($ret === false) {
			error_log("WP_ACC_PREP_NOTES::update_notes_entry_to_db - failed updating wp_wpp_note_entries, notes entry id=" . $entry->id);
			return false;
		}
		return true;
	}
	
	// static function
	public function get_acc_prep_notes_by_workpaper_id($wp_id) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		if (!is_numeric($wp_id)) {
			error_log("WP_ACC_PREP_NOTES::get_acc_prep_notes_by_workpaper_id - Workpaper id, $wp_id must be a number");
			return array();
		}
		$acc_prep_notes_data = $wpdb->get_results(
			$wpdb->prepare("SELECT * FROM wp_wpp_acc_prep_notes WHERE parent_wp_id=%d ORDER BY id", $wp_id));
		
		$all_notes = array();
		
		foreach($acc_prep_notes_data as $row) {
			if ($row->manager_id == $current_user->get_manager_id()) {
				$apn = new WP_ACC_PREP_NOTES();
				$apn->populate_fields($row);
				$all_notes[] = $apn;
			} else {
				// no permission
				error_log("User id, " . $current_user->ID . " has no permission to view this work paper whose parent_wp_id=$wp_id, row->manager_id=" . $row->manager_id);
				return array();
			}
		}
		return $all_notes;		
	}
	
	// static	
	public function delete_acc_prep_notes_bulk($wpp_notes_ids_str) {
		global $wpdb;
		$current_user=new USER_INFO(wp_get_current_user()->ID);

		if (preg_match(WP_BULK_ID_REGEX, $wpp_notes_ids_str)) {
			// delete entries
			$ret = $wpdb->query(
				$wpdb->prepare(
					"DELETE wp_wpp_note_entries FROM wp_wpp_note_entries JOIN wp_wpp_acc_prep_notes " .
					"ON wp_wpp_acc_prep_notes.id=wp_wpp_note_entries.parent_notes_id " .
					"WHERE wp_wpp_acc_prep_notes.id IN ($wpp_notes_ids_str) AND wp_wpp_acc_prep_notes.manager_id=%d",
					$current_user->get_manager_id()
				)
			);

			if ($ret === false) {
				error_log("WP_ACC_PREP_NOTES::delete_acc_prep_notes_bulk - DB error bulk deleting acc prep notes entries for wp ids=$wpp_notes_ids_str");
				return false;
			} else {
				// delete acc_prep_notes
				$ret = $wpdb->query(
					$wpdb->prepare(
						"DELETE FROM wp_wpp_acc_prep_notes WHERE id IN ($wpp_notes_ids_str) AND manager_id=%d",
						$current_user->get_manager_id()
					)
				);
				if ($ret === false) {
					error_log("WP_ACC_PREP_NOTES::delete_acc_prep_notes_bulk - DB error bulk deleting acc_prep_notes ids=$wpp_notes_ids_str");
					return false;
				}
				return true;
			}
		} else {
			error_log("WP_ACC_PREP_NOTES::delete_acc_prep_notes_bulk - Error bulk deleting acc_prep_notes entries, invalid ids=$wpp_notes_ids_str.");
			return false;
		}
	}
	
	// static function
	public function get_next_code_number_for_parent_wp_id($parent_wp_id) {
		global $wpdb;
		$new_code_number = $wpdb->get_var(
			$wpdb->prepare("SELECT max(code_number) FROM wp_wpp_acc_prep_notes WHERE parent_wp_id='%d'", $parent_wp_id));
		return ((!isset($new_code_number) || empty($new_code_number)) ? '1' : ($new_code_number+1));
	}
}

class WP_TB_DETAILS
{
	
		public function get_client_details($user_id){
		global $wpdb;
		$sql=$wpdb->prepare("SELECT * FROM wp_client WHERE user_id=%d", $user_id);
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->id=$rows[0]->id;
			$this->user_id=$rows[0]->user_id;
			$this->client_name=$rows[0]->client_name;
			$this->production_system_id=$rows[0]->production_system_id;
            $this->manager_id=$rows[0]->manager_id;
			$this->wp_client_reference=$rows[0]->wp_client_reference;
        }
		return $this;
	}
	
	public function get_workpaper_details_by_id($wp_id) {
		global $wpdb;
		$sql = $wpdb->prepare("SELECT wte.*, wte.id wte_id, wt.*, wc.*
			FROM `wp_wpp_tb_entries` wte, `wp_wpp_tb` wt, `wp_client` wc
			WHERE wte.wp_wpp_tb_id = wt.id AND wt.client_id = wc.id
			AND wte.id =%d", $wp_id);
		$rows=$wpdb->get_results($sql);
		return $rows[0];
	}
	
	public function wp_short_ref_name($acc_type)
	{
		switch ($acc_type) {
	    case -1:
	        return 'N';
	    case 0:
	        return 'F';
	    case 1:
	        return 'F1';
	    case 2:
	        return 'F2';
	    case 3:
	        return 'F3';
	    case 4:
	        return 'B';
	    case 5:
	        return 'S';
	    case 6:
	        return 'D-1';
	    case 7:
	        return 'D-2';
	    case 8:
	        return 'C-1';
	    case 9:
	        return 'C-2';
	    case 10:
	        return 'C-3';
	    case 11:
	        return 'C/R';
	    case 12:
	        return 'R';
	    case 13:
	        return 'E';
	}
	return '';
	}
	
	public function save_wp_plus_data($data)
	{
		global $wpdb;
		$ret = false;
		$insrt_data = array();
		$insrt_data['user_id'] 	  = $data['user_id'];
		$insrt_data['entry_id']   = $data['entry_id'];
		$insrt_data['paper_type'] = $data['paper_type'];
		$insrt_data['added_date'] = date('Y-m-d H:i:s');
		$insrt_data['added_time'] = time();
		
		if($data['paper_type'] == 'F'){
			$insrt_data['paper_name']   = $data['file_name'];
		}else if($data['paper_type'] == 'N'){
			$insrt_data['paper_name']   = $data['title'];
			$insrt_data['notes']   = $data['notes'];
		}else{
			$insrt_data['paper_name']   = $data['link_title'];
            $insrt_data['notes']        = $data['link'];
		}
		if(isset($insrt_data['paper_name']) && $insrt_data['paper_name'] != ""){
			$ret = $wpdb->insert( "wp_import_working_papers", $insrt_data);
		}
		
		if ($ret === false){
			return 0;
		}else{
			return 1;
		}
		
	}
	
	public function get_import_working($entry_id)
	{
		global $wpdb;
		$rows = array();
		$sql=$wpdb->prepare("SELECT * FROM wp_import_working_papers WHERE entry_id=%d", $entry_id);
        $rows=$wpdb->get_results($sql);//print_r($rows);die;
        if(count($rows)>0){
            $rows = $rows;
        }
		return $rows;
	}
    
    public function get_wp_by_papers_id($papers_id)
	{
		global $wpdb;
		$data = array();
		$sql=$wpdb->prepare("SELECT * FROM wp_import_working_papers WHERE papers_id=%d", $papers_id);
        $rows=$wpdb->get_results($sql);//print_r($rows);die;
        if(count($rows)>0){
            $data['papers_id']      = $rows[0]->papers_id;
            $data['user_id']        = $rows[0]->user_id;
            $data['entry_id']       = $rows[0]->entry_id;
            $data['paper_name']     = strtoupper($rows[0]->paper_name);
            $data['original_name']  = $rows[0]->paper_name;
            $data['notes']          = $rows[0]->notes;
            $data['paper_type']     = $rows[0]->paper_type;
            $data['added_date']     = $rows[0]->added_date;
            $data['added_time']     = $rows[0]->added_time;
            $data['date_time']      = date('d/m/Y \a\t H:i:s', strtotime($rows[0]->added_date));
        }
		return $data;
	}
	
	public function delete_working_papers($papers_id)
	{
		global $wpdb;
		$sql=$wpdb->prepare("DELETE FROM wp_import_working_papers WHERE papers_id=%d", $papers_id);
        $rows=$wpdb->get_results($sql);//print_r($rows);die;
        return 1;
	}
	
	public function add_linked_to($data)
	{
		global $wpdb;
		$shorting_id = 1;
		$sql="SELECT linked_id FROM wp_linked_to ORDER BY linked_to DESC LIMIT 1";
        $rows=$wpdb->get_results($sql);
		if(isset($rows) && count($rows) >0){
			$shorting_id = $rows[0]->linked_id;
		}
		
		$data['shorting_id'] = $shorting_id;//print_r($data);die;
		$ret = $wpdb->insert( "wp_linked_to", $data);
		return 1;
	}
	
	public function get_linked_to_by_id($from_id)
	{
		global $wpdb;
		$data = array();
		$sql="SELECT lt.*, wte.description FROM wp_linked_to lt, wp_wpp_tb_entries wte WHERE lt.from_id='".$from_id."' AND lt.to_id = wte.id ORDER BY lt.shorting_id ASC";
        $rows=$wpdb->get_results($sql);
		if(isset($rows) && count($rows) >0){
			$data = $rows;
		}
		
		return $data;
	}
	
	public function get_linked_to_by_from_id($from_id)
	{
		global $wpdb;
		$data = array();
		$sql="SELECT to_id FROM wp_linked_to WHERE from_id='".$from_id."'";
        $rows=$wpdb->get_results($sql);
		if(isset($rows) && count($rows) >0){
			foreach($rows as $key=>$value){
				$data[$key] = $value->to_id;
			}
		}
		
		return $data;
	}
	
	public function delete_linked_to($linked_id)
	{
		global $wpdb;
		$sql=$wpdb->prepare("DELETE FROM wp_linked_to WHERE linked_id=%d", $linked_id);
        $rows=$wpdb->get_results($sql);//print_r($rows);die;
        return 1;
	}

    /* ======= ajax call from sub lead dropdown ======== */
    public function manage_wp_account($acc_array, $code, $tab_id)
    {
        global $wpdb;
        $data   = array();
        $ret    = "";
        foreach ($acc_array as $key=>$acc_id){
            $sql="SELECT * FROM wp_manage_accounts WHERE code = '".$code."' and account_id = '".$acc_id."'";
            $data = $wpdb->get_results($sql);
            if($tab_id == 0){
                $ret = $wpdb->delete( 'wp_manage_accounts', array('manage_id' => $data[0]->manage_id) );
            }else{
                if(empty($data)){
                    $ret = $wpdb->insert( "wp_manage_accounts", array('tab_id' => $tab_id, 'account_id' => $acc_id,'code' => $code,'created' => date('Y-m-d H:i:s')));
                }else{
                    $ret = $wpdb->update('wp_manage_accounts', array('tab_id' => $tab_id), array('manage_id' => $data[0]->manage_id));
                }
            }
        }
        return $ret;
    }
}

?>
