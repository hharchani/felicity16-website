<?php
if (empty($is_ajax)):
    if (isset($events_data)) {
        $categorised_event = [];
        foreach ($events_data as $event) {
            $category = trim( str_replace($event['slug'], '', $event['path']), '/' );
            if ($event['template'] == 'category') {
                if (!isset($categorised_event[$category])) {
                    $categorised_event[$category] = [];
                }
                array_unshift($categorised_event[$category], $event);
            } else {
                $categorised_event[$category][] = $event;
            }
        }
    }
    if (!isset($page_slug)) {
        $page_slug = "static";
    }

    $mobile_nav_link = function ($name, $display_name) use ($page_slug) {
    ?>
        <a href="<?= locale_base_url() . $name ?>/" data-href="<?= $name ?>"  class="primary-nav-link <?= $name ?><?= $name == $page_slug ? ' open' : '' ?>">
            <?= $display_name ?>
        </a>
<?php
};
    $primary_nav_link = function ($name, $display_name, $image) use ($page_slug) {
?>
        <a href="<?= locale_base_url() . $name ?>/" data-href="<?= $name ?>" class="primary-nav-link <?= $name ?><?= $name == $page_slug ? ' open' : '' ?>">
            <div class="title"><?= $display_name ?></div>
            <img src="<?= base_url() ?>static/images/<?= $image ?>">
        </a>
<?php
    }
?>
    </div>
    <nav class="desktop full-visible">
        <?php if (isset($categorised_event)): ?>
        <div class="crystal-ball">
            <img src="<?= base_url() ?>static/images/bb8.png" class="bb8">
                <img src="<?= base_url() ?>static/images/head.png" class="head">
            <div class="ball-title"><a href="<?= locale_base_url()?>events/"><?= __('Events') ?></a></div>
            <ul class="events-nav">
                <?php foreach ($categorised_event as $category => $events): ?>
                    <li>
                        <a class="events-nav-button" href="#" data-href="<?= $category ?>">
                            <i class="<?= $events[0]['data']['icon'] ?>"></i>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="events-nav-cum-tooltip">
            <?php foreach ($categorised_event as $category => $events): ?>
                <div class="nav-cum-tooltip-dummy-target cat-<?= $category ?>">
                    <?php
                        $category_name = "";
                        $events_sub_nav_home = [];
                        $events_sub_nav = [];
                        foreach ($events as $event) {
                            if (substr($event['path'], -6) === 'index/') {
                                $category_name = $event['data']['name'];
                                $events_sub_nav_home = [
                                    'path'=> substr($event['path'], 1, -6),
                                    'name'=> __('Home')
                                ];
                            } else {
                                array_push($events_sub_nav, [
                                    'path'=> substr($event['path'], 1),
                                    'name'=> $event['data']['name']
                                ]);
                            }
                        }
                        usort($events_sub_nav, function($a, $b) {
                            return $a['name'] - $b['name'];
                        });

                        // Localize now
                        foreach ($events_sub_nav as $key => $event) {
                            $events_sub_nav[$key]['name'] = __($event['name']);
                        }

                        // Add `Home` at the begining
                        array_unshift($events_sub_nav, $events_sub_nav_home);
                    ?>
                    <div class="nav-cum-tooltip">
                        <div class="nav-title"><?= __($category_name) ?></div>
                        <ul class="events-sub-nav">
                            <?php foreach ($events_sub_nav as $event): ?>
                                <li><a href="<?= locale_base_url() . $event['path'] ?>"><?= $event['name'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="triangle-back"></div>
                        <div class="triangle-front"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <ul class="primary-nav left">
            <li>
                <?php $primary_nav_link('about', __('About'), 'dragon8.png'); ?>
            </li>
            <li>
                <?php $primary_nav_link('gallery', __('Gallery'), 'dragon2.png'); ?>
            </li>
            <li>
                <?php $primary_nav_link('schedule', __('Schedule'), 'dragon7.png'); ?>
            </li>
        </ul>
        <ul class="primary-nav right">
            <li>
                <?php $primary_nav_link('sponsors', __('Sponsors'), 'dragon5.png'); ?>
            </li>
            <li>
                <?php $primary_nav_link('team', __('Team'), 'dragon3.png'); ?>
            </li>
            <li>
                <?php $primary_nav_link('contact', __('Contact'), 'dragon6.png'); ?>
            </li>
        </ul>
    </nav>
    <nav class="mobile">
        <a href="#" class="mobile-nav-toggle"><i class="icon-menu"></i></a>
        <div class="mobile-menu-container">
            <div class="mobile-menu-header">
                <?php if (isset($is_authenticated)): ?>
                    <div class="mobile-auth-links">
                        <span class="mobile-icon-container"><i class="icon-user"></i></span>
                        <div>
                            <?php if ($is_authenticated): ?>
                                <?php if (!empty($user_nick)): ?>
                                    <div class="nick"><?= sprintf(__('Hello, %s'), $user_nick) ?></div>
                                <?php endif; ?>
                                <div><a href="<?= locale_base_url() . "auth/logout/" ?>" class="pure-button btn"><?= __('Logout') ?></a></div>
                            <?php else: ?>
                                <div class="some-top-margin"><a href="<?= locale_base_url() . "auth/login/" ?>" class="pure-button btn"><?= __('Login / Register') ?></a></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php
                global $cfg;
                $path = empty($_SERVER['PATH_INFO']) ? '/' : $_SERVER['PATH_INFO'];
                $lang_prefix = explode('_', setlocale(LC_ALL, "0"))[0];

                if (strpos($path, $lang_prefix) === 1) {
                    $path = substr($path, strlen($lang_prefix) + 1);
                }
                $lang_list = isset($cfg['i18n']['languages']) ? $cfg['i18n']['languages'] : [];
                if ($lang_list): ?>
                <div class="mobile-lang-links">
                    <div>
                        <span class="mobile-icon-container"><i class="icon-language"></i></span>
                    </div>
                    <div class="some-top-margin">
                    <?php
                    $list_of_links = [];
                    foreach ($lang_list as $lang => $locale) {
                        $href   = base_url() . $lang . $path;
                        $class  = ($lang == $lang_prefix) ? ' active-lang' : '';
                        $text   = locale_get_display_name($lang, $lang);
                        $list_of_links[] = "<a href='$href' lang='$lang' class='lang-link$class'>$text</a>";
                    }
                    echo implode(' · ', $list_of_links);
                    ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="mobile-menu">
                <ul>
                    <li>
                        <a href="<?= locale_base_url() ?>"  class="mobile-home-icon">
                            <i class="icon-home-outline"></i>
                        </a>
                    </li>
                    <li>
                        <?php $mobile_nav_link('events', __('Events')); ?>
                    </li>
                    <li>
                        <?php $mobile_nav_link('about', __('About')); ?>
                    </li>
                    <li>
                        <?php $mobile_nav_link('gallery', __('Gallery')); ?>
                    </li>
                    <li>
                        <?php $mobile_nav_link('schedule', __('Schedule')); ?>
                    </li>
                    <li>
                        <?php $mobile_nav_link('sponsors', __('Sponsors')); ?>
                    </li>
                    <li>
                        <?php $mobile_nav_link('team', __('Team')); ?>
                    </li>
                    <li>
                        <?php $mobile_nav_link('contact', __('Contact')); ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="<?= base_url() ?>static/scripts/common.js" charset="utf-8"></script>
    <script src="<?= base_url() ?>static/scripts/ajaxify.js" charset="utf-8"></script>
    <?php if ($page_slug !== "static"): ?>
    <script src="<?= base_url() ?>static/scripts/navigation.js?v=5" charset="utf-8"></script>
    <?php endif; ?>
    <script src="<?= base_url() ?>static/scripts/mobile_navigation.js" charset="utf-8"></script>
    <?php $this->load_fragment('google_analytics'); ?>
</body>
</html>
<?php endif;
