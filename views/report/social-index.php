<?php
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $website \app\models\Website */
/* @var $agency \app\models\Agency */
/* @var $sections array */
/* @var $type string */
/* @var $profile string */

\app\assets\SocialReportAsset::register($this);

echo $this->render('partial/_report_styles', ['agency' => $agency]);

if ($agency) {
    $fonts = $agency->getFontsUrls(true);
    foreach ($fonts as $font) {
        $this->registerCssFile($font);
    }
}
?>

<?= !$agency ? $this->render('/layouts/new/_header') : $this->render('partial/_agency_guest_header', [
    'agency' => $agency,
]) ?>

<?= $this->render('/layouts/new/_header_sections') ;?>

<?= $this->render('partial/_report_content', [
    'agency' => $agency,
    'website' => $website,
]) ;?>

<?= $this->render('partial/_footer'); ?>

<script type="text/javascript">
    var websiteId = '<?= $website->id ?>';
    var scoreGrades = <?= Json::encode(Yii::$app->params['scoreGrades']) ?>;
    var scoreMessages = <?= Json::encode($sections) ?>;
    var popover = <?= Yii::$app->user->can('basicPlan')? 'false' : 'true' ?>;
    var isAgency = <?= $agency? 'true' : 'false' ?>;
    var overviewChartColors = [93, 156, 236];
    var isPdfReport = false;
    var socialNetwork = '<?= $type ?>';
    var socialProfile = '<?= $profile ?>';
</script>
