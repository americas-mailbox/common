<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class ImportStartingDatabase extends AbstractMigration
{
    public function up()
    {
        $this->activityLog();
        $this->addresses();
        $this->administrators();
        $this->banner();
        $this->events();
        $this->media();
        $this->members();
        $this->membersForgot();
        $this->news();
        $this->pages();
        $this->ratesAndPlans();
        $this->settings();
        $this->vehicles();

        $this->setPlanData();

        return;
    }

    private function activityLog()
    {

        $table = $this->table('activity_log');
        $table
            ->addColumn('boxnum', 'char', ['default' => true])
            ->addColumn('browser', 'char')
            ->addColumn('cookie', 'text')
            ->addColumn('ip', 'char')
            ->addColumn('is_admin', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0])
            ->addColumn('level', 'char', ['default' => 'info'])
            ->addColumn('loggedin_userid', 'integer', ['default' => 0])
            ->addColumn('loggedin_username', 'char')
            ->addColumn('loggedin_userdesc', 'char')
            ->addColumn('message', 'text')
            ->addColumn('officeid', 'char')
            ->addColumn('os', 'char')
            ->addColumn('session_id', 'char', ['default' => '0'])
            ->addColumn('timestamp', 'timestamp')
            ->addColumn('userdesc', 'char')
            ->addColumn('userid', 'integer', ['default' => 0])
            ->addColumn('username', 'char')
            ->create();
    }

    private function addresses()
    {
        $table = $this->table('addresses');
        $table
            ->addColumn('addressee', 'char')
            ->addColumn('street_1', 'char')
            ->addColumn('street_2', 'char')
            ->addColumn('street_3', 'char')
            ->addColumn('city', 'char')
            ->addColumn('state', 'char')
            ->addColumn('country', 'char')
            ->addColumn('post_code', 'char')
            ->addColumn('user_id', 'integer')
            ->addColumn('verified', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0])
            ->create();
    }

    private function administrators()
    {
        $table = $this->table('administrators');
        $table
            ->addColumn('email', 'char', ['limit' => 50])
            ->addColumn('password', 'char', ['limit' => 255])
            ->addColumn('first_name', 'char', ['limit' => 50])
            ->addColumn('last_name', 'char', ['limit' => 50])
            ->addColumn('photo', 'char', ['limit' => 30, 'null' => true])
            ->addColumn('phone', 'char', ['limit' => 30])
            ->addColumn('lastlogin_ip', 'char', ['limit' => 20, 'null' => true])
            ->addColumn('lastlogin_date', 'datetime', ['null' => true])
            ->addColumn('role', 'char', ['limit' => 255])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => true, 'signed' => false])
            ->addColumn('username', 'char', ['limit' => 30])
            ->addTimestamps()
            ->create();
    }

    private function banner()
    {
        $table = $this->table('banners');
        $table
            ->addColumn('caption', 'char')
            ->addColumn('image', 'char', ['limit' => 64])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false])
            ->addColumn('title', 'char', ['limit' => 128])
            ->addColumn('view_order', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'signed' => false])
            ->addTimestamps()
            ->create();
    }

    private function events()
    {
        $table = $this->table('events');
        $table
            ->addColumn('events_title', 'char')
            ->addColumn('description', 'text')
            ->addColumn('events_date', 'date')
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false])
            ->addColumn('view_order', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'signed' => false])
            ->addTimestamps()
            ->create();
    }

    private function media()
    {
        $table = $this->table('media');
        $table
            ->addColumn('type_id', 'integer')
            ->addColumn('title', 'char')
            ->addColumn('images', 'char', ['limit' => 64])
            ->addColumn('type', 'char', ['limit' => 28])
            ->addColumn('show_home', 'integer')
            ->addTimestamps()
            ->create();
    }

    private function members()
    {
        $table = $this->table('members', ['id' => false, 'primary_key' => ['member_id']]);
        $table
            ->addColumn('member_id', 'integer')
            ->addColumn('account_id', 'integer')
            ->addColumn('active', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => true, 'signed' => false])
            ->addColumn('alt_email', 'char', ['limit' => 255])
            ->addColumn('alt_phone', 'char', ['limit' => 60])
            ->addColumn('comment', 'text')
            ->addColumn('email', 'char', ['limit' => 255])
            ->addColumn('fax', 'char', ['limit' => 32])
            ->addColumn('level_id', 'integer', ['null' => true,])
            ->addColumn('first_name', 'char', ['limit' => 128])
            ->addColumn('middle_name', 'char', ['limit' => 128])
            ->addColumn('last_name', 'char', ['limit' => 128])
            ->addColumn('suffix', 'char', ['limit' => 128])
            ->addColumn('lastlogin', 'datetime', ['null' => true])
            ->addColumn('lastlogout', 'datetime', ['null' => true])
            ->addColumn('lastactivity', 'datetime', ['null' => true])
            ->addColumn('lastlogin_ip', 'char', ['limit' => 20, 'null' => true])
            ->addColumn('lastlogin_date', 'datetime', ['null' => true])
            ->addColumn('last_mm_sync', 'datetime', ['null' => true])
            ->addColumn('lead', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0, 'signed' => false])
            ->addColumn('lowBalanceDateNotified', 'date', ['null' => true])
            ->addColumn('lowBalanceNumNotifications', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => true, 'signed' => false])
            ->addColumn('mmpassword', 'text')
            ->addColumn('officeid', 'char', ['limit' => 10])
            ->addColumn('othernames', 'char', ['limit' => 255, 'null' => true,])
            ->addColumn('password', 'char', ['limit' => 255])
            ->addColumn('paymentperiod', 'char', ['limit' => 1])
            ->addColumn('phone', 'char', ['limit' => 60])
            ->addColumn('photo', 'char', ['limit' => 30, 'null' => true])
            ->addColumn('pmb', 'char', ['limit' => 255, 'null' => true])
            ->addColumn('renewDate', 'date', ['null' => true])
            ->addColumn('shipinst', 'text')
            ->addColumn('show_balance_on_label', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => true, 'signed' => false])
            ->addColumn('startDate', 'date', ['null' => true])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => true, 'signed' => false])
            ->addColumn('suspended', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => true, 'signed' => false])
            ->addColumn('suspendedmessage', 'text', ['null' => true])
            ->addColumn('username', 'char', ['limit' => 128, 'null' => true])
            ->addTimestamps()
            ->create();
    }

    private function membersForgot()
    {
        $table = $this->table('members_forgot');
        $table
            ->addColumn('code', 'char', ['limit' => 64])
            ->addColumn('user_id', 'integer')
            ->addTimestamps()
            ->create();
    }

    private function news()
    {
        $table = $this->table('news');
        $table
            ->addColumn('description', 'text')
            ->addColumn('news_date', 'date')
            ->addColumn('news_title', 'char')
            ->addColumn('news_video', 'char')
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => true, 'signed' => false])
            ->addColumn('video_caption', 'char')
            ->addColumn('view_order', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'signed' => false])
            ->addColumn('youtube_url', 'char')
            ->addTimestamps()
            ->create();
    }

    private function pages()
    {
        $table = $this->table('pages');
        $table
            ->addColumn('parent_id', 'integer', ['default' => 0])
            ->addColumn('page_title', 'char', ['limit' => 128])
            ->addColumn('page_content', 'text')
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => true, 'signed' => false])
            ->addColumn('view_order', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'signed' => false])
            ->addTimestamps()
            ->create();
    }

    private function ratesAndPlans()
    {
        $table = $this->table('rates_and_plans');
        $table
            ->addColumn('first_line', 'char')
            ->addColumn('second_line', 'char')
            ->addColumn('third_line', 'char')
            ->addColumn('forth_line', 'char')
            ->addColumn('fifth_line', 'char')
            ->addColumn('description', 'text')
            ->addColumn('life_time_price', 'text')
            ->addColumn('parent_id', 'integer', ['default' => 0])
            ->addColumn('price', 'text')
            ->addColumn('price_type', 'char')
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 1])
            ->addColumn('title', 'char')
            ->addColumn('tax', 'text')
            ->addTimestamps()
            ->create();
    }

    private function settings()
    {
        $table = $this->table('settings', ['id' => false, 'primary_key' => ['name']]);
        $table
            ->addColumn('name', 'char')
            ->addColumn('value', 'text')
            ->create();
    }

    private function setPlanData()
    {
        $data = [
            [
                    'id'                => 1,
                    'first_line'        => 'Receive up to 7 pieces of mail per year',
                    'second_line'       => 'Use for vehicle registration / home base',
                    'third_line'        => 'Limited or no address changes',
                    'forth_line'        => '$50 - $100 suggested postage fund',
                    'fifth_line'        => 'Annual Plan only',
                    'description'       => '<p class="column1-unit">The Bronze Plan includes all these benefits:</p>
<div class="column1-unit">
<ul>
<li>We\'ll ship your mail AND Meds where you want, anywhere in the world, by US Postal Service or FedEx.</li>
<li><em><strong>Looking for something important? </strong></em>We\'re the only company of this type letting YOU know right away (the very same day) when you receive Certified or Registered mail.</li>
<li><em><strong>Looking for something important? </strong></em>Just e-mail us and we\'ll check for you at the end of the day when all the mail has been put up</li>
<li>We\'ll also ship your mail anywhere, however and as often as you wish!</li>
<li>We don\'t only receive your mail, we\'ll also accept packages from USPS, UPS or FedEx.</li>
<li>You have complete control over the schedule of your shipments.</li>
<li>Access your account online 24/7/365 with your personal login. Don\'t have Internet access? That\'s okay, we have real people answering the phones during business hours.</li>
<li>If a mistake is made by our staff when sending your package of mail anywhere in the 48 states, we\'ll reimburse the USPS postage it cost to get it to you. Nobody else that we know of does this! (Some common-sense restrictions apply.)</li>
<li>We email you when your mail is sent. If it\'s sent Priority Mail, we obtain a Delivery Confirmation from the USPS <em>(at no additional charge)</em> and send an email so you know when to pick it up.</li>
<li>We\'ll <a href="/tips_and_tricks/27/SD-Vehicle-Registration">register and renew your vehicle</a>. Follow this link to see the costs involved.</li>
</ul>
</div>
<ul>
<li>
<div>Your Americas-Mailbox address gives you legal residence in South Dakota should you want it.</div>
</li>
<li>
<div>You get one additional month of membership free for every new Americas-Mailbox member you refer, or a $25 restaurant gift certificate good at about 20,000 restaurants around the country.&nbsp;</div>
</li>
<li>
<div>Let us know when you\'ll be in the Rapid City area and make a reservation at our own campground or guest rooms.</div>
</li>
</ul>',
                    'price'             => '{"amount": 14999, "currency": "USD"}',
                    'status'            => 1,
                    'title'             => 'Bronze',
                    'created_at'        => '2017-03-16 06:04:56',
                    'updated_at'        => null,
                    'parent_id'         => 0,
                    'life_time_price'   => '',
                    'price_type'        => '',
                    'tax'               => '',
            ],
            [
                'id'                => 2,
                'first_line'        => 'All mail received is forwarded (incl all Junk Mail)',
                'second_line'       => 'Only occasional packages or special handling',
                'third_line'        => '24/7/365 secure encrypted online account access',
                'forth_line'        => '$100 - $150 suggested postage fund',
                'fifth_line'        => 'Qtly vacation plan $15.99/Month - 3 Month min',
                'description'       => '<p>The Silver Plan includes all these benefits:</p>
<ul>
<li>We\'ll ship your mail AND Meds where you want, anywhere in the world, by US Postal Service or FedEx.</li>
<li><em><strong>Looking for something important? </strong></em>We\'re the only company of this type letting YOU know right away (the very same day) when you receive Certified or Registered mail.</li>
<li><em><strong>Looking for something important? </strong></em>Just e-mail us and we\'ll check for you at the end of the day when all the mail has been put up.</li>
<li>We\'ll also ship your mail anywhere, however, and as often as you wish!</li>
<li>We don\'t only receive your mail, we\'ll also accept packages from USPS, UPS or FedEx.</li>
<li>You have complete control over the schedule of your shipments. Need your mail sent to Maine every second Friday but a one-time FedEx to Florida on Tuesday? No problem.</li>
<li>Access your account online 24/7/365 with your personal login. Don\'t have Internet access? That\'s okay, we have real people answering the phones during business hours.</li>
<li>If a mistake is made by our staff when sending your package of mail anywhere in the 48 states, we\'ll reimburse the USPS postage it cost to get it to you. Nobody else that we know of does this! (Some common-sense restrictions apply.)</li>
<li>We email you when your mail is sent. If it\'s sent Priority Mail, we\'ll even obtain a Delivery Confirmation from the USPS <em>(at no additional charge)</em> and send an email so you know when to pick it up.</li>
<li>We\'ll <a href="/tips_and_tricks/27/SD-Vehicle-Registration">register and renew your vehicle</a>. Follow this link to see the costs involved.</li>
<li>Your Americas-Mailbox address gives you legal residence in South Dakota should you want it.</li>
<li>You get one additional month of membership free for every new Americas-Mailbox member you refer, or a $25 restaurant gift certificate good at about 20,000 restaurants around the country.</li>
<li>If you\'re an annual customer and you stop by our office, we\'ll buy you lunch!</li>
<li>Let us know when you\'ll be in the Rapid City area and make a reservation at our own campground or guest rooms.&nbsp;</li>
</ul>',
                'price'             => '{"amount": 16999, "currency": "USD"}',
                'status'            => 1,
                'title'             => 'Silver',
                'created_at'        => '2017-03-15 10:24:08',
                'updated_at'        => null,
                'parent_id'         => 0,
                'life_time_price'   => '',
                'price_type'        => '',
                'tax'               => '',
            ],
            [
                'id'                => 3,
                'first_line'        => 'Junk mail removed pre-forwarding via USPS/FedEx',
                'second_line'       => 'Med volume of mail/PKGS, some special handling.',
                'third_line'        => '24/7/365 secure, encrypted online account access',
                'forth_line'        => '$100 - $200 suggested postage fund',
                'fifth_line'        => 'Qtly vacation plan $18.99/Month - 3 Month min',
                'description'       => '<p>The Gold Plan includes all these benefits:</p>
<ul>
<li>We\'ll ship your mail AND Meds where you want, anywhere in the world, by US Postal Service or FedEx.</li>
<li><em><strong>Looking for something important? </strong></em>We\'re the only company of this type letting YOU know right away (the very same day) when you receive Certified or Registered mail.</li>
<li><em><strong>Looking for something important? </strong></em>Just e-mail us and we\'ll check for you at the end of the day when all the mail has been put up.</li>
<li>We don\'t only receive your mail, we\'ll also accept packages from USPS, UPS or FedEx.</li>
<li>You have complete control over the schedule of your shipments. Need your mail sent to Maine every second Friday but a one-time FedEx to Florida on Tuesday? No problem.</li>
<li>Access your account online 24/7/365 with your personal login. Don\'t have Internet access? That\'s okay, we have real people answering the phones during business hours.</li>
<li>If a mistake is made by our staff when sending your package of mail anywhere in the 48 states, we\'ll reimburse the USPS postage it cost to get it to you. Nobody else that we know of does this! (Some common-sense restrictions apply.)</li>
<li>We email you when your mail is sent. If it\'s sent Priority Mail, we obtain a Delivery Confirmation from the USPS <em>(at no additional charge)</em> and send an email so you know when to pick it up.</li>
<li>For Gold and Platinum plans we will sort your mail, removing junk mail, non-subscription magazines.</li>
<li>We\'ll <a href="/tips_and_tricks/27/SD-Vehicle-Registration">register and renew your vehicle</a>. Follow this link to see the costs involved.</li>
<li>Your Americas-Mailbox address gives you legal residence in South Dakota should you want it.</li>
<li>You get one additional month of membership free for every new Americas-Mailbox member you refer, or a $25 restuarant gift certificate good at about 20,000 restaurants around the country.</li>
<li>If you\'re an annual customer and you stop by our office, we\'ll buy you lunch!</li>
<li>Let us know when you\'ll be in the Rapid City area and make a reservation at our own campground or guest rooms.&nbsp;&nbsp;</li>
</ul>',
                'price'             => '{"amount": 18999, "currency": "USD"}',
                'status'            => 1,
                'title'             => 'Gold',
                'created_at'        => '2017-03-15 10:02:23',
                'updated_at'        => null,
                'parent_id'         => 0,
                'life_time_price'   => '',
                'price_type'        => '',
                'tax'               => '',
            ],
            [
                'id'                => 4,
                'first_line'        => 'Designed for Small Business',
                'second_line'       => 'Large volume of mail/PKGS or special handling.',
                'third_line'        => '24/7/365 Secure encrypted online account access.',
                'forth_line'        => '$200 - $500 suggested postage fund.',
                'fifth_line'        => 'Resident Agent Service Available',
                'description'       => '<p>The Platinum Plan includes all these benefits:</p>
<ul>
<li>We\'ll ship your mail AND Meds where you want, anywhere in the world, by US Postal Service or FedEx.</li>
<li><em><strong>Looking for something important? </strong></em>We\'re the only company of this type letting YOU know right away (the very same day) when you receive Certified or Registered mail.</li>
<li><em><strong>Looking for something important? </strong></em>Just e-mail us and we\'ll check for you at the end of the day when all the mail has been put up.</li>
<li>We\'ll also ship your mail anywhere, however and as often as you wish!</li>
<li>We don\'t only receive your mail, we\'ll also accept packages from USPS, UPS or FedEx.</li>
<li>You have complete control over the schedule of your shipments. Need your mail sent to Maine every second Friday but a one-time FedEx to Florida on Tuesday? No problem.</li>
<li>Access your account online 24/7/365 with your personal login. Don\'t have Internet access? That\'s okay, we have real people answering the phones during business hours.</li>
<li>If a mistake is made by our staff when sending your package of mail anywhere in the 48 states, we\'ll reimburse the USPS postage it cost to get it to you. Nobody else that we know of does this! (Some common-sense restrictions apply.)</li>
<li>We email you when your mail is sent. If it\'s sent Priority Mail, we obtain a Delivery Confirmation from the USPS <em>(at no additional charge)</em> and send an email so you know when to pick it up.</li>
<li>For Gold and Platinum plans we will sort your mail, removing junk mail, non-subscription magazines.</li>
<li>We\'ll <a href="/tips_and_tricks/27/SD-Vehicle-Registration">register and renew your vehicle</a>. Follow this link to see the costs involved.</li>
<li>Your Americas-Mailbox address gives you legal residence in South Dakota should you want it.</li>
<li>You get one additional month of membership free for every new Americas-Mailbox member you refer, or a $25 restuarant gift certificate good at about 20,000 restaurants around the country.</li>
<li>If you\'re an annual customer and you stop by our office, we\'ll buy you lunch!</li>
</ul>
<ul>
<li>Let us know when you\'ll be in the Rapid City area and make a reservation at our own campground or guest rooms.&nbsp;</li>
</ul>',
                'price'             => '{"amount": 22999, "currency": "USD"}',
                'status'            => 1,
                'title'             => 'Platinum',
                'created_at'        => '2017-03-15 09:08:37',
                'updated_at'        => null,
                'parent_id'         => 0,
                'life_time_price'   => '',
                'price_type'        => '',
                'tax'               => '',
            ],
            [
                'id'                => 5,
                'first_line'        => 'Including all services in our traditional plans - Plus',
                'second_line'       => 'Mail and Exterior scanning and so much more',
                'third_line'        => '24/7/365 Secure encrypted online account access',
                'forth_line'        => '$200 - $500 suggested postage fund.',
                'fifth_line'        => 'Resident Agent Service Available',
                'description'       => '<p><span style="font-size: 14pt;">The Platinum Plan includes all these benefits:</span></p>
<ul>
<li><span style="font-size: 14pt;">We\'ll ship your mail AND Meds where you want, anywhere in the world, by US Postal Service or FedEx.</span></li>
<li><span style="font-size: 14pt;"><em><strong>Looking for something important? </strong></em>We\'re the only company of this type letting YOU know right away (the very same day) when you receive Certified or Registered mail.</span></li>
<li><span style="font-size: 14pt;"><em><strong>Looking for something important? </strong></em>Just e-mail us and we\'ll check for you at the end of the day when all the mail has been put up.</span></li>
<li><span style="font-size: 14pt;">We\'ll also ship your mail anywhere, however, and as often as you wish!</span></li>
<li><span style="font-size: 14pt;">We don\'t only receive your mail, we\'ll also accept packages from USPS, UPS or FedEx.</span></li>
<li><span style="font-size: 14pt;">You have complete control over the schedule of your shipments. Need your mail sent to Maine every second Friday but a one-time FedEx to Florida on Tuesday? No problem.</span></li>
<li><span style="font-size: 14pt;">Access your account online 24/7/365 with your personal login. Don\'t have Internet access? That\'s okay, we have real people answering the phones during business hours.</span></li>
<li><span style="font-size: 14pt;">If a mistake is made by our staff when sending your package of mail anywhere in the 48 states, we\'ll reimburse the USPS postage it cost to get it to you. Nobody else that we know of does this! (Some common-sense restrictions apply.)</span></li>
<li><span style="font-size: 14pt;">We email you when your mail is sent. If it\'s sent Priority Mail, we obtain a Delivery Confirmation from the USPS <em>(at no additional charge)</em> and send an email so you know when to pick it up.</span></li>
<li><span style="font-size: 14pt;">For Gold and Platinum plans we will sort your mail, removing junk mail, non-subscription magazines.</span></li>
<li><span style="font-size: 14pt;">We\'ll <a href="/tips_and_tricks/27/SD-Vehicle-Registration">register and renew your vehicle</a>. Follow this link to see the costs involved.</span></li>
<li><span style="font-size: 14pt;">Your Americas-Mailbox address gives you legal residence in South Dakota should you want it.</span></li>
<li><span style="font-size: 14pt;">You get one additional month of membership free for every new Americas-Mailbox member you refer, or a $25 restaurant gift certificate good at about 20,000 restaurants around the country.</span></li>
<li><span style="font-size: 14pt;">If you\'re an annual customer and you stop by our office, we\'ll buy you lunch!</span></li>
</ul>
<ul>
<li><span style="font-size: 14pt;">Let us know when you\'ll be in the Rapid City area and make a reservation at our own campground or guest rooms.&nbsp;</span></li>
</ul>
<span style="font-size: 10pt;"><span style="font-size: 14pt;"><strong>Other Related Plans are:</strong></span><br /><br /><span style="font-size: 14pt;"><strong><a href="https://americasmailbox.com/rates_and_plans/6/Titanium-Plus" target="_blank">Titanium Plus<br /></a><a href="http://infosoftinstitute.com/rates_and_plans/6/Titanium-Plus-Quarterly-Super-Scan-for-part-time-travelers" target="_blank">Titanium Plus Quarterly Super Scan for part-time travelers</a></strong></span><br /><br /><br /></span>',
                'price'             => '{"amount": 22899, "currency": "USD"}',
                'status'            => 1,
                'title'             => 'Titanium Scanning',
                'created_at'        => '2017-03-15 09:08:37',
                'updated_at'        => null,
                'parent_id'         => 0,
                'life_time_price'   => '',
                'price_type'        => '',
                'tax'               => '',
            ],
            [
                'id'                => 6,
                'first_line'        => 'Unlimited exterior scans of the front of every envelope and package',
                'second_line'       => 'Interior scans on demand for a small additional fee',
                'third_line'        => 'Interior scans create a searchable PDF to your secure 2 GB cloud storage',
                'forth_line'        => '$250  suggested postage fund.',
                'fifth_line'        => 'Resident Agent Service Available',
                'description'       => '<p><span style="font-size: 12pt;"><strong>The Titanium Plus Plan</strong> includes all these benefits:</span><br /><br /></p>
<ul>
<li>We\'ll ship your mail AND Meds where you want, anywhere in the world, by US Postal Service or FedEx.</li>
</ul>
<ul>
<li>Looking for something important? We\'re the only company of this type letting YOU know right away (the very same day) when you receive Certified or Registered mail.</li>
</ul>
<ul>
<li>Looking for something important? If you can&rsquo;t wait until the next morning, just e-mail us and we\'ll check for you at the end of the day when all the mail has been put up.</li>
</ul>
<ul>
<li>We\'ll also ship your mail anywhere, however, and as often as you wish!</li>
</ul>
<ul>
<li>We don\'t only receive your mail, we\'ll also accept packages from USPS, UPS or FedEx.</li>
</ul>
<ul>
<li>You have complete control over the schedule of your shipments. Need your mail sent to Maine every second Friday but a one-time FedEx to Florida on Tuesday? No problem.</li>
</ul>
<ul>
<li>Access your account online 24/7/365 with your personal login. Don\'t have Internet access? That\'s okay, we have real people answering the phones during business hours.</li>
</ul>
<ul>
<li>If a mistake is made by our staff when sending your package of mail anywhere in the 48 states, we\'ll reimburse the USPS postage it cost to get it to you. Nobody else that we know of does this! (Some common-sense restrictions apply.)</li>
</ul>
<ul>
<li>We email you when your mail is sent. If it\'s sent Priority Mail, we obtain a Delivery Confirmation from the USPS (at no additional charge) and send an email so you know when to pick it up.</li>
</ul>
<ul>
<li>We will sort your mail, removing junk mail, non-subscription magazines.</li>
</ul>
<ul>
<li>We\'ll <a href="/tips_and_tricks/27/SD-Vehicle-Registration">register and renew your vehicle</a>. Follow this link to see the costs involved.</li>
</ul>
<ul>
<li>Your Americas-Mailbox address gives you legal residence in South Dakota should you want it.</li>
</ul>
<ul>
<li>You get one additional month of membership free for every new Americas-Mailbox member you refer, or a $25 restaurant gift certificate good at about 20,000 restaurants around the country.</li>
</ul>
<ul>
<li>If you\'re an annual customer and you stop by our office, we\'ll buy you lunch!</li>
</ul>
<p><br />Let us know when you\'ll be in the Rapid City area and make a reservation at our own campground or guest rooms.</p>',
                'price'             => '{"amount": 22899, "currency": "USD"}',
                'status'            => 1,
                'title'             => 'Titanium Plus',
                'created_at'        => '2017-03-15 10:02:23',
                'updated_at'        => null,
                'parent_id'         => 5,
                'life_time_price'   => '',
                'price_type'        => '',
                'tax'               => '',
            ],
            [
                'id'                => 8,
                'first_line'        => 'Unlimited exterior scans of the front of every envelope and package',
                'second_line'       => '.  Interior scans on demand for a small add fee',
                'third_line'        => 'Interior scans create a searchable PDF to your secure 2GB cloud storage',
                'forth_line'        => '$100-$150 suggested postage fund.',
                'fifth_line'        => 'Best for your extended vacation or trips',
                'description'       => '<span style="font-size: 12pt;"><strong>The Short Term Titanium Plus Plan</strong> includes all these benefits:</span><br /><br />
<ul>
<li>We\'ll ship your mail AND Meds where you want, anywhere in the world, by US Postal Service or FedEx.</li>
</ul>
<ul>
<li>Looking for something important? We\'re the only company of this type letting YOU know right away (the very same day) when you receive Certified or Registered mail.</li>
</ul>
<ul>
<li>Looking for something important? If you can&rsquo;t wait until the next morning, just e-mail us and we\'ll check for you at the end of the day when all the mail has been put up.</li>
</ul>
<ul>
<li>We\'ll also ship your mail anywhere, however and as often as you wish!</li>
</ul>
<ul>
<li>We don\'t only receive your mail, we\'ll also accept packages from USPS, UPS or FedEx.</li>
</ul>
<ul>
<li>You have complete control over the schedule of your shipments. Need your mail sent to Maine every second Friday but a one-time FedEx to Florida on Tuesday? No problem.</li>
</ul>
<ul>
<li>Access your account online 24/7/365 with your personal login. Don\'t have Internet access? That\'s okay, we have real people answering the phones during business hours.</li>
</ul>
<ul>
<li>If a mistake is made by our staff when sending your package of mail anywhere in the 48 states, we\'ll reimburse the USPS postage it cost to get it to you. Nobody else that we know of does this! (Some common-sense restrictions apply.)</li>
</ul>
<ul>
<li>We email you when your mail is sent. If it\'s sent Priority Mail, we obtain a Delivery Confirmation from the USPS (at no additional charge) and send an email so you know when to pick it up.</li>
</ul>
<ul>
<li>We will sort your mail, removing junk mail, non-subscription magazines.</li>
</ul>
<ul>
<li>We\'ll <a href="/tips_and_tricks/27/SD-Vehicle-Registration">register and renew your vehicle</a>. Follow this link to see the costs involved.</li>
</ul>
<ul>
<li>Your Americas-Mailbox address gives you legal residence in South Dakota should you want it.</li>
</ul>
<ul>
<li>You get one additional month of membership free for every new Americas-Mailbox member you refer, or a $25 restuarant gift certificate good at about 20,000 restaurants around the country.</li>
</ul>
<ul>
<li>If you\'re an annual customer and you stop by our office, we\'ll buy you lunch!</li>
</ul>
<br />Let us know when you\'ll be in the Rapid City area and make a reservation at our own campground or guest rooms.',
                'price'             => '{"amount": 7797, "currency": "USD"}',
                'status'            => 1,
                'title'             => 'Short Term Titanium Plus',
                'created_at'        => '2017-03-16 06:04:56',
                'updated_at'        => null,
                'parent_id'         => 5,
                'life_time_price'   => '',
                'price_type'        => '',
                'tax'               => '',
            ],
        ];
        $this->table('rates_and_plans')->insert($data)->save();
    }

    private function vehicles()
    {
        $table = $this->table('vehicles');
        $table
          ->addColumn('user_id', 'integer')
          ->addColumn('renew_date', 'date')
          ->create();
    }
}
