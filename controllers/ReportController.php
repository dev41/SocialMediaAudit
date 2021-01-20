<?php

namespace app\controllers;

use app\models\checks\FacebookChecks;
use app\models\checks\InstagramChecks;
use app\models\checks\TwitterChecks;
use app\models\checks\YoutubeChecks;
use app\models\User;
use app\models\Agency;
use app\models\AgencyLead;
use app\models\Check;
use app\models\Website;
use app\models\checks\HtmlChecks;
use app\models\checks\SocialChecks;
use app\models\checks\Utils;
use app\services\CheckService;
use app\services\AgencyService;
use app\services\SocialCheckService;
use app\services\FacebookCheckService;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ReportController extends Controller
{
    public $website;
    /** @var Agency */
    public $agency;

    const MOVED_PERMANENTLY = 301;

    public $rootHost;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'website'             => ['get', 'post', 'head', 'options'],
                    'social-profile'             => ['get', 'post', 'head', 'options'],
                    'download-pdf'      => ['get', 'head', 'options'],
                    '*'                 => ['post', 'head', 'options'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {

        // disable csrf for request pdf (I don't know why it is not working)
        if ( in_array($this->action->id, ['request-pdf', 'index']) || Yii::$app->request->isDebug()){
            $this->enableCsrfValidation = false;
        }

        $parent = parent::beforeAction($action);
        if (!$parent) {
            return false;
        }

        $hostName = Yii::$app->request->hostName;
        $hostUrlParts = parse_url(Yii::$app->request->hostInfo);
        $this->rootHost = $hostUrlParts['scheme'].'://'. substr($hostName, strpos($hostName, '.') + 1);

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $wid = Yii::$app->request->post('wid');
            if ( $testWid = Yii::$app->request->isDebug() ){
                $wid = $testWid;
            }

            // maybe domain is set instead
            if ( !is_null(Yii::$app->request->post('domain')) ) {
                $website = Website::prepare(Yii::$app->request->post('domain'));
                if ( !is_null($website) ) {
                    $wid = $website->id;
                }
            }

            if ( empty($wid) ) {
                throw new BadRequestHttpException(Yii::t('yii', 'Wrong request parameters'));
            }
            $this->website = Website::findOne($wid);
            if ( empty($this->website) ) {
                throw new BadRequestHttpException(Yii::t('yii', 'Wrong request parameters'));
            }

            // make session free so other requests can run simultaneously
            Yii::$app->session->close();
        }

        Yii::$app->params['checks'] = include Yii::$app->basePath.'/config/checks.php';
        Check::$allowedChecks = array_keys(Yii::$app->params['checks']);

        // agency subdomain for customization
        // set parent agency if subdomain is set
        if (preg_match_all("/\./", $hostName) == 2) {
            $subDomain = substr($hostName, 0, strpos($hostName, '.'));
            if ($subDomain !== 'www') {
                // check that the agency user exists and is active
                $this->agency = Agency::findOne([
                    'subdomain' => $subDomain,
                ]);
                if (empty($this->agency) || !$this->agency->user->active) {
                    return $this->redirect($this->rootHost . '/' . ltrim(Yii::$app->request->url, '/'),self::MOVED_PERMANENTLY);
                }else{
                    $this->view->params['agency'] = $this->agency;
                }

                if ($this->agency->user->isSuspended()) {
                    Yii::$app->session->setFlash('alert', "This functionality is not available as this account has been suspended. Please pay any outstanding Invoices via the <a class='alert-link-danger' href='/dashboard'>Dashboard</a> or contact support.", false);
                    return $this->redirect($this->rootHost . '/' . ltrim(Yii::$app->request->url, '/'),self::MOVED_PERMANENTLY);
                }
                if ($this->agency->checks) {
                    Check::$allowedChecks = explode(',', $this->agency->checks);
                }
                if ($this->agency->language) {
                    Yii::$app->language = $this->agency->language;
                }
            }
        }

        return true;
    }

    public function actionWebsite($value)
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $hostName = Yii::$app->request->hostName;
        $page = ltrim($value, '/');
        $pageInit = $page;
        $isGuest = Yii::$app->user->isGuest;
        $isSuspended = true;

        if (
            (($identity = Yii::$app->user->identity) && !$identity->isSuspended())
            || $this->agency
        ){
            $isSuspended = false;
        }

        //replace a unneded params
        $replacedPageUrl = preg_replace('/&utm_source=(.*)&utm_medium=(.*)&utm_campaign=(.*)/i','',$page);
        if ( empty($replacedPageUrl) ){
            //on preg error
        }else{
            $page = $replacedPageUrl;
        }

        // check access to subpages (exclude wkhtmltopdf)
        $urlParts = parse_url(Yii::$app->request->hostInfo);
        $page = ltrim($page, '/');
        $page = preg_replace("(https?://)", "", $page);
        $isSubPage = strpos(rtrim($page,'/'), '/') !== false; //ignore like https://dfgdfgdfg.com/
        $isPdfRequest = strpos(Yii::$app->request->userAgent, 'wkhtmltopdf') !== false; //request of pdf renderer service

        if ($this->agency && !AgencyService::canShowAgencyReport($this->agency)) {
            throw new ForbiddenHttpException('This account has been disabled');
        }

        if ($isSubPage && !$isPdfRequest && (!Yii::$app->user->can(User::ROLE_BASIC) || $isSuspended) && !$this->agency) {
            if ($isGuest){
                Yii::$app->session->addFlash('alert', "You can only run audits for Sub-Pages on the <a class='alert-link-danger' href='/white-label'>Premium Plans</a>. Your report will default to showing the report for the homepage", false);

            }elseif($isSuspended){
                Yii::$app->session->setFlash('alert', "This functionality is not available as this account has been suspended. Please pay any outstanding Invoices via the <a class='alert-link-danger' href='/myaccount'>My Account</a> page or contact support", false);

            }else{
                Yii::$app->session->addFlash('alert', "You can only run audits for Sub-Pages on the <a class='alert-link-danger' href='/white-label'>Premium Plans</a>. Your report will default to showing the report for the homepage", false);

            }
            $page = substr($page, 0, strpos($page, '/'));
        }

        // check website
        $website = Website::prepare($page);
        $notFoundMessage = <<<MSG
For whatever reason, the page could not be loaded. The domain may not actually be registered, the server may not be responding, or a page may not exist at this location. Please try a different URL
MSG;

        if ( is_null($website) ) {
            $this->view->title = 'Page Not Found - Socialmediaaudit';
            throw new NotFoundHttpException( $notFoundMessage );
        } else {
            if ($website->domain != $page) {
                $page = $website->domain;
            }
            if ($website->domain != strtolower($pageInit)) {
                return $this->redirect('/' . $website->domain,self::MOVED_PERMANENTLY);
            }
        }

        // refresh report data
        if ( Yii::$app->request->post('refresh') ) {
            HtmlChecks::flushCache($website->domain);
            $website->touch('modified');
            $website->modified = date('Y-m-d H:i');
            Check::deleteAll([
                'wid' => $website->id,
            ]);
        }

        $this->view->title = Yii::t('report', 'Website review').' | '.$website->domain;
        if ( \Yii::$app->request->isMainDomain() ) {
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $this->view->title]);
            $this->view->registerMetaTag(['name' => 'description', 'content' => $this->view->title]);
            $this->view->registerMetaTag(['name' => 'og:title', 'content' => $this->view->title]);
            $this->view->registerMetaTag(['name' => 'og:description', 'content' => $this->view->title]);
            $this->view->registerMetaTag(['name' => 'og:url',           'content' => "https://{$hostName}/{$page}"]);
            $this->view->registerMetaTag(['name' => 'og:image', 'content' => 'https://www.seoptimer.com/wp-content/themes/startit/assets/img/seoptimerlogo.png']);
            $this->view->registerLinkTag(['rel' => 'canonical', 'href' => 'https://www.' . Yii::$app->params['domain']]);
        }
        
        return $this->render($isPdfRequest ? 'pdf_report' : 'index', [
            'website' => $website,
            'agency' => $this->agency,
            'sections' => include Yii::$app->basePath.'/config/sections.php',
        ]);
    }

    public function actionSocialProfile($type, $value)
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $hostName = Yii::$app->request->hostName;
        $page = $type.'.com/'.$value;
        $pageInit = $page;

        //replace a unneded params
        $replacedPageUrl = preg_replace('/&utm_source=(.*)&utm_medium=(.*)&utm_campaign=(.*)/i','',$page);
        if ( empty($replacedPageUrl) ){
            //on preg error
        }else{
            $page = $replacedPageUrl;
        }
        $isPdfRequest = strpos(Yii::$app->request->userAgent, 'wkhtmltopdf') !== false; //request of pdf renderer service

        // check website
        $website = Website::prepare($page);
        $notFoundMessage = <<<MSG
For whatever reason, the page could not be loaded. The domain may not actually be registered, the server may not be responding, or a page may not exist at this location. Please try a different URL
MSG;

        if ( is_null($website) ) {
            $this->view->title = 'Page Not Found - Socialmediaaudit';
            throw new NotFoundHttpException( $notFoundMessage );
        } else {
            if ($website->domain != $page) {
                $page = $website->domain;
            }
            if ($website->domain != strtolower($pageInit)) {
                return $this->redirect('/' . $website->domain,self::MOVED_PERMANENTLY);
            }
        }

        // refresh report data
        if ( Yii::$app->request->post('refresh') ) {
            HtmlChecks::flushCache($website->domain);
            $website->touch('modified');
            $website->modified = date('Y-m-d H:i');
            Check::deleteAll([
                'wid' => $website->id,
            ]);
        }

        $this->view->title = Yii::t('report', ucfirst($type).' review').' | '.$website->domain;
        if ( \Yii::$app->request->isMainDomain() ) {
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $this->view->title]);
            $this->view->registerMetaTag(['name' => 'description', 'content' => $this->view->title]);
            $this->view->registerMetaTag(['name' => 'og:title', 'content' => $this->view->title]);
            $this->view->registerMetaTag(['name' => 'og:description', 'content' => $this->view->title]);
            $this->view->registerMetaTag(['name' => 'og:url',           'content' => "https://{$hostName}/{$page}"]);
            $this->view->registerMetaTag(['name' => 'og:image', 'content' => 'https://www.seoptimer.com/wp-content/themes/startit/assets/img/seoptimerlogo.png']);
            $this->view->registerLinkTag(['rel' => 'canonical', 'href' => 'https://www.' . Yii::$app->params['domain']]);
        }

        return $this->render($isPdfRequest ? 'pdf_social' : 'social-index', [
            'website' => $website,
            'agency' => $this->agency,
            'sections' => include Yii::$app->basePath.'/config/sections.php',
            'type' => $type,
            'profile' => $value,
        ]);
    }

    public function actionRequestPdf(){

        if ( Yii::$app->request->isAuditDomain() ){
            //nothing
        }else{
            if ( Yii::$app->user->isGuest || !Yii::$app->user->can(User::ROLE_BASIC) ){
                Yii::$app->session->addFlash('alert', "You can only run Pdf Reports on the <a class='alert-link-danger' href='/white-label'>Premium Plans</a>. Your report will default to showing the report for the homepage.", false);
                return $this->redirect($this->rootHost.'/website/'.$this->website->domain,self::MOVED_PERMANENTLY); //for pdf request is normal
            }

            $isSuspended = (($identity = Yii::$app->user->identity) && $identity->isSuspended()) ? true : false;

            if ($isSuspended){
                Yii::$app->session->setFlash('alert', "This functionality is not available as this account has been suspended. Please pay any outstanding Invoices via the <a target='_blank' class='alert-link' href='/dashboard'><b><u>Dashboard</u></b></a> or contact support.", false);
                return $this->redirect($this->rootHost.'/website/'.$this->website->domain,self::MOVED_PERMANENTLY); //for pdf request is normal
            }
        }


        Yii::$app->response->format = Response::FORMAT_HTML;
       // $this->layout = false;

        return $this->render('pdf_loader',[
            'website'   => $this->website,
            'agency'    => $this->agency,
            'lead'      => '',
        ]);

    }

    /**
     * wkhtmltopdf process and return pdf tmp name
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionPreparePdf()
    {
        $hostName = Yii::$app->request->hostName;
        if ( empty($this->agency) ) {
            Yii::$app->session->addFlash('alert', 'A PDF report could not be generated for this page.', false);
            return [
                'success'   => false,
                'link'      => "//{$hostName}/website/{$this->website->domain}",
                'message'   => 'Agency profile not found or not active',
            ];
        }

        if ( $this->agency->user->isSuspended() ){
            Yii::$app->session->setFlash('alert', "This functionality is not available as this account has been suspended. Please pay any outstanding Invoices via the <a class='alert-link-danger' href='/dashboard'>Dashboard</a> or contact support.", false);
            return [
                'success'   => false,
                'link'      => "//{$hostName}/website/{$this->website->domain}",
                'message'   => 'Agency profile is suspended',
            ];
        }

        $tempName = Yii::$app->security->generateRandomString(16);
        $filename = Yii::$app->runtimePath.'/pdf/'.$tempName;
        $url = Yii::$app->urlManager->createAbsoluteUrl('').'website/'.$this->website->domain . '?format=pdf';
        $command = Utils::preparePdfCommand($url, $filename);
        //print_r($command);die;
        //$output = shell_exec($command);
        //Yii::info("PDF requested for {$url}", 'stat');
        Utils::execute($command, null, $output, $output, 80);
        //print_r($output);die;

        if ( !file_exists($filename) ) {

            Yii::warning("PDF failed for {$url}", 'stat');

            Yii::$app->session->addFlash('alert', 'A PDF report could not be generated for this page.', false);
            return [
                'success'   => false,
                'link'      => "//{$hostName}/website/{$this->website->domain}",
                'message'   => print_r($output, true),
            ];
        }


        $leadId = Yii::$app->request->post('leadId');

        if (!empty($leadId)) { // continue process embed form (see SiteController)
            $leadModel = AgencyLead::findOne($leadId);
            $this->agency->emailCustomer($leadModel->email, $filename);
            if ($this->agency->webhook_pdf) {
                $this->agency->sendWebhook($leadId, Yii::$app->urlManager->createAbsoluteUrl('').'download-pdf.inc/'.$tempName);
            }
        }

        return [
            'success' => true,
            'pdf' => $tempName,
        ];
    }

    /**
     * download and remove pdf file
     * @param $name
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionDownloadPdf($name)
    {
        $filename = Yii::$app->runtimePath.'/pdf/'.$name;
        if ( !file_exists($filename) ) {
            throw new NotFoundHttpException('Pdf file does not exist');
        }

        return Yii::$app->response->sendFile($filename, 'report.pdf', [
            'inline' => true,
            'mimeType' => 'application/pdf',
        ]);
    }

    /**
     * @return array
     */
    public function actionCheckHtml()
    {
        $provider = new HtmlChecks($this->website->domain);
        // TODO move response checks into model
        if (!$provider->html || $provider->responseCode != 200) {
            $message = Yii::t('report', "This webpage has returned no content to our crawler, meaning results shown in this report may not be accurate. Either this page genuinely has no content, or a security mechanism has been applied preventing crawler's like ours viewing the content successfully.");
            if ($provider->responseCode == 404) $message = Yii::t('report', 'Your website server is reporting a "Page Not Found" (404) error for this page. Please check that the page URL you have entered is correct, is published, and that there are no problems preventing it\'s display.');
            elseif ($provider->responseCode >= 400 && $provider->responseCode < 500) $message = Yii::t('report', 'Your server is reporting that the specific page is not accessible to us (Code {code}). Please check that the page URL you have entered is correct, is published, and that there are no problems preventing it\'s display.', ['code' => $provider->responseCode]);
            elseif ($provider->responseCode >= 500) $message = Yii::t('report', 'Your website server is reporting a Server Error ({code}) whilst loading this page, which could be from a configuration or coding problem. We recommend resolving this as a priority.', ['code' => $provider->responseCode]);

            return [
                'success' => false,
                'message' => $message,
            ];
        }

        $service = new CheckService($provider, $this->website->id);
        return $service->run('profiles');
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCheckFacebook()
    {
        $provider = new FacebookChecks(Yii::$app->request->post('pid'));
        $service = new CheckService($provider, $this->website->id);
        return $service->run('facebook');
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCheckFacebookPosts()
    {
        $provider = new FacebookChecks(Yii::$app->request->post('pid'));
        $service = new CheckService($provider, $this->website->id);
        return $service->run('facebookPosts');
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCheckInstagram()
    {
        $provider = new InstagramChecks(Yii::$app->request->post('pid'));
        $service = new CheckService($provider, $this->website->id);
        return $service->run('instagram');
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCheckTwitter()
    {
        $provider = new TwitterChecks(Yii::$app->request->post('pid'));
        $service = new CheckService($provider, $this->website->id);
        return $service->run('twitter');
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCheckYoutube()
    {
        $provider = new YoutubeChecks(Yii::$app->request->post('pid'));
        $service = new CheckService($provider, $this->website->id);
        return $service->run('youtube');
    }
}
