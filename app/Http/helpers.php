<?php

use App\Http\Models\BloodTypeClient;
use App\Http\Models\ClientGovernorate;
use App\Http\Models\Setting;
use App\Http\Models\Token;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Nexmo\Laravel\Facade\Nexmo;
use Yajra\DataTables\Html\Builder;

if ( !function_exists("json") ){

    /**
     * print data in json format
     *
     * @param mixed $data
     * @param null $status
     * @param null $msg
     * @param null $headers
     * @return JsonResponse
     */
    function json($data, $status = null,$msg = null,$headers = null){
        return ( $status >= 0 or $msg )
            ? response()->json(['data' => $data, 'msg' => $msg , 'status' => $status  ])
            : response()->json(['data' => $data]);
    }
};

if (! function_exists("nexmo")){

    /**
     * Send SMS Messages By Nexmo Provider
     *
     * @param $to
     * @param $message
     * @param string $from
     * @return mixed
     */
    function nexmo($to,$message,$from = 'بنك الدم'){
        $nexmo = Nexmo::message()->send([
            'to' => 2 . $to,
            'from' => 'بنك الدم',
            'text' => $message,
            'type' => 'unicode'
        ]);
        return $nexmo->getResponseData()['messages'][0];
    }
}

if (! function_exists("send_notification")){

    /**
     * Send Notification With [firebase server]
     *
     * @param null $to
     * @param null $title
     * @param string $body
     * @param bool $multi_receivers
     * @return bool|string
     */
    function send_notification($to = null,$title = null ,$body = 'new Notification',$multi_receivers = false){
        $receivers = $multi_receivers ? 'registration_ids' : 'to';
        $fcmNotification = [
            $receivers     => $to,
            'notification' => [
                'title'    => $title,
                'sound'    => "default",
                'message'  => $body,
                'color' => "#203E78"
            ],
            'priority' => 'high',
            'data' => [
                'title' => $title,
                'sound' => true,
                'message' => $body,
                'action' => true,
                'color'=>''
            ]
        ];



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: key='. env('FIREBASE_API_ACCESS_KEY'),
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return (filter_var(explode(':',$result)[2],FILTER_SANITIZE_NUMBER_INT) == 1)
            ? true
            : false;
    }
}

if (!function_exists('admin_url')){

    /**
     * get admin [urls]
     *
     * @param string $url
     * @return UrlGenerator|string
     */
    function admin_url($url = '/'){
        return url('ma-admin/' . trim($url,'/'));
    }
}

if (!function_exists('settings')){

    /**
     * get site [Settings]
     *
     * @param $property
     * @param bool $action
     * @param array $data
     * @return mixed
     */
    function settings($property = null, $action = false,$data = []){
        $settings = Setting::orderBy('id','DESC')->first();
        if ($action)
            return $settings
                ? $settings->update($data)
                : Setting::create($data);
        return $settings ? Setting::orderBy('id','DESC')->first()->$property : false;
    }
}

if (! function_exists('active_class')){

    /**
     * Add [Open Menu] Classes And [Active] Classes To links
     *
     * @param $page
     * @param $class
     * @param $option
     */
    function active_class($page,$class,$option = null){
        if (is_array($page)){
            foreach ($page as  $link){
                simple_active_class($link,$class,$option);
            }
        }
        simple_active_class($page,$class,$option);
    }
}
if (! function_exists('simple_active_class')) {

    /**
     * Continue Active Class Function
     *
     * @param $link
     * @param $class
     * @param $option
     */
    function simple_active_class($link,$class,$option = null){
       if ($link !== '/'){
           if($link === request()->segment(2)){
               echo  (request()->segment(3) && $option === request()->segment(3))
                   ? 'active'
                   : ['menu-open','active'][$class];
           }
           echo ['',''][$class];
       }
    }
}
if (! function_exists('home_active_class')){

    /**
     * Get ['Active'] and ['menu-open'] class for home menu
     *
     * @param $class
     * @return mixed
     */
    function home_active_class($class){
        return (request()->segment(1) == 'ma-admin' && request()->segment(2) === null)
            ? ['menu-open','active'][$class]
            : ['',''][$class];
    }
}

if (! function_exists('list_options')){

    /**
     * List Select Options
     * Remove old index from options
     *
     * @param array $options
     * @param null $old_option
     * @param bool $key
     */
    function list_options($options = [],$old_option = null,$key = false){
        if ($options['default'])
            echo "<option>" . $options['default'] . "</option>";
        unset($options['default']);

        if (in_array($old_option,$options)){
            unset($options[$old_option]);
            echo "<option value='$old_option' selected>$old_option</option>";
            foreach ($options as $key => $value)
                echo $key?  "<option value='$key'>$value</option>" :  "<option value='$value'>$value</option>";
        }
        foreach ($options as $key => $value)
            echo $key?  "<option value='$key'>$value</option>" :  "<option value='$value'>$value</option>";
    }
}

if (! function_exists("get_img")){

    /**
     * Get Img Link
     *
     * @param $img_name
     * @return string
     */
    function get_img($img_name){
        return "$img_name";
    }
}
if (! function_exists('data_tables_settings')){

    /**
     * This Is Html Yajra Method
     *
     * @param $table_class
     * @param $columns
     * @param $table_id
     * @return Builder
     */
    function data_tables_settings($table_class,$columns,$table_id){
        return $table_class->builder()
            ->setTableId($table_id)
            ->columns($columns)
            ->minifiedAjax()
            ->orderBy(1)
            ->lengthMenu([[10,25,50,100,-1],[10,25,50,100,'كل السجلات']]);
    }

}
if (! function_exists('calc')){
    /**
     * Calc
     *
     * @param $num
     * @param null $num2
     * @param null $operator
     * @return mixed
     */
    function calc($num,$num2 = null,$operator = null){
        if (!$num2 & !$operator)
            return $num;
        return false;
    }
}

if (! function_exists('image')){

    /**
     * Store Images Or Files to Server
     * get Save [Image] or [file] by file name
     * get old [image] when update
     *
     *
     * @param $name
     * @param bool $get_img
     * @param null $update
     * @param string $folder_name
     * @return mixed
     */
    function image($name,$get_img = false,$update = null,$folder_name = 'images'){
        if (!request()->hasFile($name) && $update)
            return $update;
        if (request()->hasFile($name) && !$get_img){
            request()->validate([
                $name => 'image|mimes:jpeg,png,jpg,gif|max:6000'
            ]);
            return request()->file($name)->store($folder_name,'public');
        }
        return $get_img
            ? asset('storage/' . $name)
            : asset('admin/img/avatar.png');
    }
}
if (! function_exists('is_email')){

    /**
     * Check if The input in valid Email
     *
     * @param $data
     * @return mixed
     */
    function is_email($data){
        return filter_var($data,FILTER_VALIDATE_EMAIL);
    }
}

if (! function_exists('get_login_column')){

    /**
     * get Login Column to auth
     * @return string
     */
    function get_login_column(){
        if (is_email(request('email')))
            return 'email';
        elseif (is_numeric(request('email')))
            return 'phone';
        else
            return 'username';
    }
}

if (! function_exists('controllers_trans')){

    /**
     * Get Controller Arabic Name
     *
     * @param $key
     * @return mixed
     */
    function controllers_trans($key){
        $trans = [
            '/' => 'لوحة التحكم',
            'posts'=> 'المقالات',
            'donation-requests'=> 'طالبات التبرع',
            'reports'=> 'الاإبلاغات',
            'contact-messages'=> 'رسائل التواصل',
            'settings'=> 'الإعدادت',
            'social-media'=> 'إعدادت وسائل التواضل الاجتماعى',
            'users'=> 'المشرفين',
            'user'=> 'المشرف',
            'clients'=> 'العملاء',
            'governorates'=> 'المحافظات',
            'cities'=> 'المدن',
            'blood-types'=> 'فصائل الدم',
            'categories'=> 'التصنيفات',
            'permissions' => 'ادوار المشرفين',
            'permission' => 'الصلاحيات'
        ];
        return array_key_exists($key,$trans)
            ? $trans[$key]
            : null;
    }
}

if (! function_exists('get_breadcrumb')){

    /**
     * Get [Breadcrumb]
     *
     * @param int $key
     * @param int $second
     * @param null $title
     * @return string
     */
    function get_breadcrumb($key = 2,$second = 3,$title = null){
        if (request()->segment($key))
            echo  '<li class="breadcrumb-item active"><a href="' . admin_url('/') . '">' .  controllers_trans('/') . ' </a></li>';
        if (request()->segment($second)){
            $html = '<li class="breadcrumb-item"><a href="' . admin_url(request()->segment($key)) . '"> ' .  controllers_trans(request()->segment($key)) . '</a></li>';
            return $html .=  "<li class='breadcrumb-item active'>$title</li>";
        }
        return  '<li class="breadcrumb-item active">' .  controllers_trans((request()->segment($key) ? request()->segment($key) : '/')) . '</li>';
    };
}

if (! function_exists('get_frontend_breadcrumb')){

    /**
     * Get frontend [Breadcrumb]
     *
     * @param int $key
     * @param null $title
     * @return string
     */
    function get_frontend_breadcrumb($title = null,$key = 1){

        if (request()->segment($key)) {
            $html ='<!-- Navigator Start -->';
            $html .= '<section id="navigator">';
                $html .= '<div class="container">';
                    $html .= '<div class="path">';
                        $html .= '<div class="path-main" style="color: darkred; display:inline-block;"><a href="' . url('/') . '">Home</a> </div>';
                        $html .= \request()->segment($key + 1)
                            ? '<div class="path-directio" style="color: grey; display:inline-block;"> / <a href="' . url(request()->segment($key)) . 's">'  .  ucfirst(str_replace('-',' ', request()->segment($key))) . '</a></div>'
                            : '<div class="path-directio" style="color: grey; display:inline-block;"> / ' . ucfirst(str_replace('-',' ', request()->segment($key))) . '</a></div>';
                        $html .= request()->segment(2) ? '<div class="path-directio" style="color: grey; display:inline-block;"> / ' . $title . '</div>' : null;
                    $html .= '</div>';

                    $html .= '</div>';
            $html .= '</section>';
            $html .= '<!-- Navigator End -->';

            echo $html;
        }
    };
}
if (! function_exists('get_menu_class_active')){

    /**
     * set Active class When Page Is Opened
     *
     * @param $page
     * @param int $key
     * @return string
     */
    function get_menu_class_active($page = null,$key = 1){
        return $page === request()->segment($key)
            ? 'selected'
            : null;
    }
}

if (! function_exists('get_home_menu_class_active')){

    /**
     * set Active class When Page Is Opened
     *
     * @param int $key
     * @return string
     */
    function get_home_menu_class_active($key = 1){
        return !request()->segment($key)
            ? 'selected'
            : null;
    }
}

if (! function_exists('client')){

    /**
     * Get Client Auth Guard
     *
     * @return mixed
     */
    function client(){
        return auth()->guard('clients');
    }
}

if (! function_exists('get_part_of_site_name')){
    /**
     * Get Part Of Site Name
     * @param $name_part
     * @return array
     */
    function get_part_of_site_name($name_part){
        $name = explode(" ", settings('site_name'));
        return  array_key_exists($name_part,$name) ? $name[$name_part] : null;
    }
}

if (! function_exists('get_notification_receivers')){

    /**
     * Get Client [Token]
     *
     * @param $blood_type_id
     * @param $governorate_id
     * @return array
     */
    function get_notification_receivers($blood_type_id, $governorate_id){
        $blood_type_token = Token::whereIn('client_id',BloodTypeClient::where('blood_type_id',$blood_type_id)->pluck('client_id')->toArray())->pluck('token')->toArray();
        $governorate_token = Token::whereIn('client_id',ClientGovernorate::where('governorate_id',$governorate_id)->pluck('client_id')->toArray())->pluck('token')->toArray();

        return array_unique(array_merge($blood_type_token,$governorate_token));
    }
}

if (! function_exists('get_role_name')){

    /**
     * get User Role Name
     * @param $user
     * @return mixed
     */
    function get_role_name($user){
        return str_replace(['[','"','"',']'],'',$user->getRoleNames());
    }
}

if (! function_exists('client_lang')){
    /**
     * Get Client Language
     *
     * @param null $lang_check
     * @param bool $set_session
     * @return string
     */
    function client_lang($lang_check = null,$set_session = false){
        if ($lang_check)
            return (client()->check() && $lang = client()->user()->lang)
                ? ($lang == $lang_check) ? true: false : false;
        if ($set_session)
            return  session()->has('lang') ? session('lang') : 'en';
        return (client()->check() && $lang = client()->user()->lang) ? $lang : 'en';
    }
}
