<div class="other-verticalSections">
    <!-- ============================-->
    <!-- THEME SETTING-->
    <!-- ============================-->
    <div class="themeSetting z-depth-1" id="themeOptions">
        <a class="btn btn-small toggleThemesetting" href="#">
            <i class="material-icons">settings</i>
        </a>
        <div class="settings">
            <div class="navigationSetting">
                <h2>Navigation Type</h2>
                <div class="navoptions row no-mrpd">
                    <p class="navopt s6 col left">
                        <input class="rb-teal" type="radio" name="theme_nav" id="theme_nav_vertical" data-identfier="theme_nav" data-type="vertical">
                        <label class="theme-setting-sv-label" for="theme_nav_vertical">
                            <img class="theme-svg" src="{{ asset('images/theme-svg/V49_opt3.svg') }}" alt="">
                        </label>
                    </p>
                    <p class="navopt s6 col hide-on-med-and-down right">
                        <input class="rb-teal" type="radio" name="theme_nav" id="theme_nav_horizontal" data-identfier="theme_nav" data-type="horizontal">
                        <label class="theme-setting-sv-label" for="theme_nav_horizontal">
                            <img class="theme-svg" src="{{ asset('images/theme-svg/V48_opt3.svg') }}" alt="">
                        </label>
                    </p>
                </div>

                <h2>Navigation Options</h2>
                <div class="navoptions row no-mrpd">
                    <p class="navopt s6 col left">
                        <input class="rb-teal" type="radio" name="theme_nav_opts" id="navOpts_default" data-identfier="theme_nav_opts" data-type="default">
                        <label class="theme-setting-sv-label" for="navOpts_default">
                            <img class="theme-svg horz-set-svg animated" src="{{ asset('images/theme-svg/HD.svg') }}" alt="">
                            <img class="theme-svg vert-set-svg animated" src="{{ asset('images/theme-svg/V.svg') }}" alt="">
                        </label>
                    </p>
                    <p class="navopt s6 col right">
                        <input class="rb-teal" type="radio" name="theme_nav_opts" id="navOpts_iconized" data-identfier="theme_nav_opts" data-type="iconized">
                        <label class="theme-setting-sv-label" for="navOpts_iconized">
                            <img class="theme-svg horz-set-svg animated" src="{{ asset('images/theme-svg/H.svg') }}" alt="">
                            <img class="theme-svg vert-set-svg animated" src="{{ asset('images/theme-svg/VI.svg') }}" alt="">
                        </label>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================-->
    <!-- RIGHT SIDEBAR NOTIFICATION SECTION-->
    <!-- ============================-->
    <!-- NOTIFICATION-SIDEBAR-->
    <div class="row notification-sidebar fixed animated" id="sb-notification">
        <div class="col s12">
            <ul class="tabs rsb-notifications">
                <li class="tab col s4">
                    <a href="#rsb-shortcuts">
                        <i class="material-icons small">widgets</i>
                    </a>
                </li>
                <li class="tab col s4">
                    <a href="#rsb-notifications">
                        <i class="material-icons small">notifications</i>
                        <span class="badge-count white">10</span>
                    </a>
                </li>
                <li class="tab col s4">
                    <a href="#rsb-tasklist">
                        <i class="material-icons small">playlist_add_check</i>
                        <span class="badge-count teal lighten-2 white-text">14</span>
                    </a>
                </li>
            </ul>
            <div class="col s12" id="rsb-notifications">
                <ul class="notification-list collection" id="psNotificationList">
                    <li class="collection-item notification-item waves-effect waves-set">
                        <!-- REDIRECTION TO User-Profile-->
                        <a class="notify-user" href="#">
                            <img class="circle" src="{{ asset('images/placeholder/300x300g.jpg') }}" alt="">
                        </a>
                        <!-- Redirection to msg/chat-->
                        <a class="notify-content" href="#">
                            <span class="title">Amazon<i class="material-icons notify-type blue-text">add_shopping_cart</i></span>
                            <div class="notify-desc">Envato account subsciption is added to your cart.</div>
                            <span class="notify-time">5 Minutes ago.</span>
                        </a>
                    </li>
                    <li class="collection-item notification-item waves-effect waves-set">
                        <!-- REDIRECTION TO User-Profile-->
                        <a class="notify-user" href="#">
                            <img class="circle" src="{{ asset('images/placeholder/300x300g.jpg') }}" alt="">
                        </a>
                        <!-- Redirection to msg/chat-->
                        <a class="notify-content" href="#">
                            <span class="title">Jack Jordan<i class="material-icons notify-type green-text">attach_money</i></span>
                            <div class="notify-desc">Payment received from John Doe for theme.</div>
                            <span class="notify-time">30 Minutes ago.</span>
                        </a>
                    </li>
                    <li class="collection-item notification-item waves-effect waves-set">
                        <!-- REDIRECTION TO User-Profile-->
                        <a class="notify-user" href="#"> <img class="circle" src="{{ asset('images/placeholder/300x300t.jpg') }}" alt=""></a>
                        <!-- Redirection to msg/chat-->
                        <a class="notify-content" href="#">
                            <span class="title">Jenny Jordan<i class="material-icons notify-type blue-text">poll</i></span>
                            <div class="notify-desc">Esi has polled you.</div><span class="notify-time">35 Minutes ago.</span>
                        </a>
                    </li>
                    <li class="collection-item notification-item waves-effect waves-set">
                        <!-- REDIRECTION TO User-Profile-->
                        <a class="notify-user" href="#">
                            <img class="circle" src="{{ asset('images/placeholder/300x300t.jpg') }}" alt="">
                            <span class="notify-status offline"></span>
                        </a>
                        <!-- Redirection to msg/chat-->
                        <a class="notify-content" href="#">
                            <span class="title">Selena Morris<i class="material-icons notify-type purple-text">share</i></span>
                            <div class="notify-desc">Jeo has shared documents with you.</div>
                            <span class="notify-time">38 Minutes ago.</span>
                        </a>
                    </li>
                    <li class="collection-item notification-item waves-effect waves-set">
                        <!-- REDIRECTION TO User-Profile-->
                        <a class="notify-user" href="#">
                            <img class="circle" src="{{ asset('images/placeholder/300x300g.jpg') }}" alt="">
                        </a>
                        <!-- Redirection to msg/chat-->
                        <a class="notify-content" href="#">
                            <span class="title">Jessica<i class="material-icons notify-type orange-text">notifications</i></span>
                            <div class="notify-desc">Reminder to pay bill.</div>
                            <span class="notify-time">42 Minutes ago.</span>
                        </a>
                    </li>
                    <li class="collection-item notification-item waves-effect waves-set">
                        <!-- REDIRECTION TO User-Profile-->
                        <a class="notify-user" href="#">
                            <img class="circle" src="{{ asset('images/placeholder/300x300g.jpg') }}" alt="">
                        </a>
                        <!-- Redirection to msg/chat-->
                        <a class="notify-content" href="#">
                            <span class="title">Mira Dellon<i class="material-icons notify-type yellow-text">attachment</i></span>
                            <div class="notify-desc">You have received documents from Oghie.</div>
                            <span class="notify-time">49 Minutes ago.</span>
                        </a>
                    </li>
                    <li class="collection-item notification-item waves-effect waves-set">
                        <a class="notify-user" href="#">
                            <img class="circle" src="{{ asset('images/placeholder/300x300t.jpg') }}" alt="">
                        </a>
                        <a class="notify-content" href="#">
                            <span class="title">Evi Willson<i class="material-icons notify-type amber-text">message</i></span>
                            <div class="notify-desc">Review and share Envato new products.</div>
                            <span class="notify-time">53 Minutes ago.</span>
                        </a>
                    </li>
                    <li class="collection-item notification-item waves-effect waves-set">
                        <a class="notify-user" href="#">
                            <img class="circle" src="{{ asset('images/placeholder/300x300g.jpg') }}" alt="">
                        </a>
                        <a class="notify-content" href="#">
                            <span class="title">Anisi Ojior<i class="material-icons notify-type red-text">battery_alert</i></span>
                            <div class="notify-desc">10% battery remains.</div>
                            <span class="notify-time">54 Minutes ago.</span>
                        </a>
                    </li>
                </ul>
                <div class="footer"><a class="center tooltipped" href="#" data-position="top" data-tooltip="See all notifications"><i class="material-icons small">more_horiz</i></a></div>
            </div>
            <div class="col s12" id="rsb-tasklist">
                <div class="tab-notelist" id="psTabNotelist">
                <p>
                    <input type="checkbox" id="task1">
                    <label for="task1">Bring some milk</label>
                </p>
                <p>
                    <input type="checkbox" id="task2">
                    <label for="task2">Promote envato</label>
                </p>
                <p>
                    <input type="checkbox" id="task3">
                    <label for="task3">Make WP theme and submit for review</label>
                </p>
                <p>
                    <input type="checkbox" id="task4">
                    <label for="task4">Read atricle of Jeffrey. He has published a lots of tutorials for VueJS and Laravel 5.2. I want to learn unit-testing.</label>
                </p>
                </div>
                <div class="notes-footer">
                    <a class="tooltipped left waves-effect waves-set" href="#" data-position="top" data-tooltip="Clear selected">
                        <i class="material-icons small">delete</i>
                    </a>
                    <a class="tooltipped right waves-effect waves-set" href="#" data-position="top" data-tooltip="Add new task">
                        <i class="material-icons small">add</i>
                    </a>
                </div>
            </div>
            <div class="col s12" id="rsb-shortcuts">
                <ul class="tab-shortcut collection" id="psTabShortcut">
                <li class="collection-item waves-effect waves-set"><a class="shortcut-aItem" href="#"><i class="material-icons blue-text">photo_library</i><span class="shortcut-name">Gallary</span></a></li>
                <li class="collection-item waves-effect waves-set"><a class="shortcut-aItem" href="#"><i class="material-icons orange-text">mail</i><span class="shortcut-name">Mail</span></a></li>
                <li class="collection-item waves-effect waves-set"><a class="shortcut-aItem" href="#"><i class="material-icons yellow-text">file_download</i><span class="shortcut-name">Downloads</span></a></li>
                <li class="collection-item waves-effect waves-set"><a class="shortcut-aItem" href="#"><i class="material-icons green-text">event</i><span class="shortcut-name">Events</span></a></li>
                <li class="collection-item waves-effect waves-set"><a class="shortcut-aItem" href="#"><i class="material-icons purple-text">contacts</i><span class="shortcut-name">Contacts</span></a></li>
                <li class="collection-item waves-effect waves-set"><a class="shortcut-aItem" href="#"><i class="material-icons cyan-text">settings</i><span class="shortcut-name">Settings</span></a></li>
                <li class="collection-item waves-effect waves-set"><a class="shortcut-aItem" href="#"><i class="material-icons amber-text">lock</i><span class="shortcut-name">Lock Screen</span></a></li>
                <li class="collection-item waves-effect waves-set"><a class="shortcut-aItem" href="#"><i class="material-icons red-text">power_settings_new</i><span class="shortcut-name">Logout</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
