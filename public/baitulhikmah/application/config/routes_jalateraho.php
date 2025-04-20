<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['database'] 						= "Welcome/mysql_backup";


/* Front End*/
$route['contact-us'] 					= "pages/contact_us";
$route['about-us'] 						= "pages/about_us";
$route['admin/static-pages'] 			= "pages/static_pages";
$route['admin/edit-pages/(:num)'] 		= "pages/edit_pages/$1";
$route['static-pages/(:num)'] 			= "pages/font_page/$1";

/* ====== Product ========= */
$route['product/(:any)'] 				= "products/product_list/$1";
$route['admin/delete-product/(:num)'] 	= "products/delete_product/$1";
$route['add-to-wishlist/(:any)'] 		= "products/add_to_wishlist/$1";
$route['my-wishlist'] 					= "products/my_wishlist";

/* ====== ProductDetails ========= */
$route['product-details/(:any)'] 		= "product_details/view_details/$1";
$route['cart'] 							= "product_details/cart";
$route['checkout'] 						= "product_details/checkout";
$route['order-confirm'] 				= "product_details/order_confirm";


/* ====== User ========= */
$route['login'] 						= "user/login";
$route['register'] 						= "user/register";
$route['forgot-password'] 				= "user/forgot_password";
$route['user/reset-password/(:any)'] 	= "user/reset_password/$1";
$route['user/reset-password-action'] 	= "user/reset_password_action";
$route['logout'] 						= "user/logout";
$route['my-account'] 					= "user/my_account";
$route['user/change-password'] 			= "user/change_password";

/* ====== Orders ========= */
$route['my-orders'] 					= "order/my_orders";
$route['admin/order-list'] 				= "order/order_list";
$route['admin/order-details/(:any)']	= "order/order_details/$1";
$route['admin/order-delete/(:any)']		= "order/delete_order/$1";
$route['thank-you'] 					= "order/thank_you";

/* Admin Panel*/
$route['admin'] 						= "admin/index";
$route['dashboard'] 					= "admin/dashboard";
$route['admin/login-process'] 			= "admin/login_process";
$route['admin/register-process'] 		= "admin/register_process";
$route['admin/forgot-pass/(:any)'] 		= "admin/forgot_password/$1";
$route['admin/forgot-process'] 			= "admin/forgot_process";
$route['admin/reset-password'] 			= "admin/reset_password";
$route['admin/my-profile'] 				= "admin/profile";
$route['admin/edit-password'] 			= "admin/edit_password";
$route['admin/user-list'] 				= "admin/user_list";
$route['admin/update-status'] 			= "admin/update_status";

$route['admin/add-product'] 			= "manage_product/add";
$route['admin/bulk-upload-product'] 	= "manage_product/bulk_upload";
$route['admin/bulk-upload-image'] 		= "manage_product/bulk_upload_image";
$route['admin/edit-product/(:any)'] 	= "manage_product/edit/$1";
$route['admin/product-list'] 			= "manage_product/product_list";
$route['admin/delete-more-image/(:any)']= "manage_product/delete_more_image/$1";

$route['admin/add-category'] 			= "category/add";
$route['admin/edit-category/(:any)'] 	= "category/edit/$1";
$route['admin/delete-cat/(:any)']		= "category/delete/$1";
$route['admin/category-list'] 			= "category/category_list";

$route['admin/add-banner'] 				= "home/add_banner";
$route['admin/edit-banner/(:any)'] 		= "home/edit_banner/$1";
$route['admin/action-banner'] 			= "home/action_banner";
$route['admin/delete-banner/(:any)']	= "home/delete_banner/$1";
$route['admin/banner-list'] 			= "home/banner_list";

$route['newsletter/news-list'] 			= "newsletter/news_list";
$route['newsletter/delete/(:any)']		= "newsletter/delete/$1";
$route['newsletter/action'] 			= "newsletter/action";

$route['admin/product-price'] 			= "products/product_price";
$route['admin/delete-price/(:num)']		= "products/delete_price/$1";
$route['admin/edit-price/(:num)']		= "products/edit_price/$1";
$route['admin/add-product-price'] 		= "products/add_product_price";
$route['admin/save-product-price'] 		= "products/save_product_price";

$route['ajax_controller/ajax-action']	= "ajax_controller/ajax_action";

$route['default_controller'] 			= 'home/index';
$route['404_override'] = '';




/* End of file routes.php */
/* Location: ./application/config/routes.php */