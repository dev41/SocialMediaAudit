<?php
use yii\bootstrap\Html;
$active = array_flip(explode(',', $active));

$structure = [
    'Your Website' => [
        'socialActivity' => 'Social Shares',
    ],
    'Facebook' => [
        'hasFacebook' => 'Facebook Page Connected',
        'facebookActivity' => 'Facebook Page Activity',
    ],
    'Twitter' => [
        'hasTwitter' => 'Twitter Connected',
        'twitterActivity' => 'Twitter Activity',
    ],
    'Instagram' => [
        'hasInstagram' => 'Instagram Connected',
        'instagramActivity' => 'Instagram Activity',
    ],
    'YouTube' => [
        'hasYoutube' => 'YouTube Connected',
        'youtubeActivity' => 'YouTube Activity',
    ],
    'LinkedIn' => [
        'hasLinkedIn' => 'LinkedIn Connected',
    ],
];

function customCheckbox($name, $id, $title, $checked = false)
{
    $checked = $checked ? 'checked' : '';

    return <<<HTML
    <div class="row lockable">
        <div class="col-xs-12">
            <div class="input-checkbox">
                <input name="$name" type="checkbox" id="check-$id" value="$id" $checked/>
                <label for="check-$id"></label>
            </div>
            <span>$title</span>        
        </div>
    </div>
HTML;
}
?>
    <div class="boxed boxed--border"?>
        <h3 class="m-t-0 header-title"><?= Yii::t('app', 'Include Checks and Sections') ?></h3>
        <div class="row">
            <div class="col-md-12">
                <div class="errorMessage" id="check-require" style="display: none;">At least one check must be enabled to display a report.</div>
                <?php
                $i = 1;
                foreach ($structure as $section => $items) {
                    echo '<div class="section">';
                    echo '<label><div class="section-button">-</div>'.$section.'</label>';
                    foreach ($items as $id => $title) {
                        // subsections?
                        if (is_array($title)) {
                            echo '<div class="subsection">';
                            echo '<div class="subsection-header">'.$id.'</div>';
                            foreach ($title as $itemId => $itemTitle) {
                                echo customCheckbox('BrandingForm[checks][]', $itemId, $itemTitle, isset($active[$itemId]));
                            }
                            echo '</div>';
                        } else {
                            echo customCheckbox('BrandingForm[checks][]', $id, $title, isset($active[$id]));
                        }
                    }
                    echo '</div>';
                    $i ++;
                }
                ?>
            </div>
        </div>
        <?= Html::hiddenInput('BrandingForm[checks][]', 'subpages') ?>
    </div>
<?php
$this->registerJs("
    $('.section-button').on('click touch', function(){
        if ($(this).text() === '-') {
            $(this).text('+').closest('.section').addClass('closed');
        } else {
            $(this).text('-').closest('.section').removeClass('closed');
        }
    });
    $('#agency-settings-form').on('submit', function(){
        if ($('input[name=\"BrandingForm[checks][]\"]:checked').length === 0) {
            $('#check-require').show();
            $('#check-title').focus();
            return false;        
        }
    });
");
?>