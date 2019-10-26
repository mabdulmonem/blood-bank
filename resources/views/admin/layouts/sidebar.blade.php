<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ admin_url() }}" class="brand-link">
        <img src="{{ image(settings('logo'),true) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{ settings('site_name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ image(auth()->user()->picture,true) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ admin_url("users/".auth()->id() ."/edit") }}" class="d-block">
                    {{ ($username = auth()->user()->username) ? $username : auth()->user()->name }}
                </a>
            </div>
            <div class="logout">
                <a title="Logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit()"><i class="fas fa-sign-out-alt"></i></a>
                <form id="logout-form" action="{{ route('logout') }}" method="post">
                    @csrf
                </form>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @role('admins')
                <li class="nav-item has-treeview {{ active_class(['governorates','blood-types','cities'],0) }} {{ home_active_class(0) }}">
                    <a href="{{ admin_url('') }}" class="nav-link {{ active_class(['governorates','blood-types','cities'],1) }} {{ home_active_class(1) }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الرئيسية
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ admin_url('') }}" class="nav-link {{ home_active_class(1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>لوحة التحكم</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ admin_url('governorates') }}" class="nav-link {{ active_class('governorates',1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>المحافظات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ admin_url('cities') }}" class="nav-link {{ active_class('cities',1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>المدن</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ admin_url('blood-types') }}" class="nav-link {{ active_class('blood-types',1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>فصائل الدم</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview {{ active_class(['posts','categories'],0) }}">
                    <a href="#" class="nav-link {{active_class(['posts','categories'],1)}}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            المقالات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ admin_url('posts') }}" class="nav-link {{ active_class('posts',1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>كل المقالات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ admin_url('posts/create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>إضافة مقال</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ admin_url('categories') }}" class="nav-link {{ active_class('categories',1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>التصنيفات</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ active_class('clients',0) }}">
                    <a href="#" class="nav-link {{ active_class('clients',1) }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            العملاء
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ admin_url('clients') }}" class="nav-link {{ active_class('clients',1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>كل العملاء</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ active_class(['users','permissions'],0) }}">
                    <a href="#" class="nav-link {{ active_class(['users','permissions'],1) }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>
                            المسئولون
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ admin_url('users') }}" class="nav-link {{ active_class('users',1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> كل المسئولون </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ admin_url('users/create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>إضافة مسئول</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ admin_url('permissions') }}" class="nav-link {{ active_class('permissions',1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>الصلاحيات</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item ">
                    <a href="{{ admin_url('donation-requests') }}" class="nav-link {{ active_class('donation-requests',1) }}">
                        <i class="nav-icon fas fa-heart	"></i>
                        <p>طلبات التبرع</p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{  active_class(['contact-messages','reports'],0) }}">
                    <a href="#" class="nav-link {{ active_class(['reports','contact-messages'],1) }} }}">
                        <i class="nav-icon fas fa-mail-bulk"></i>
                        <p>
                            الرسائل
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ admin_url('contact-messages') }}" class="nav-link {{ active_class('contact-messages',1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>رسائل العملاء</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ admin_url('reports') }}" class="nav-link {{ active_class('reports',1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>الإبلاغات</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ active_class(['settings','setting'],0) }}">
                    <a href="#" class="nav-link {{ active_class(['settings','setting'],1) }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            الأعدادت
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ admin_url('settings') }}" class="nav-link {{ active_class('settings',1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>الاعدادت الرئيسية</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ admin_url('setting/social-media') }}" class="nav-link {{ active_class('setting',1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>اعدادت التواصل الاجتماعى</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                @role('writer')
                <li class="nav-item ">
                    <a href="{{ admin_url('') }}" class="nav-link {{ home_active_class(1) }}">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <p>لوحة التحكم</p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ active_class(['posts','categories'],0) }}">
                    <a href="#" class="nav-link {{active_class(['posts','categories'],1)}}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            المقالات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ admin_url('posts') }}" class="nav-link {{ active_class('posts',1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>كل المقالات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ admin_url('posts/create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>إضافة مقال</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ admin_url('categories') }}" class="nav-link {{ active_class('categories',1) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>التصنيفات</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item ">
                    <a href="{{ admin_url("user/edit") }}" class="nav-link {{ active_class('users',1) }}">
                        <i class="fas fa-user nav-icon"></i>
                        <p>الملف الشخصى</p>
                    </a>
                </li>
                @endrole
            </ul>
        </nav>
        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->
</aside>
